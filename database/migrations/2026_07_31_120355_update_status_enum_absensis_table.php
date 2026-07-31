<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE absensis
            MODIFY status ENUM(
                'Hadir',
                'Terlambat',
                'Izin',
                'Sakit',
                'Alpha'
            ) DEFAULT 'Hadir'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE absensis
            MODIFY status ENUM(
                'Hadir',
                'Izin',
                'Sakit',
                'Alpha'
            ) DEFAULT 'Hadir'
        ");
    }
};