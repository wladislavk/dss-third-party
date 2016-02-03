<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

use DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam;

class TmjClinicalExamsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/tmj-clinical-exams -> TmjClinicalExamsController@store method
     * 
     */
    public function testAddTmjClinicalExam()
    {
        $data = [
            'formid'                   => 5,
            'patientid'                => 5,
            'palpationid'              => '1|1~3|4~5|1~',
            'palpationRid'             => '1|1~2|4~5|1~',
            'additional_paragraph_pal' => 'Add additional paragraph pal',
            'joint_exam'               => '~2~3~',
            'jointid'                  => '1|LMMM~2|L~3|R~4|B~5|B~',
            'i_opening_from'           => '22',
            'i_opening_to'             => '22',
            'i_opening_equal'          => '22',
            'protrusion_from'          => '22',
            'protrusion_to'            => '22',
            'protrusion_equal'         => '22',
            'l_lateral_from'           => '22',
            'l_lateral_to'             => '22',
            'l_lateral_equal'          => '22',
            'r_lateral_from'           => '22',
            'r_lateral_to'             => '22',
            'r_lateral_equal'          => '22',
            'deviation_from'           => '22',
            'deviation_to'             => '22',
            'deviation_equal'          => '22',
            'deflection_from'          => '22',
            'deflection_to'            => '22',
            'deflection_equal'         => '22',
            'range_normal'             => '22',
            'normal'                   => '22',
            'other_range_motion'       => 'Add other range motion',
            'additional_paragraph_rm'  => 'Add additional paragraph rm',
            'screening_aware'          => '3',
            'screening_normal'         => '3',
            'userid'                   => 7,
            'docid'                    => 7,
            'status'                   => 7,
            'deviation_r_l'            => 'Right',
            'deflection_r_l'           => 'Left',
            'dentaldevice'             => 10,
            'dentaldevice_date'        => Carbon::now()
        ];

        $this->post('/api/v1/tmj-clinical-exams', $data)
            ->seeInDatabase('dental_ex_page5', ['other_range_motion' => 'Add other range motion'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/tmj-clinical-exams/{id} -> TmjClinicalExamsController@update method
     * 
     */
    public function testUpdateTmjClinicalExam()
    {
        $tmjClinicalExamTestRecord = factory(TmjClinicalExam::class)->create();

        $data = [
            'other_range_motion' => 'Update other range motion',
            'dentaldevice'       => '9',
        ];

        $this->put('/api/v1/tmj-clinical-exams/' . $tmjClinicalExamTestRecord->ex_page5id, $data)
            ->seeInDatabase('dental_ex_page5', ['other_range_motion' => 'Update other range motion'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/tmj-clinical-exams/{id} -> TmjClinicalExamsController@destroy method
     * 
     */
    public function testDeleteTmjClinicalExam()
    {
        $tmjClinicalExamTestRecord = factory(TmjClinicalExam::class)->create();

        $this->delete('/api/v1/tmj-clinical-exams/' . $tmjClinicalExamTestRecord->ex_page5id)
            ->notSeeInDatabase('dental_ex_page5', ['ex_page5id' => $tmjClinicalExamTestRecord->ex_page5id])
            ->assertResponseOk();
    }
}
