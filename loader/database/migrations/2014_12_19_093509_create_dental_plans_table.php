<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_plans', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name', 50)->nullable();
            $table->decimal('monthly_fee', 11, 2)->nullable();
            $table->integer('trial_period')->nullable();
            $table->decimal('fax_fee', 11, 2)->nullable();
            $table->integer('free_fax')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->decimal('eligibility_fee', 11, 2)->default(0.00);
            $table->integer('free_eligibility')->default(0);
            $table->decimal('enrollment_fee', 11, 2)->default(0.00);
            $table->integer('free_enrollment')->default(0);
            $table->decimal('claim_fee', 11, 2)->default(0.00);
            $table->integer('free_claim')->default(0);
            $table->decimal('vob_fee', 11, 2)->default(0.00);
            $table->integer('free_vob')->default(0);
            $table->tinyInteger('office_type')->default(1);
            $table->decimal('efile_fee', 11, 2)->default(0.00);
            $table->integer('free_efile')->default(0);
            $table->integer('duration')->default(0);
            $table->decimal('producer_fee', 11, 2)->default(0.00);
            $table->decimal('user_fee', 11, 2)->default(0.00);
            $table->decimal('patient_fee', 11, 2)->default(0.00);
            $table->tinyInteger('e0486_bill')->default(1);
            $table->decimal('e0486_fee', 11, 2)->default(0.00);

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
        Schema::drop('dental_plans');
    }
}
