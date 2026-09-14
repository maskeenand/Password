<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE servers MODIFY COLUMN type ENUM('VPS','Dedicated','Cloud','VM','Lokal','Lainnya') NOT NULL DEFAULT 'VPS'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE servers MODIFY COLUMN type ENUM('VPS','Dedicated','Cloud','Lokal','Lainnya') NOT NULL DEFAULT 'VPS'");
    }
};
