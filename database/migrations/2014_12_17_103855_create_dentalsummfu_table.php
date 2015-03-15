<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalsummfuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentalsummfu', function(Blueprint $table)
        {
            $table->increments('followupid');

            $table->integer('patientid');
            $table->date('ep_dateadd');
            $table->string('devadd');
            $table->string('dsetadd');
            $table->string('ep_eadd');
            $table->string('ep_tsadd');
            $table->string('ep_sadd');
            $table->string('ep_radd');
            $table->string('ep_eladd');
            $table->string('sleep_qualadd');
            $table->string('ep_hadd');
            $table->string('ep_wadd');
            $table->string('wapnadd');
            $table->string('hours_sleepadd');
            $table->text('appt_notesadd');
            $table->string('nightsperweek');

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
        Schema::drop('dentalsummfu');
    }
}
