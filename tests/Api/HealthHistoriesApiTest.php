<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory;
use Tests\TestCases\ApiTestCase;

class HealthHistoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return HealthHistory::class;
    }

    protected function getRoute()
    {
        return '/health-histories';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 8,
            "patientid" => 100,
            "allergens" => "~50~",
            "other_allergens" => "Quisquam et rerum velit rerum ut.",
            "medications" => "~69~49~00~69~",
            "other_medications" => "Ut perspiciatis tempora aut consequatur.",
            "history" => "~5~1~",
            "other_history" => "Voluptatum aut qui porro ipsum autem.",
            "userid" => 6,
            "docid" => 2,
            "status" => 4,
            "adddate" => "1975-03-30 11:53:50",
            "dental_health" => "Poor",
            "removable" => "Yes",
            "year_completed" => "1971",
            "tmj" => "Accusamus consequatur est.",
            "gum_problems" => "qui",
            "dental_pain" => "dolor",
            "dental_pain_describe" => "nisi",
            "completed_future" => "No",
            "clinch_grind" => "No",
            "wisdom_extraction" => "No",
            "injurytohead" => "No",
            "injurytoneck" => "No",
            "injurytoface" => "Yes",
            "injurytoteeth" => "No",
            "injurytomouth" => "No",
            "drymouth" => "Yes",
            "jawjointsurgery" => "No",
            "no_allergens" => "9",
            "no_medications" => "1",
            "no_history" => "4",
            "orthodontics" => "Yes",
            "wisdom_extraction_text" => "ea",
            "removable_text" => "Harum aut omnis quis quasi.",
            "dentures" => "Yes",
            "dentures_text" => "Omnis dicta est excepturi maxime nobis error.",
            "tmj_cp" => "No",
            "tmj_cp_text" => "Praesentium nobis dolor magnam culpa.",
            "tmj_pain" => "Yes",
            "tmj_pain_text" => "Et architecto cupiditate optio ut.",
            "tmj_surgery" => "Yes",
            "tmj_surgery_text" => "Id animi libero atque voluptatem.",
            "injury" => "No",
            "injury_text" => "Quia et ipsam consectetur.",
            "gum_prob" => "Yes",
            "gum_prob_text" => "Quia officia recusandae cum optio recusandae.",
            "gum_surgery" => "Yes",
            "gum_surgery_text" => "Dolores qui tempore nemo labore labore ratione.",
            "clinch_grind_text" => "Facilis sit in tempore reprehenderit et inventore.",
            "future_dental_det" => "Incidunt voluptatibus esse ullam est sed reiciendis consequatur perferendis.",
            "drymouth_text" => "Repellendus voluptas officiis dolorem inventore cupiditate voluptatem.",
            "family_hd" => "No",
            "family_bp" => "No",
            "family_dia" => "Yes",
            "family_sd" => "No",
            "alcohol" => "quo",
            "sedative" => "architecto",
            "caffeine" => "iste",
            "smoke" => "Yes",
            "smoke_packs" => "4",
            "tobacco" => "Yes",
            "additional_paragraph" => "Facere reiciendis vitae molestias aut doloremque voluptas blanditiis voluptas.",
            "allergenscheck" => 1,
            "medicationscheck" => 0,
            "historycheck" => 0,
            "parent_patientid" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid'               => 100,
            'additional_paragraph' => 'updated additional paragraph for hh',
        ];
    }

    public function testGetWithFilter()
    {
        $this->post(self::ROUTE_PREFIX . '/health-histories/with-filter');
        $this->assertResponseOk();
        $this->assertEquals(45, count($this->getResponseData()));
        $this->assertEquals(1, $this->getResponseData()[0]['patientid']);
    }
}
