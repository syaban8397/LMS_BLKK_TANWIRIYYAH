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
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('participant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('assignment_score', 5, 2)
                ->default(0);

            $table->decimal('attendance_score', 5, 2)
                ->default(0);

            $table->decimal('final_score', 5, 2)
                ->default(0);

            $table->text('feedback')->nullable();

            $table->enum('status', [
                'pass',
                'fail'
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_grades');
    }
};
