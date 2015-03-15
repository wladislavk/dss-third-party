<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQPage2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_q_page2', function(Blueprint $table)
        {
            $table->increments('q_page2id');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->integer('polysomnographic')->default(0);
            $table->string('sleep_center_name')->nullable();
            $table->string('sleep_study_on')->nullable();
            $table->string('confirmed_diagnosis')->nullable();
            $table->string('rdi')->nullable();
            $table->string('ahi')->nullable();
            $table->string('cpap', 50)->nullable();
            $table->text('intolerance')->nullable();
            $table->text('other_intolerance')->nullable();
            $table->text('other_therapy')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->string('other')->nullable();
            $table->string('affidavit', 50)->nullable();
            $table->string('type_study')->nullable();
            $table->string('nights_wear_cpap')->nullable();
            $table->string('percent_night_cpap')->nullable();
            $table->string('custom_diagnosis')->nullable();
            $table->string('sleep_study_by')->nullable();
            $table->string('triedquittried');
            $table->string('timesovertime');
            $table->string('cur_cpap', 50)->nullable();
            $table->string('sleep_center_name_text')->nullable();
            $table->string('dd_wearing', 50)->nullable();
            $table->string('dd_prev', 50)->nullable();
            $table->string('dd_otc', 50)->nullable();
            $table->string('dd_fab', 50)->nullable();
            $table->string('dd_who')->nullable();
            $table->text('dd_experience')->nullable();
            $table->string('surgery', 50)->nullable();
            $table->integer('parent_patientid')->nullable();

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
        Schema::drop('dental_q_page2');
    }
}
