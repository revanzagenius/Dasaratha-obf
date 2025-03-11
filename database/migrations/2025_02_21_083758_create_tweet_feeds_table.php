<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tweet_feeds', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('user');
            $table->string('type');
            $table->text('value');
            $table->json('tags');
            $table->string('tweet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tweet_feeds');
    }
};
