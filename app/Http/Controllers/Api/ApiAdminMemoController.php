<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 7/23/2015
 * Time: 10:27 AM
 */

namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use \DentalSleepSolutions\Interfaces\MemoAdminInterface;
use Illuminate\Support\Facades\Input;

class ApiAdminMemoController extends ApiBaseController
{

    /**
     * References the memo interface
     * @var $memo
     */
    protected $memo;

    /**
     *
     * @param MemoAdminInterface $memo
     */
    public function __construct(MemoAdminInterface $memo)
    {
        $this->memo = $memo;
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        if($memo = $this->memo->store(Input::all()))
        {
            return response()->json(['status' => true,'memo_id' => $memo->memo_id],200);
        }
        return response()->json(['status' => false],404);
    }

    public function update($memo_id)
    {
        if($this->memo->update($memo_id,Input::all()))
        {
            return response()->json(['status' => true],200);
        }
        return response()->json(['status' => false],404);
    }

    public function show($memo_id)
    {
        $memo = $this->memo->find($memo_id);
        if($memo)
        {
            return response()->json(['status' => true, 'memo' => $memo],200);
        }
        return response()->json(['status' => false],404);
    }

    public function edit($memo_id)
    {
        $memo = $this->memo->find($memo_id);
        return response()->json(['status' => true, 'memo' => $memo],200);
    }

    public function destroy($memo_id)
    {
        if($this->memo->destroy($memo_id))
        {
            return response()->json(['status' => true],200);
        }
        return response()->json(['status' => false,],404);
    }

}