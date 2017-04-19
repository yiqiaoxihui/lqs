<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYknumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yknumbers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->date('month');
            $table->integer('number');
            $table->integer('team');//团队
            $table->integer('individual');//散客
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
