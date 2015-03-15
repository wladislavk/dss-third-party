<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFlowPg1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_flow_pg1', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('copyreqdate');
            $table->string('referred_by');
            $table->string('thxletter');
            $table->string('queststartdate');
            $table->string('questcompdate');
            $table->string('insinforec');
            $table->string('rxreq');
            $table->string('rxrec');
            $table->string('lomnreq');
            $table->string('lomnrec');
            $table->string('clinnotereq');
            $table->string('clinnoterec');
            $table->string('contact_location');
            $table->string('questsendmeth');
            $table->string('questsender');
            $table->string('refneed');
            $table->string('refneeddate1');
            $table->string('refneeddate2');
            $table->string('preauth');
            $table->string('preauth1');
            $table->string('preauth2');
            $table->string('insverbendate1');
            $table->string('insverbendate2');
            $table->string('pid');
            $table->string('referreddate');
            $table->integer('rx_imgid')->nullable();
            $table->integer('lomn_imgid')->nullable();
            $table->integer('notes_imgid')->nullable();
            $table->integer('rxlomn_imgid')->nullable();
            $table->string('rxlomnrec')->nullable();

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
        Schema::drop('dental_flow_pg1');
    }
}
