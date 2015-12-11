<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreCalendarRequest;
use DentalSleepSolutions\Http\Requests\UpdateCalendarRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\CalendarInterface;

class ApiCalendarController extends ApiBaseController
{
    /**
     * References the calendar interface
     * 
     * @var $calendar
     */
    protected $calendar;

    /**
     * 
     * @param CalendarInterface $calendar 
     */
    public function __construct(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedCalendars = $this->calendar->all();

        if (!count($retrievedCalendars)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Calendars list.', $retrievedCalendars);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCalendarRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->calendar->store($postValues);

        return ApiResponse::responseOk('Calendar was added successfully.', $this->calendar->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCalendarRequest $request, $id)
    {
        $this->calendar->update($id, $request->all());

        return ApiResponse::responseOk('Calendar was updated successfully.', $this->calendar->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedCalendar = $this->calendar->find($id);

        if (empty($retrievedCalendar)) {
            return ApiResponse::responseError('Calendar not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved calendar by id.', $retrievedCalendar);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Calendar was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedCalendar = $this->calendar->destroy($id);

        if (empty($deletedCalendar)) {
            return ApiResponse::responseError('Calendar not found.', 422);
        }

        return ApiResponse::responseOk('Calendar was deleted successfully.', $this->calendar->all());
    }
}
