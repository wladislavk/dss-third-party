<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Diagnostic;

class DiagnosticsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/diagnostics -> DiagnosticsController@store method
     * 
     */
    public function testAddDiagnostic()
    {
        $data = [
            'diagnostic'  => 'test',
            'description' => 'test description',
            'status'      => 10
        ];

        $this->post('/api/v1/diagnostics', $data)
            ->seeInDatabase('dental_diagnostic', ['diagnostic' => 'test'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/diagnostics/{id} -> DiagnosticsController@update method
     * 
     */
    public function testUpdateDiagnostic()
    {
        $diagnosticTestRecord = factory(Diagnostic::class)->create();

        $data = [
            'description' => 'updated test description',
            'sortby'      => 100
        ];

        $this->put('/api/v1/diagnostics/' . $diagnosticTestRecord->diagnosticid, $data)
            ->seeInDatabase('dental_diagnostic', [
                'description' => 'updated test description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/diagnostics/{id} -> DiagnosticsController@destroy method
     * 
     */
    public function testDeleteDiagnostic()
    {
        $diagnosticTestRecord = factory(Diagnostic::class)->create();

        $this->delete('/api/v1/diagnostics/' . $diagnosticTestRecord->diagnosticid)
            ->notSeeInDatabase('dental_diagnostic', [
                'diagnosticid' => $diagnosticTestRecord->diagnosticid
            ])
            ->assertResponseOk();
    }
}