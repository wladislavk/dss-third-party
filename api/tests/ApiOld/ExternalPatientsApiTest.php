<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCases\BaseApiTestCase;

class ExternalPatientsApiTest extends BaseApiTestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    /** @var Transformer */
    private $transformer;

    public function setUp()
    {
        parent::setUp();
        $this->transformer = $this->app->make(Transformer::class);
    }

    private function getRoute()
    {
        return '/external-patient';
    }

    public function testStoreNew()
    {
        $externalPatient = $this->newModel();
        $data = $this->transformer->transform($externalPatient);
        $url = $this->expectedUrl($externalPatient);

        $this->post($this->getRoute(), $data);

        $this->assertResponseStatus(201);
        $this->seeJson([
            'redirect_url' => $url,
        ]);
    }

    public function testStoreExisting()
    {
        $externalPatient = $this->newModel();
        $externalPatient->save();
        $data = $this->transformer->transform($externalPatient);
        $url = $this->expectedUrl($externalPatient);

        $this->post($this->getRoute(), $data);

        $this->assertResponseStatus(200);
        $this->seeJson([
            'redirect_url' => $url,
        ]);
    }

    private function expectedUrl(ExternalPatient $externalPatient)
    {
        $url = join('', [
            $this->app->config->get('app.external_patient.frontend_url'),
            $this->app->config->get('app.external_patient.redirect_uri'),
            '?',
            http_build_query([
                'sw' => $externalPatient->software,
                'id' => $externalPatient->external_id,
            ])
        ]);

        return $url;
    }

    private function newModel()
    {
        $patient = factory(Patient::class)->create();
        $company = factory(ExternalCompany::class)->create();
        $externalPatient = factory(ExternalPatient::class)->make([
            'patient_id' => $patient->patientid,
            'software' => $company->software,
        ]);

        return $externalPatient;
    }
}
