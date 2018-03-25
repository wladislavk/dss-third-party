<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_notes', function(Blueprint $table)
        {
            $table->increments('notesid');

            $table->integer('patientid')->default(0);
            $table->text('notes')->nullable();
            $table->integer('edited')->default(0);
            $table->string('editor_initials');
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('procedure_date');
            $table->string('ip_address', 50)->nullable();
            $table->integer('signed_id')->nullable();
            $table->dateTime('signed_on')->nullable();
            $table->integer('parentid')->nullable();

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
        Schema::drop('dental_notes');
    }
}
