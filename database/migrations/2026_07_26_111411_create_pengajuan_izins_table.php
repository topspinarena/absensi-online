<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_izins', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('jenis', [
                'Izin',
                'Sakit',
                'Off',
                'Cuti'
            ]);

            $table->text('alasan');

            $table->string('lampiran')->nullable();

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izins');
    }
};