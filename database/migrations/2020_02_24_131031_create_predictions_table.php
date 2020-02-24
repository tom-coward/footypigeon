<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePredictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('round_id');
            $table->boolean('result_recorded')->default(false);
            $table->string('ko_time');
            $table->integer('home_team_id');
            $table->string('home_team_name');
            $table->integer('away_team_id');
            $table->string('away_team_name');
            $table->integer('home_team_goals')->default(0);
            $table->integer('away_team_goals')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predictions');
    }
}
