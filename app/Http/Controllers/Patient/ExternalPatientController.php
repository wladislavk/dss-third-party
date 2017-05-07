<?php

namespace DentalSleepSolutions\Http\Controllers\Patient;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore;
use DentalSleepSolutions\Contracts\Repositories\ExternalPatients;
use EventHomes\Api\FractalHelper;
use DentalSleepSolutions\Http\Transformers\ExternalPatient as Transformer;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ExternalPatientController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    use FractalHelper;

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalPatients $resources
     * @param  \DentalSleepSolutions\Http\Requests\Patient\ExternalPatientStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (ExternalPatients $resources, ExternalPatientStore $request) {
        $created = false;
        
        $transformer = new Transformer;
        $data = $transformer->fromTransform($request->all());

        $externalPatient = $resources
            ->where('software', array_get($data, 'external_patient.software'))
            ->where('external_id', array_get($data, 'external_patient.external_id'))
            ->first();

        if (!$externalPatient) {
            $created = true;
            $externalPatient = $resources->create(array_get($data, 'external_patient'));
            $externalPatient->save();
        }

        $redirectUrl = env('FRONTEND_URL') . 'manage/external-patient.php?' .
            http_build_query([
                'sw' => array_get($data, 'external_patient.software'),
                'id' => array_get($data, 'external_patient.external_id'),
            ]);

        return ApiResponse::responseOk('', ['redirect_url' => $redirectUrl], $created ? 201 : 200);
    }
}
