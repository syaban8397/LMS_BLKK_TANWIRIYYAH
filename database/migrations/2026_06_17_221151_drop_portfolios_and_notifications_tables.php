<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('portfolios');
    }

    public function down(): void
    {
        // Fitur portofolio dan notifikasi tidak digunakan lagi.
    }
};
