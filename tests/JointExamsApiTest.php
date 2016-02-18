<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\JointExam;

class JointExamsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/joint-exams -> JointExamsController@store method
     * 
     */
    public function testAddJointExam()
    {
        $data = factory(JointExam::class)->make()->toArray();

        $data['joint_exam'] = 'test joint exam';

        $this->post('/api/v1/joint-exams', $data)
            ->seeInDatabase('dental_joint_exam', ['joint_exam' => 'test joint exam'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/joint-exams/{id} -> JointExamsController@update method
     * 
     */
    public function testUpdateJointExam()
    {
        $jointExamTestRecord = factory(JointExam::class)->create();

        $data = [
            'description' => 'updated test joint exam',
            'status'      => '7'
        ];

        $this->put('/api/v1/joint-exams/' . $jointExamTestRecord->joint_examid, $data)
            ->seeInDatabase('dental_joint_exam', ['status' => '7'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/joint-exams/{id} -> JointExamsController@destroy method
     * 
     */
    public function testDeleteJointExam()
    {
        $jointExamTestRecord = factory(JointExam::class)->create();

        $this->delete('/api/v1/joint-exams/' . $jointExamTestRecord->joint_examid)
            ->notSeeInDatabase('dental_joint_exam', [
                'joint_examid' => $jointExamTestRecord->joint_examid
            ])
            ->assertResponseOk();
    }
}
