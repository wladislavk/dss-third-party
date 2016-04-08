<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\ModifierCode;

class ModifierCodesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/modifier-codes -> ModifierCodesController@store method
     * 
     */
    public function testAddModifierCode()
    {
        $data = factory(ModifierCode::class)->make()->toArray();

        $data['status'] = 8;

        $this->post('/api/v1/modifier-codes', $data)
            ->seeInDatabase('dental_modifier_code', ['status' => 8])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/modifier-codes/{id} -> ModifierCodesController@update method
     * 
     */
    public function testUpdateModifierCode()
    {
        $modifierCodeTestRecord = factory(ModifierCode::class)->create();

        $data = [
            'description' => 'updated description',
            'status'      => 7
        ];

        $this->put('/api/v1/modifier-codes/' . $modifierCodeTestRecord->modifier_codeid, $data)
            ->seeInDatabase('dental_modifier_code', [
                'description' => 'updated description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/modifier-codes/{id} -> ModifierCodesController@destroy method
     * 
     */
    public function testDeleteModifierCode()
    {
        $modifierCodeTestRecord = factory(ModifierCode::class)->create();

        $this->delete('/api/v1/modifier-codes/' . $modifierCodeTestRecord->modifier_codeid)
            ->notSeeInDatabase('dental_modifier_code', [
                'modifier_codeid' => $modifierCodeTestRecord->modifier_codeid
            ])
            ->assertResponseOk();
    }
}
