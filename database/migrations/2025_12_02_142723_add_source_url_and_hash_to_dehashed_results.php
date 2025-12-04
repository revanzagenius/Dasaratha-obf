<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('dehashed_results', function (Blueprint $table) {
        $table->text('source_url')->nullable()->after('password');
        $table->text('hash')->nullable()->after('source_url');
    });
}

public function down()
{
    Schema::table('dehashed_results', function (Blueprint $table) {
        $table->dropColumn(['source_url', 'hash']);
    });
}

};
