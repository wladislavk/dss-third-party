<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 7/23/2015
 * Time: 10:27 AM
 */

namespace DentalSleepSolutions\Http\Controllers\Api;

use \DentalSleepSolutions\Interfaces\MemoAdminInterface;

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
        $this->memo->store([]);
        return response()->json(['status' => true],200);
    }

    public function update()
    {
        return response()->json(['status' => true],200);
    }

    public function show()
    {
        return response()->json(['status' => true],200);
    }

    public function edit()
    {
        return response()->json(['status' => true],200);
    }

    public function destroy()
    {
        return response()->json(['status' => true],200);
    }
}