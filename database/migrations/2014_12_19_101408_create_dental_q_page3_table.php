<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentalQPage3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_q_page3', function(Blueprint $table)
        {
            $table->increments('q_page3id');

            $table->integer('formid')->default(0);
            $table->integer('patientid')->default(0);
            $table->text('allergens')->nullable();
            $table->text('other_allergens')->nullable();
            $table->text('medications')->nullable();
            $table->text('other_medications')->nullable();
            $table->text('history')->nullable();
            $table->text('other_history')->nullable();
            $table->integer('userid')->default(0);
            $table->integer('docid')->default(0);
            $table->integer('status')->default(1);
            $table->string('ip_address', 50)->nullable();
            $table->string('dental_health')->nullable();
            $table->string('removable')->nullable();
            $table->string('year_completed')->nullable();
            $table->string('tmj')->nullable();
            $table->string('gum_problems')->nullable();
            $table->string('dental_pain')->nullable();
            $table->text('dental_pain_describe')->nullable();
            $table->string('completed_future')->nullable();
            $table->string('clinch_grind')->nullable();
            $table->string('wisdom_extraction')->nullable();
            $table->string('injurytohead');
            $table->string('injurytoneck');
            $table->string('injurytoface');
            $table->string('injurytoteeth');
            $table->string('injurytomouth');
            $table->string('drymouth');
            $table->string('jawjointsurgery');
            $table->string('no_allergens', 1)->default(0);
            $table->string('no_medications', 1)->default(0);
            $table->string('no_history', 1)->default(0);
            $table->string('orthodontics')->nullable();
            $table->string('wisdom_extraction_text')->nullable();
            $table->string('removable_text')->nullable();
            $table->string('dentures', 50)->nullable();
            $table->string('dentures_text')->nullable();
            $table->string('tmj_cp', 50)->nullable();
            $table->string('tmj_cp_text')->nullable();
            $table->string('tmj_pain', 50)->nullable();
            $table->string('tmj_pain_text')->nullable();
            $table->string('tmj_surgery', 50)->nullable();
            $table->string('tmj_surgery_text')->nullable();
            $table->string('injury', 50)->nullable();
            $table->string('injury_text')->nullable();
            $table->string('gum_prob', 50)->nullable();
            $table->string('gum_prob_text')->nullable();
            $table->string('gum_surgery', 50)->nullable();
            $table->string('gum_surgery_text')->nullable();
            $table->string('clinch_grind_text')->nullable();
            $table->string('future_dental_det')->nullable();
            $table->string('drymouth_text')->nullable();
            $table->string('family_hd', 50)->nullable();
            $table->string('family_bp', 50)->nullable();
            $table->string('family_dia', 50)->nullable();
            $table->string('family_sd', 50)->nullable();
            $table->string('alcohol', 50)->nullable();
            $table->string('sedative', 50)->nullable();
            $table->string('caffeine', 50)->nullable();
            $table->string('smoke', 50)->nullable();
            $table->string('smoke_packs', 50)->nullable();
            $table->string('tobacco', 50)->nullable();
            $table->text('additional_paragraph')->nullable();
            $table->tinyInteger('allergenscheck')->default(0);
            $table->tinyInteger('medicationscheck')->default(0);
            $table->tinyInteger('historycheck')->default(0);
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
        Schema::drop('dental_q_page3');
    }
}
