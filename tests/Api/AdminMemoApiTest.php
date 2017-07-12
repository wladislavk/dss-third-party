<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\MemoAdmin;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCases\ApiTestCase;

class AdminMemoApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    protected $memo_id;

    /**
     * Tests the post method of the Dental Sleep Solutions API
     * Posts to /api/v1/post -> Api/ApiAdminMemoController@post method
     *
     */
    public function testAddMemo()
    {
        $date = date("Y-m-d");
        $data = [
            'memo' => 'PHPUnit Inserted Test Memo',
            'last_update' => $date,
            'off_date' => date('Y-m-d', strtotime("$date +7 days")),
        ];
        $this
            ->post('/api/v1/memo', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('memo_admin', ['memo' => 'PHPUnit Inserted Test Memo'])
        ;
    }

    public function testUpdateMemo()
    {
        $adminMemoTestRecord = factory(MemoAdmin::class)->create();

        $date = date("Y-m-d");
        $data = [
            'memo' => 'PHPUnit Updated Test Memo',
            'last_update' => $date,
            'off_date' => date('Y-m-d', strtotime("$date +7 days")),
        ];
        $this
            ->put('/api/v1/memo/'.$adminMemoTestRecord->memo_id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('memo_admin', ['memo' => 'PHPUnit Updated Test Memo'])
        ;
    }

    public function testDeleteMemo()
    {
        $adminMemoTestRecord = factory(MemoAdmin::class)->create();
        $this
            ->delete('/api/v1/memo/'.$adminMemoTestRecord->memo_id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->notSeeInDatabase('memo_admin', ['memo' => 'PHPUnit Updated Test Memo'])
        ;
    }
}
