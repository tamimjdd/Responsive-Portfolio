<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravellikecommentTotalLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laravellikecomment_total_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_id'); // ModelName_modelId
            $table->bigInteger('total_like');
            $table->bigInteger('total_dislike');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('laravellikecomment_like_totals');
    }
}
