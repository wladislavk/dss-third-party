<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Company;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Tests\TestCases\ApiTestCase;

class CompaniesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Company::class;
    }

    protected function getRoute()
    {
        return '/companies';
    }

    protected function getStoreData()
    {
        return [
            'name'   => 'testName',
            'add1'   => 'testAdd1',
            'add2'   => 'testAdd2',
            'city'   => 'testCity',
            'state'  => 'testState',
            'zip'    => '12345',
            'status' => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'   => 'testNameUpdated',
            'status' => 2,
        ];
    }

    public function testGetUserCompanies()
    {
        /** @var User $user */
        $user = User::find(1);
        $this->be($user);
        $this->get(self::ROUTE_PREFIX . '/companies/by-user');
        $this->assertResponseOk();
        $expected = [
            'id' => 3,
            'name' => 'DSS',
            'add1' => 'Address1',
            'add2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'zip' => '12323',
            'status' => 1,
            'adddate' => '2013-04-03 12:36:19',
            'ip_address' => '128.12.179.156',
            'eligible_api_key' => 'hCmEKZG7_KQ8mS4ztO3EJWKP1KEWvwW5Bdvx',
            'logo' => 'resources/company_logo_3.png',
            'stripe_secret_key' => 'sk_test_2Bwg6V5pLmm8Gbidwxc8Iwhk',
            'stripe_publishable_key' => 'pk_test_AwG89We9HPlSSaFDI1TZgnie',
            'monthly_fee' => '149.00',
            'default_new' => 1,
            'free_fax' => 0,
            'sfax_security_context' => 'sFaxTest000037',
            'sfax_app_id' => 'dentalsleepapitest',
            'sfax_app_key' => '5587F65019374020B403F3B49623CAB0',
            'sfax_init_vector' => 'x49e*wJVXr8BrALE',
            'fax_fee' => '0.39',
            'company_type' => 1,
            'phone' => '',
            'fax' => '',
            'email' => '',
            'plan_id' => 0,
            'sfax_encryption_key' => 'Mp77D!YfK^5I4#NDBuzgkZGcnfZ*Eqzm',
            'use_support' => 1,
            'exclusive' => 0,
            'vob_require_test' => 1,
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetHomeSleepTestCompanies()
    {
        $this->post(self::ROUTE_PREFIX . '/companies/home-sleep-test');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetBillingExclusiveCompany()
    {
        $this->post(self::ROUTE_PREFIX . '/companies/billing-exclusive-company');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }
}
