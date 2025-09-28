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
        Schema::table('activities', function (Blueprint $table) {
            // Kode untuk menambah kolom diletakkan di sini
            $table->string('status')->default('pending')->after('thumbnail');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Kode untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn(['status', 'rejection_reason']);
        });
    }
};