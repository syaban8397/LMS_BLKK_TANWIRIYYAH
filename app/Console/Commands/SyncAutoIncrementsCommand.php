<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncAutoIncrementsCommand extends Command
{
    protected $signature = 'lms:sync-auto-increments
                            {--renumber-users : Renumber user IDs sequentially from 1 without deleting rows}';

    protected $description = 'Reset AUTO_INCREMENT counters (and optionally compact user IDs) without deleting data';

    /** @var list<string> */
    private array $userForeignKeyColumns = [
        'sessions' => ['user_id'],
        'classes' => ['instructor_id'],
        'class_participants' => ['participant_id'],
        'materials' => ['created_by'],
        'assignments' => ['created_by'],
        'submissions' => ['participant_id'],
        'attendances' => ['participant_id', 'created_by', 'updated_by'],
        'final_grades' => ['participant_id'],
        'certificates' => ['participant_id'],
        'announcements' => ['created_by'],
        'material_progress' => ['participant_id'],
        'audit_logs' => ['user_id'],
    ];

    public function handle(): int
    {
        if ($this->option('renumber-users')) {
            $this->renumberUsers();
        }

        $this->syncAllAutoIncrements();

        $this->info('AUTO_INCREMENT counters synced. No rows were deleted.');

        return self::SUCCESS;
    }

    private function renumberUsers(): void
    {
        if (! Schema::hasTable('users')) {
            $this->warn('Table users not found.');

            return;
        }

        $users = DB::table('users')->orderBy('id')->get(['id']);

        if ($users->isEmpty()) {
            $this->line('No users to renumber.');

            return;
        }

        $mapping = [];
        $nextId = 1;

        foreach ($users as $user) {
            $oldId = (int) $user->id;

            if ($oldId !== $nextId) {
                $mapping[$oldId] = $nextId;
            }

            $nextId++;
        }

        if ($mapping === []) {
            $this->line('User IDs already sequential from 1.');

            return;
        }

        $this->info('Renumbering '.count($mapping).' user ID(s) without deleting data...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            $tempOffset = 1_000_000;

            foreach ($mapping as $oldId => $newId) {
                $tempId = $oldId + $tempOffset;

                DB::table('users')->where('id', $oldId)->update(['id' => $tempId]);
                $this->updateUserForeignKeys($oldId, $tempId);

                if (Schema::hasTable('model_has_roles')) {
                    DB::table('model_has_roles')
                        ->where('model_type', 'App\\Models\\User')
                        ->where('model_id', $oldId)
                        ->update(['model_id' => $tempId]);
                }

                if (Schema::hasTable('model_has_permissions')) {
                    DB::table('model_has_permissions')
                        ->where('model_type', 'App\\Models\\User')
                        ->where('model_id', $oldId)
                        ->update(['model_id' => $tempId]);
                }
            }

            foreach ($mapping as $oldId => $newId) {
                $tempId = $oldId + $tempOffset;

                DB::table('users')->where('id', $tempId)->update(['id' => $newId]);
                $this->updateUserForeignKeys($tempId, $newId);

                if (Schema::hasTable('model_has_roles')) {
                    DB::table('model_has_roles')
                        ->where('model_type', 'App\\Models\\User')
                        ->where('model_id', $tempId)
                        ->update(['model_id' => $newId]);
                }

                if (Schema::hasTable('model_has_permissions')) {
                    DB::table('model_has_permissions')
                        ->where('model_type', 'App\\Models\\User')
                        ->where('model_id', $tempId)
                        ->update(['model_id' => $newId]);
                }
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $this->info('User IDs now run from 1 to '.($nextId - 1).'.');
    }

    private function updateUserForeignKeys(int $fromId, int $toId): void
    {
        foreach ($this->userForeignKeyColumns as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    continue;
                }

                DB::table($table)->where($column, $fromId)->update([$column => $toId]);
            }
        }
    }

    private function syncAllAutoIncrements(): void
    {
        $database = DB::getDatabaseName();
        $tables = DB::select(
            'SELECT TABLE_NAME AS name, AUTO_INCREMENT AS auto_increment
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = ? AND AUTO_INCREMENT IS NOT NULL
             ORDER BY TABLE_NAME',
            [$database]
        );

        foreach ($tables as $table) {
            $name = $table->name;

            if (! Schema::hasColumn($name, 'id')) {
                continue;
            }

            $maxId = (int) DB::table($name)->max('id');
            $next = max(1, $maxId + 1);

            DB::statement("ALTER TABLE `{$name}` AUTO_INCREMENT = {$next}");

            $this->line("{$name}: next id = {$next}");
        }
    }
}
