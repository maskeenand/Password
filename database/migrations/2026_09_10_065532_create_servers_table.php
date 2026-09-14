<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('ip_address');
            $table->unsignedSmallInteger('port')->default(22);
            $table->enum('type', ['VPS', 'Dedicated', 'Cloud', 'Lokal', 'Lainnya'])->default('VPS');
            $table->enum('os', ['Ubuntu', 'Debian', 'CentOS', 'Rocky Linux', 'Windows Server', 'Lainnya'])->default('Ubuntu');
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Maintenance'])->default('Aktif');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
