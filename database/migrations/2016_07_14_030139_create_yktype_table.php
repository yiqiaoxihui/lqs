<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYktypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yktypes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('year');
            $table->integer('solider');
            $table->integer('child');
            $table->integer('childfree');
            $table->integer('older');
            $table->integer('adult');
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
        //
    }
}
