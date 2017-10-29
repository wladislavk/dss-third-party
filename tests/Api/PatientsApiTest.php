<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use Tests\TestCases\ApiTestCase;

class PatientsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Patient::class;
    }

    protected function getRoute()
    {
        return '/patients';
    }

    protected function getStoreData()
    {
        return [
            "lastname" => "Tremblay",
            "firstname" => "Abe",
            "middlename" => "A",
            "salutation" => "Miss",
            "member_no" => "test member number",
            "group_no" => "07",
            "plan_no" => "37",
            "p_m_partyfname" => "Stanford",
            "p_m_partymname" => "W",
            "p_m_partylname" => "Cummerata",
            "p_m_relation" => "quidem",
            "p_m_other" => "ut",
            "p_m_employer" => "corrupti",
            "p_m_ins_co" => "animi",
            "p_m_ins_id" => "necessitatibus",
            "p_d_party" => "dolor",
            "p_d_relation" => "qui",
            "p_d_other" => "voluptatem",
            "p_d_employer" => "consequatur",
            "p_d_ins_co" => "harum",
            "p_d_ins_id" => "sit",
            "s_d_party" => "quis",
            "s_d_relation" => "praesentium",
            "s_d_other" => "et",
            "s_d_employer" => "asperiores",
            "s_d_ins_co" => "neque",
            "s_d_ins_id" => "aspernatur",
            "s_m_partyfname" => "Nikolas",
            "s_m_partymname" => "D",
            "s_m_partylname" => "Moen",
            "s_m_relation" => "assumenda",
            "s_m_other" => "eum",
            "s_m_employer" => "excepturi",
            "s_m_ins_co" => "est",
            "s_m_ins_id" => "earum",
            "p_m_ins_grp" => "hic",
            "s_m_ins_grp" => "dicta",
            "p_m_ins_plan" => "sapiente",
            "s_m_ins_plan" => "culpa",
            "p_m_dss_file" => "omnis",
            "s_m_dss_file" => "et",
            "p_m_ins_type" => "nisi",
            "s_m_ins_type" => "ut",
            "p_m_ins_ass" => "animi",
            "s_m_ins_ass" => "est",
            "dob" => "07/19/1980",
            "add1" => "72695 Murray Bridge Apt. 449\nDaughertybury, TN 86348-2446",
            "add2" => "5720 Elouise Harbors Apt. 659\nPort Rosaleeville, FL 20354-2208",
            "city" => "Huelside",
            "state" => "CA",
            "zip" => "67772",
            "gender" => "Female",
            "marital_status" => "Single",
            "email_bounce" => 7,
            "docsleep" => "rerum",
            "docpcp" => "ea",
            "docdentist" => "omnis",
            "docent" => "ipsum",
            "docmdother" => "sequi",
            "docmdother2" => "75",
            "docmdother3" => "70",
            "last_reg_sect" => 2,
            "ssn" => "341433570",
            "internal_patient" => "qui",
            "home_phone" => "8111417689",
            "work_phone" => "6561252768",
            "cell_phone" => "5134864822",
            "email" => "muller.mattie@gmail.com",
            "patient_notes" => "Illo ut doloremque harum.",
            "alert_text" => "Facere odit et aperiam dolor.",
            "display_alert" => 9,
            "userid" => 6,
            "docid" => 4,
            "status" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'lastname'  => 'Doe',
            'firstname' => 'John',
            'add1'      => 'some address',
            'userid'    => 253,
        ];
    }

    public function testGetWithFilter()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/with-filter');
        $this->assertResponseOk();
        $this->assertEquals(147, count($this->getResponseData()));
        $this->assertEquals(1, $this->getResponseData()[0]['patientid']);
    }

    public function testGetListPatients()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/list');
        $this->assertResponseOk();
        $this->assertEquals(7, count($this->getResponseData()));
        $expectedFirst = [
            'patientid' => 30,
            'lastname' => 'Ackers',
            'firstname' => 'George',
            'middlename' => '',
            'patient_info' => null,
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }

    public function testFind()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/find');
        $this->assertResponseOk();
        $this->assertEquals(['count', 'order', 'results'], array_keys($this->getResponseData()));
        $expectedCount = [
            ['total' => 7],
        ];
        $this->assertEquals($expectedCount, $this->getResponseData()['count']);
        $expectedOrderIds = [30, 157, 194, 149, 38, 172, 84];
        $this->assertEquals($expectedOrderIds, array_column($this->getResponseData()['order'], 'patientid'));
        $this->assertEquals($expectedOrderIds, array_column($this->getResponseData()['results'], 'patientid'));
    }

    public function testGetReferredByContact()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/referred-by-contact');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetByContact()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/by-contact');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetDataForFillingPatientForm()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/filling-form');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetReferrers()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/referrers');
        $this->assertResponseOk();
        $this->assertEquals(7, count($this->getResponseData()));
        $expectedFirst = [
            'id' => 30,
            'name' => 'Ackers, George  - Patient',
            'source' => 1,
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }

    public function testCheckEmailWithCorrect()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/check-email', ['email' => 'foo@bar.com']);
        $this->assertResponseOk();
        $expected = [
            'confirm_message' => '',
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testCheckEmailWithIncorrect()
    {
        $this->post(self::ROUTE_PREFIX . '/patients/check-email');
        $this->assertResponseStatus(417);
    }

    public function testDestroyForDoctor()
    {
        /** @var Patient $newPatient */
        $newPatient = factory($this->getModel())->create();
        $newPatient->docid = 1;
        $newPatient->save();
        $primaryKey = $this->model->getKeyName();
        $this->delete(self::ROUTE_PREFIX . '/patients-by-doctor/' . $newPatient->$primaryKey);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), [$primaryKey => $newPatient->$primaryKey]);
    }

    public function testEditingPatient()
    {
        $this->markTestSkipped('No supported encrypter found. The cipher and / or key length are invalid.');
        return;

        /** @var Patient $newPatient */
        $newPatient = factory($this->getModel())->create();
        $primaryKey = $this->model->getKeyName();
        $data = [
            'patient_form_data' => [
                'firstname' => 'Simon',
            ],
        ];
        $this->post(self::ROUTE_PREFIX . '/patients/edit/' . $newPatient->$primaryKey, $data);
        $this->assertResponseOk();
        $expected = [
        ];
        $this->assertEquals($expected, $this->getResponseData());
        $this->seeInDatabase($this->model->getTable(), [$primaryKey => $newPatient->$primaryKey, 'firstname' => 'Simon']);
    }

    public function testResetAccessCode()
    {
        /** @var Patient $newPatient */
        $newPatient = factory($this->getModel())->create();
        $oldCode = $newPatient->access_code;
        $primaryKey = $this->model->getKeyName();
        $this->post(self::ROUTE_PREFIX . '/patients/reset-access-code/' . $newPatient->$primaryKey, ['email' => 'foo@bar.com']);
        $this->assertResponseOk();
        $newCode = $this->getResponseData()['access_code'];
        $this->assertNotEquals($oldCode, $newCode);
        $this->seeInDatabase($this->model->getTable(), [$primaryKey => $newPatient->$primaryKey, 'access_code' => $newCode]);
    }

    public function testCreateTempPinDocument()
    {
        $this->markTestSkipped('No supported encrypter found. The cipher and / or key length are invalid.');
        return;
        /** @var Patient $newPatient */
        $newPatient = factory($this->getModel())->create();
        $primaryKey = $this->model->getKeyName();
        $this->post(self::ROUTE_PREFIX . '/patients/temp-pin-document/' . $newPatient->$primaryKey);
        var_dump($this->response->getContent());
        $this->assertResponseOk();
        $expected = [
            'path_to_pdf' => '',
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
