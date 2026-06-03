<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'instruktur', 'peserta'])->default('peserta');

            $table->string('nik', 50);
            $table->string('phone', 20);

            $table->enum('gender', ['L', 'P']);

            $table->string('birth_place');
            $table->date('birth_date');

            $table->text('address');

            $table->string('photo')->nullable();

            $table->text('bio')->nullable();

            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
