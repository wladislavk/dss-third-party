<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdxCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edx_certificates', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('url', 200)->nullable();
            $table->integer('edx_id')->nullable();
            $table->string('course_name', 200)->nullable();
            $table->string('course_section', 200)->nullable();
            $table->string('course_subsection', 200)->nullable();
            $table->integer('number_ce')->nullable();
            $table->string('ip_address', 50)->nullable();

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
        Schema::drop('edx_certificates');
    }
}
