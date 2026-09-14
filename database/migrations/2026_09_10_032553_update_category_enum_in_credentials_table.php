<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify ENUM to add 'Pribadi' value
        DB::statement("ALTER TABLE credentials MODIFY COLUMN category ENUM('Email','Server','Aplikasi','Pribadi','Lainnya') NOT NULL DEFAULT 'Lainnya'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE credentials MODIFY COLUMN category ENUM('Email','Server','Aplikasi','Lainnya') NOT NULL DEFAULT 'Lainnya'");
    }
};
