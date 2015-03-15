<?php

class ManageAddPatientTest extends TestCase
{
    public function testDisplayAddPatientPage()
    {
        $this->call('GET', '/manage/add_patient');

        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/manage/login');
    }

    public function testAddPatientPage()
    {
        Session::put('loginId', 1705);
        Session::put('companyId', 3);
        Session::put('docId', 1);
        Session::put('userType', 2);
        Session::put('userId', 1);
        Session::put('username', 'doc12');

        $response = $this->call('GET', '/manage/add_patient');

        $this->assertResponseOk();
        $this->assertViewHas('path');
        $this->assertViewHas('showBlock');
        $this->assertViewHas('imageType4');
        $this->assertViewHas('patientInfo');
        $this->assertViewHas('exclusiveBilling');
        $this->assertViewHas('nameBilling');
        $this->assertViewHas('patientRequestId');
        $this->assertViewHas('butText');
        $this->assertViewHas('docPatientPortal');
        $this->assertViewHas('locations');
        $this->assertViewHas('usePatientPortal');
        $this->assertViewHas('insuranceContacts');
        $this->assertViewHas('insContactsJson');
    }
}
