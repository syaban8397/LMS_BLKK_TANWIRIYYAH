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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('participant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('url')->nullable();

            $table->text('notes')->nullable();

            $table->decimal('score', 5, 2)->nullable();

            $table->text('feedback')->nullable();

            $table->timestamp('submitted_at')->nullable();

            $table->enum('status', [
                'submitted',
                'late',
                'graded'
            ])->default('submitted');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
