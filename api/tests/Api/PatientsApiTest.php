<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\User as BaseUser;

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

    public function testGetListPatients()
    {
        $data = [
            'partial_name' => 'smi',
        ];
        /** @var User $user */
        $user = User::find(1);
        $this->be($user);
        $this->post(self::ROUTE_PREFIX . '/patients/list', $data);
        $this->assertResponseOk();
        $response = $this->getResponseData();
        $this->assertEquals(6, count($response));
        $expectedFirst = [
            'patientid' => 42,
            'lastname' => 'Smith',
            'firstname' => 'John',
            'middlename' => 'M',
            'patient_info' => 1,
        ];
        $this->assertEquals($expectedFirst, $response[0]);
        $expectedNames = [
            'Smith, John M',
            'Smith, Johnny',
            'Smith, Pat',
            'Smith, John',
            'Smith, John',
            'Smith, John',
        ];
        $names = [];
        foreach ($response as $patient) {
            $names[] = trim("{$patient['lastname']}, {$patient['firstname']} {$patient['middlename']}");
        }
        $this->assertEquals($expectedNames, $names);
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
        $response = $this->getResponseData();
        $this->assertEquals(142, sizeof($response));
        $this->assertEquals('P_first', $response[0]['firstname']);
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
        /** @var User $user */
        $user = User::find(1);
        $this->be($user);
        /** @var Patient $newPatient */
        $newPatient = factory($this->getModel())->create(['docid' => 9]);
        $primaryKey = $this->model->getKeyName();
        $data = [
            'patient_form_data' => [
                'firstname' => 'Simon',
            ],
        ];
        $this->post(self::ROUTE_PREFIX . '/patients/edit/' . $newPatient->$primaryKey, $data);
        $this->assertResponseOk();
        // @todo: add actual update assertion
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
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);
        /** @var Patient $newPatient */
        $newPatient = factory($this->getModel())->create(['docid' => 9]);
        $primaryKey = $this->model->getKeyName();
        $this->post(self::ROUTE_PREFIX . '/patients/temp-pin-document/' . $newPatient->$primaryKey);
        $this->assertResponseOk();
        $expected = [
            'path_to_pdf' => 'http://localhost/letter_pdfs/user_pin_' . $newPatient->$primaryKey . '.pdf',
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetPatientData()
    {
        $patientId = 170;
        /** @var User $user */
        $user = User::find(1);
        $this->be($user);
        $this->get(self::ROUTE_PREFIX . '/patients/data/' . $patientId);
        $this->assertResponseOk();
        $expected = [
            'insurance_type' => '5',
            'premed' => 'Amoxil-Knee Replacement',
            'premedcheck' => 1,
            'alert_text' => '',
            'display_alert' => 0,
            'firstname' => 'Pat',
            'lastname' => 'Smith',
            'patient_contacts_number' => 0,
            'patient_insurances_number' => 0,
            'sub_patients_number' => 0,
            'is_email_bounced' => 0,
            'rejected_claims' => [],
            'questionnaire_data' => [
                'symptoms_status' => 3,
                'treatments_status' => 3,
                'history_status' => 3,
            ],
            'other_allergens' => '',
            'has_allergen' => 0,
            'hst_status' => 99,
            'incomplete_hsts' => [],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
