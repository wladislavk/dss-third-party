<?php

class ManageIndexTest extends TestCase
{
    public function testDisplayIndexPage()
    {
        $this->call('GET', '/manage/index');

        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/manage/login');
    }
        
    public function testIndexPage()
    {
        Session::put('loginId', 1705);
        Session::put('companyId', 3);
        Session::put('docId', 1);
        Session::put('userType', 2);
        Session::put('userId', 1);
        Session::put('username', 'doc12');

        $response = $this->call('GET', '/manage/index');

        $this->assertResponseOk();
        $this->assertViewHas('path');
        $this->assertViewHas('showBlock');
        $this->assertViewHas('documentCategories');
        $this->assertViewHas('numPortal');
        $this->assertViewHas('numAlerts');
        $this->assertViewHas('memoAdmins');
        $this->assertViewHas('username');
    }
}
