<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_q_recipients', function(Blueprint $table)
        {
            $table->increments('q_recipientsid');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('referring_physician')->nullable();
            $table->text('dentist')->nullable();
            $table->text('physicians_other')->nullable();
            $table->text('patient_info')->nullable();
            $table->string('q_file1')->nullable();
            $table->string('q_file2')->nullable();
            $table->string('q_file3')->nullable();
            $table->string('q_file4')->nullable();
            $table->string('q_file5')->nullable();
            $table->string('q_file6')->nullable();
            $table->string('q_file7')->nullable();
            $table->string('q_file8')->nullable();
            $table->string('q_file9')->nullable();
            $table->string('q_file10')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
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
        Schema::drop('dental_q_recipients');
    }
}
