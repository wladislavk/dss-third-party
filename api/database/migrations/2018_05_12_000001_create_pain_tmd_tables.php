<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePainTmdTables extends Migration
{
    const TABLE_JSON_FIELDS = [
        'dental_pain_tmd_exams' => [
            'description',
            'pain',
            'symptom_review',
            'symptoms',
            'headaches',
        ],
        'dental_advanced_pain_tmd_exams' => [
            'cervical',
            'morphology',
            'cranial_nerve',
            'occlusal',
            'other',
        ],
        'dental_evaluation_management_exams' => [
            'history',
            'systems',
            'vital_signs',
            'body_area',
        ],
        'dental_assessment_plan_exams' => [
            'assessment_codes',
            'assessment_description',
            'treatment_codes',
            'treatment_description',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::TABLE_JSON_FIELDS as $table => $jsonFields) {
            Schema::create($table, function (Blueprint $table) use ($jsonFields) {
                $table->increments('id');
                $table->integer('patient_id')->unsigned();
                $table->integer('doc_id')->unsigned();
                $table->integer('created_by_user')->unsigned();
                $table->integer('created_by_admin')->unsigned();
                $table->integer('updated_by_user')->unsigned();
                $table->integer('updated_by_admin')->unsigned();
                $table->string('ip_address', 50)->default('');

                foreach ($jsonFields as $jsonField) {
                    $table->text($jsonField);
                }

                $table->timestamps();

                $table->index('patient_id');
                $table->index('doc_id');
                $table->index('created_by_user');
                $table->index('created_by_admin');
                $table->index('updated_by_user');
                $table->index('updated_by_admin');

                /**
                 * Foreign keys need to be of the same type on both tables, and both with the same engine
                 */
                // $table->foreign('patient_id')->references('patientid')->on('dental_patients');
                // $table->foreign('doc_id')->references('userid')->on('dental_users');
                // $table->foreign('created_by_user')->references('userid')->on('dental_users');
                // $table->foreign('created_by_admin')->references('adminid')->on('admin');
                // $table->foreign('updated_by_user')->references('userid')->on('dental_users');
                // $table->foreign('updated_by_admin')->references('adminid')->on('admin');
            });
        }

        Schema::create('dental_doctor_palpations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id')->unsigned();
            $table->integer('updated_by_user')->unsigned();
            $table->integer('updated_by_admin')->unsigned();
            $table->string('ip_address', 50)->default('');

            $table->integer('palpationid');
            $table->integer('sortby');

            $table->index('doc_id');
            $table->index('updated_by_user');
            $table->index('updated_by_admin');

            // $table->foreign('doc_id')->references('userid')->on('dental_users');
            // $table->foreign('palpationid')->references('palpationid')->on('dental_palpation');
        });

        Schema::table('dental_doctor_palpations', function (Blueprint $table) {
            $table->unique(['doc_id', 'palpationid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (self::TABLE_JSON_FIELDS as $table => $dummy) {
            Schema::drop($table);
        }
        Schema::drop('dental_doctor_palpations');
    }
}
