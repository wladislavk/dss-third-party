<?php

use DentalSleepSolutions\Eloquent\MemoAdmin;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminMemoApiTest extends TestCase
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
        $data = ['memo' => 'PHPUnit Inserted Test Memo','last_update' => $date, 'off_date' => date('Y-m-d',strtotime("$date +7 day"))];
        $this->post('/api/v1/memo',$data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true,])
            ->seeInDatabase('memo_admin',['memo' => 'PHPUnit Inserted Test Memo']);
    }

    public function testUpdateMemo()
    {
        $memoTestRecord = MemoAdmin::where('memo','like','PHPUnit%')->firstOrFail();
        if($memoTestRecord)
        {
            $date = date("Y-m-d");
            $data = ['memo' => 'PHPUnit Updated Test Memo','last_update' => $date, 'off_date' => date('Y-m-d',strtotime("$date +7 day"))];
            $this->put('/api/v1/memo/'.$memoTestRecord->memo_id,$data)
                ->seeStatusCode(200)
                ->seeJsonContains(['status' => true,])
                ->seeInDatabase('memo_admin',['memo' => 'PHPUnit Updated Test Memo']);
        }

    }

    public function testDeleteMemo()
    {
        $memoTestRecord = MemoAdmin::where('memo','like','PHPUnit%')->firstOrFail();
        if($memoTestRecord)
        {
            $this->delete('/api/v1/memo/'.$memoTestRecord->memo_id)
                ->seeStatusCode(200)
                ->seeJsonContains(['status' => true,])
                ->notSeeInDatabase('memo_admin',['memo' => 'PHPUnit Updated Test Memo']);
        }
    }

}
