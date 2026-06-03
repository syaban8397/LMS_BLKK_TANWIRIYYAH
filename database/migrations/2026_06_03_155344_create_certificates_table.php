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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('participant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('class_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('certificate_number')
                ->unique();

            $table->decimal('final_score', 5, 2);

            $table->decimal('attendance_percentage', 5, 2);

            $table->string('qr_code');

            $table->string('pdf_file');

            $table->dateTime('issued_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
