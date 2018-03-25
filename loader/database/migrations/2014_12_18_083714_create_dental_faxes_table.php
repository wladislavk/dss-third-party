<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalFaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_faxes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('patientid')->nullable();
            $table->integer('userid')->nullable();
            $table->integer('docid')->nullable();
            $table->dateTime('sent_date')->nullable();
            $table->integer('pages')->nullable();
            $table->integer('contactid')->nullable();
            $table->string('to_number', 15)->nullable();
            $table->string('to_name', 50)->nullable();
            $table->integer('letterid')->nullable();
            $table->string('filename', 100)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->integer('fax_invoice_id')->nullable();
            $table->string('sfax_transmission_id')->nullable();
            $table->tinyInteger('sfax_completed')->default(0);
            $table->text('sfax_response')->nullable();
            $table->tinyInteger('sfax_status')->default(0);
            $table->string('sfax_error_code', 20)->nullable();
            $table->text('letter_body')->nullable();
            $table->tinyInteger('viewed')->default(0);

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
        Schema::drop('dental_faxes');
    }
}
