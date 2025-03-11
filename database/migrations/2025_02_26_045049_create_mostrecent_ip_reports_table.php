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
        Schema::create('mostrecent_ip_reports', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->unique();
            $table->string('risk_level')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mostrecent_ip_reports');
    }
};
