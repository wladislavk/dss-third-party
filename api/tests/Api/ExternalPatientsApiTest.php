<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
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

        $this->assertResponseStatus(Response::HTTP_CREATED);
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

        $this->assertResponseStatus(Response::HTTP_OK);
        $this->seeJson([
            'redirect_url' => $url,
        ]);
    }

    public function testStoreWithNullValues()
    {
        /** @var ExternalPatient $externalPatient */
        $externalPatient = $this->newModel();
        $data = $this->transformer->transform($externalPatient);
        $data = $this->nullAllFields($data);
        $data['patient']['origin_record']['origin_software'] = $externalPatient->software;
        $data['patient']['origin_record']['origin_patient_Id'] = $externalPatient->external_id;
        $this->post($this->getRoute(), $data);
        $this->assertResponseStatus(Response::HTTP_CREATED);
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

    /**
     * @param array $data
     * @return array
     */
    private function nullAllFields(array $data)
    {
        $flatten = Arr::dot($data);
        $data = [];
        foreach (array_keys($flatten) as $key) {
            Arr::set($data, $key, null);
        }
        return $data;
    }
}
