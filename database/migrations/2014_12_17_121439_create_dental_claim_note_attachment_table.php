<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalClaimNoteAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_claim_note_attachment', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('note_id')->nullable();
            $table->string('filename', 100)->nullable();
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
        Schema::drop('dental_claim_note_attachment');
    }
}
