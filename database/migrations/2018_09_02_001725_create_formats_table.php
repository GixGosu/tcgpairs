<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();

            $table->string('title');
            $table->string('type')->nullable();
            $table->integer('number_of_teams')->default(2);
            $table->integer('team_size')->default(1);
            $table->integer('is_slotted')->default(0);
            $table->integer('is_draft')->default(0);
            $table->integer('is_ffa')->default(0);

            $table->integer('order_column')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formats');
    }
}
