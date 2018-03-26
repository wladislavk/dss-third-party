<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage8Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_ex_page8', function(Blueprint $table)
        {
            $table->increments('ex_page8id');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('inserted')->nullable();
            $table->text('recommended')->nullable();
            $table->text('other_inserted')->nullable();
            $table->text('other_recommended')->nullable();
            $table->integer('see_number')->nullable();
            $table->string('see_type', 50)->nullable();
            $table->text('followup')->nullable();
            $table->text('additional_paragraph_followup')->nullable();
            $table->text('referring')->nullable();
            $table->string('plan_enable_referral', 50);
            $table->text('additional_paragraph_referral')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->string('device')->nullable();

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
        Schema::drop('dental_ex_page8');
    }
}
