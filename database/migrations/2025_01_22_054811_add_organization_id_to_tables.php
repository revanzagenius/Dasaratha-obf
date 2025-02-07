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
        // Menambahkan kolom organization_id ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id'); // Tambahkan setelah kolom id
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        // Menambahkan kolom organization_id ke tabel domains
        Schema::table('domains', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        // Menambahkan kolom organization_id ke tabel ports
        Schema::table('ports', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        // Menambahkan kolom organization_id ke tabel vulnerabilities
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        Schema::table('dehashed_results', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id'); // Tambahkan setelah kolom id
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom organization_id dari tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });

        // Menghapus kolom organization_id dari tabel domains
        Schema::table('domains', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });

        // Menghapus kolom organization_id dari tabel ports
        Schema::table('ports', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });

        // Menghapus kolom organization_id dari tabel vulnerabilities
        Schema::table('vulnerabilities', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
        // Menghapus kolom organization_id dari tabel dehashed_results
        Schema::table('dehashed_results', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
    }
};
