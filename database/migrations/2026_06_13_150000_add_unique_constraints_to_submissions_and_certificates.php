<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->removeDuplicateSubmissions();
        $this->removeDuplicateCertificates();

        Schema::table('submissions', function (Blueprint $table) {
            $table->unique(
                ['assignment_id', 'participant_id'],
                'submissions_assignment_participant_unique'
            );
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->unique(
                ['class_id', 'participant_id'],
                'certificates_class_participant_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropUnique('submissions_assignment_participant_unique');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropUnique('certificates_class_participant_unique');
        });
    }

    private function removeDuplicateSubmissions(): void
    {
        $duplicateGroups = DB::table('submissions')
            ->select('assignment_id', 'participant_id', DB::raw('COUNT(*) as total'))
            ->groupBy('assignment_id', 'participant_id')
            ->having('total', '>', 1)
            ->get();

        foreach ($duplicateGroups as $group) {
            $ids = DB::table('submissions')
                ->where('assignment_id', $group->assignment_id)
                ->where('participant_id', $group->participant_id)
                ->orderByDesc('id')
                ->pluck('id');

            DB::table('submissions')
                ->whereIn('id', $ids->slice(1)->all())
                ->delete();
        }
    }

    private function removeDuplicateCertificates(): void
    {
        $duplicateGroups = DB::table('certificates')
            ->select('class_id', 'participant_id', DB::raw('COUNT(*) as total'))
            ->groupBy('class_id', 'participant_id')
            ->having('total', '>', 1)
            ->get();

        foreach ($duplicateGroups as $group) {
            $ids = DB::table('certificates')
                ->where('class_id', $group->class_id)
                ->where('participant_id', $group->participant_id)
                ->orderByDesc('id')
                ->pluck('id');

            DB::table('certificates')
                ->whereIn('id', $ids->slice(1)->all())
                ->delete();
        }
    }
};
