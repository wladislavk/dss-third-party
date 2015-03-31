<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilemanagerDvdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filemanager_dvd', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('docid');
            $table->string('name', 30);
            $table->string('type', 30);
            $table->integer('size');
            $table->string('ext', 20);
            $table->binary('content');
            
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
        Schema::drop('filemanager_dvd');
    }
}
