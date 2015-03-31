<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalExPage4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_ex_page4', function(Blueprint $table)
        {
            $table->increments('ex_page4id');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('exam_teeth')->nullable();
            $table->text('other_exam_teeth')->nullable();
            $table->string('caries')->nullable();
            $table->string('where_facets')->nullable();
            $table->string('cracked_fractured')->nullable();
            $table->string('old_worn_inadequate_restorations')->nullable();
            $table->string('dental_class_right')->nullable();
            $table->string('dental_division_right')->nullable();
            $table->string('dental_class_left')->nullable();
            $table->string('dental_division_left')->nullable();
            $table->text('additional_paragraph')->nullable();
            $table->text('initial_tooth')->nullable();
            $table->text('open_proximal')->nullable();
            $table->text('deistema')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->string('missing')->nullable();
            $table->text('crossbite')->nullable();

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
        Schema::drop('dental_ex_page4');
    }
}
