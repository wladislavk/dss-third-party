<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Config\Repository as Config;
use Prettus\Repository\Eloquent\BaseRepository;

class AppointmentSummariesController extends BaseRestController
{
    /** @var AppointmentSummaryRepository */
    protected $repository;

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(Config $config, BaseRepository $repository, Request $request, LetterRepository $letterRepository)
    {
        parent::__construct($config, $repository, $request);
        $this->letterRepository = $letterRepository;
    }

    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var AppointmentSummary $resource */
        $resource = $this->repository->find($id);
        $resource->delete();
        $criteria = [
            'info_id' => $id,
        ];
        $now = new \DateTime();
        $data = [
            'deleted' => 1,
            'deleted_by' => $this->user->getUserIdOrZero(),
            'deleted_on' => $now->format('Y-m-d H:i:s'),
        ];
        $this->letterRepository->updateBy($criteria, $data);
        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/by-patient/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByPatient($id)
    {
        $data = $this->repository->getByPatient($id);
        return ApiResponse::responseOk('', $data);
    }
}
