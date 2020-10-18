<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedHashtagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_hashtag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_id');
            $table->foreignId('hashtag_id');
            $table->timestamps();

            $table->unique(['feed_id', 'hashtag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_hashtag');
    }
}
