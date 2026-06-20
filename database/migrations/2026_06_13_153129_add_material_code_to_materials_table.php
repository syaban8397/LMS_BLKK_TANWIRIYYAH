<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Duplicate of 2026_06_13_150000_add_material_code_to_materials_table.
     * Kept as no-op for environments that already ran this migration batch.
     */
    public function up(): void
    {
        if (Schema::hasColumn('materials', 'material_code')) {
            return;
        }

        Schema::table('materials', function (Blueprint $table) {
            $table->string('material_code', 50)->nullable()->after('title');
        });
    }

    public function down(): void
    {
        // Column lifecycle is owned by 2026_06_13_150000_add_material_code_to_materials_table.
    }
};
