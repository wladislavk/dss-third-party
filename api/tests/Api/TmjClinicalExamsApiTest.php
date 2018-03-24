<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\Device;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\User as BaseUser;

class TmjClinicalExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return TmjClinicalExam::class;
    }

    protected function getRoute()
    {
        return '/tmj-clinical-exams';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 100,
            "patientid" => 5,
            "palpationid" => "1|0~2|0~3|0~4|0~5|0~6|0~7|0~",
            "palpationRid" => "1|1~3|4~5|0~",
            "additional_paragraph_pal" => "Dolor rerum aut provident quod aspernatur atque ducimus. Et autem modi ipsum aut praesentium quis nulla. Laudantium facere ullam quasi mollitia. Ullam itaque harum fugit sint.",
            "joint_exam" => "~6~1~3~3~8~",
            "jointid" => "1|L~2|L~3|R~4|B~5|B~",
            "i_opening_from" => "83",
            "i_opening_to" => "68",
            "i_opening_equal" => "94",
            "protrusion_from" => "-8",
            "protrusion_to" => "62",
            "protrusion_equal" => "05",
            "l_lateral_from" => "17",
            "l_lateral_to" => "18",
            "l_lateral_equal" => "90",
            "r_lateral_from" => "21",
            "r_lateral_to" => "76",
            "r_lateral_equal" => "97",
            "deviation_from" => "9",
            "deviation_to" => "27",
            "deviation_equal" => "83",
            "deflection_from" => "84",
            "deflection_to" => "39",
            "deflection_equal" => "30",
            "range_normal" => "2",
            "normal" => "9",
            "other_range_motion" => "Ratione culpa consequatur libero.",
            "additional_paragraph_rm" => "Similique recusandae dolor voluptatibus repudiandae. Non rerum amet fuga et itaque sit. Ea odio sed accusantium repellendus. Facilis voluptatem id culpa adipisci qui assumenda commodi.",
            "screening_aware" => "1",
            "screening_normal" => "3",
            "userid" => 4,
            "docid" => 1,
            "status" => 6,
            "deviation_r_l" => "Left",
            "deflection_r_l" => "Right",
            "dentaldevice" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'          => 100,
            'other_range_motion' => 'test',
        ];
    }

    public function testUpdateFlowDeviceCreate()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);
        /** @var Device $device */
        $device = factory(Device::class)->create();
        /** @var Patient $patient */
        $patient = factory(Patient::class)->create();
        /** @var AppointmentSummary $appointmentSummary */
        $appointmentSummary = factory(AppointmentSummary::class)->create();
        $appointmentSummary->patientid = $patient->patientid;
        $appointmentSummary->appointment_type = AppointmentSummary::VISITED_APPOINTMENT;
        $appointmentSummary->segmentid = AppointmentSummary::DEVICE_DELIVERY_SEGMENT;
        $appointmentSummary->save();
        $data = [
            'patient_id' => $patient->patientid,
        ];
        $this->put(self::ROUTE_PREFIX . '/tmj-clinical-exams/update-flow-device/' . $device->deviceid, $data);
        $this->assertResponseOk();
        $content = json_decode($this->response->getContent(), true);
        $expectedResponseMessage = 'Flow device was successfully updated.';
        $this->assertEquals($expectedResponseMessage, $content['message']);
        $expectedSummary = [
            'patientid' => $patient->patientid,
            'device_id' => $device->deviceid,
        ];
        $this->seeInDatabase('dental_flow_pg2_info', $expectedSummary);
        $expectedData = [
            'dentaldevice' => $device->deviceid,
            'patientid' => $patient->patientid,
            'userid' => $user->userid,
            'docid' => $user->docid,
            'ip_address' => $user->ip_address,
        ];
        $this->seeInDatabase('dental_ex_page5', $expectedData);
    }

    public function testUpdateFlowDeviceUpdate()
    {
        /** @var BaseUser $user */
        $user = BaseUser::find('u_1');
        $this->be($user);
        /** @var Device $device */
        $device = factory(Device::class)->create();
        /** @var Patient $patient */
        $patient = factory(Patient::class)->create();
        /** @var AppointmentSummary $appointmentSummary */
        $appointmentSummary = factory(AppointmentSummary::class)->create();
        $appointmentSummary->patientid = $patient->patientid;
        $appointmentSummary->appointment_type = AppointmentSummary::VISITED_APPOINTMENT;
        $appointmentSummary->segmentid = AppointmentSummary::DEVICE_DELIVERY_SEGMENT;
        $appointmentSummary->date_completed = new \DateTime();
        $appointmentSummary->save();
        /** @var TmjClinicalExam $exam */
        $exam = factory(TmjClinicalExam::class)->create();
        $exam->patientid = $patient->patientid;
        $exam->save();
        $data = [
            'patient_id' => $patient->patientid,
        ];
        $this->put(self::ROUTE_PREFIX . '/tmj-clinical-exams/update-flow-device/' . $device->deviceid, $data);
        $this->assertResponseOk();
        $expectedData = [
            'ex_page5id' => $exam->ex_page5id,
            'dentaldevice' => $device->deviceid,
            'patientid' => $patient->patientid,
        ];
        $this->seeInDatabase('dental_ex_page5', $expectedData);
    }
}
