<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function(Blueprint $table)
        {
            $table->increments('pageid');

            $table->string('title')->nullable()->default('');
            $table->string('keywords', 1000)->nullable()->default('');
            $table->string('status', 1)->nullable()->default('');
            $table->string('top_image', 2048)->nullable()->default('');
            $table->string('ip_address')->nullable();

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
        Schema::drop('pages');
    }

}
