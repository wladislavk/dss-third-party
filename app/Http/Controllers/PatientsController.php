<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientStore;
use DentalSleepSolutions\Http\Requests\PatientUpdate;
use DentalSleepSolutions\Http\Requests\PatientDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Patient;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Patients $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Patient $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Patient $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @param  \DentalSleepSolutions\Http\Requests\PatientStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Patients $resources, PatientStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Patient $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Patient $resource, PatientUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Patient $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Patient $resource, PatientDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * Get patients by filter.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Patients $resources, Request $request)
    {
        $fields = $request->input('fields') ?: [];
        $where  = $request->input('where') ?: [];

        $patients = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }

    public function getNumber(Patients $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getDuplicates(Patients $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getDuplicates($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getBounces(Patients $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getBounces($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getListPatients(Patients $resources, Request $request)
    {
        $partialName = $request->input('partial_name') ?: '';
        $partialName = preg_replace("[^ A-Za-z'\-]", '', $partialName);

        $names = explode(' ', $partialName);

        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getListPatients($docId, $names);

        return ApiResponse::responseOk('', $data);
    }

    public function destroyForDoctor($patientId, Patient $resource)
    {
        $docId = $this->currentUser->docid ?: 0;

        $resource->deleteForDoctor($patientId, $docId);

        return ApiResponse::responseOk('Resource deleted');
    }

    public function find(Patients $resources, Request $request)
    {
        $docId           = $this->currentUser->docid ?: 0;
        $userType        = $this->currentUser->user_type ?: 0;

        $patientId       = $request->input('patientId') ?: 0;
        $type            = $request->input('type') ?: 1;
        $pageNumber      = $request->input('page') ?: 0;
        $patientsPerPage = $request->input('patientsPerPage') ?: 30;
        $letter          = $request->input('letter') ?: '';
        $sortColumn      = $request->input('sortColumn') ?: 'name';
        $sortDir         = $request->input('sortDir') ?: '';

        $data = $resources->find(
            $docId,
            $userType,
            $patientId,
            $type,
            $pageNumber,
            $patientsPerPage,
            $letter,
            $sortColumn,
            $sortDir
        );

        return ApiResponse::responseOk('', $data);
    }

    public function getReferredByContact(Patients $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getReferredByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByContact(Patients $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function addNewPatient(
        Patient $patientResource,
        InsurancePreauth $insurancePreauthResource,
        PatientStore $request
    ) {
        $patient = $request->all();

        if ($patient['p_m_eligible_payer'] != '') {
            $patient['p_m_eligible_payer_id'] = substr($patient['p_m_eligible_payer'], 0, strpos($patient['p_m_eligible_payer'], '-'));
            $patient['p_m_eligible_payer_name'] = substr($patient['p_m_eligible_payer'], (strpos($patient['p_m_eligible_payer'], '-') + 1));
        } else {
            $patient['p_m_eligible_payer_id'] = '';
            $patient['p_m_eligible_payer_name'] = '';
        }

        if ($patient['s_m_eligible_payer'] != '') {
            $patient['s_m_eligible_payer_id'] = substr($patient['s_m_eligible_payer'], 0, strpos($patient['s_m_eligible_payer'], '-'));
            $patient['s_m_eligible_payer_name'] = substr($patient['s_m_eligible_payer'], (strpos($patient['s_m_eligible_payer'], '-') + 1));
        } else {
            $patient['s_m_eligible_payer_id'] = '';
            $patient['s_m_eligible_payer_name'] = '';
        }

        if (/* existing patient (update) */) {
            $oldPatient = $patientResource->find($patientId);

            if ($oldPatient->registration_status == 2 && $patient['email'] != $oldPatient->email) {
                sendUpdatedEmail($patientId, $patient['email'], $oldPatient->email, 'doc');
            } elseif (isset($patient['sendRem'])) {
                // send reminder email
                sendRemEmail($newPatientId, $patient['email']);
            } elseif (!isset($patient['sendReg']) && $oldPatient->registration_status == 1 && trim($patient['email']) != trim($oldPatient['email'])) {
                if ($docPatientPortal && $usePatientPortal) {
                    // send reg email if email is updated and not registered
                    sendRegEmail($newPatientId, $patient['email'], '');
                }
            }

            if ($patient['email'] != $oldPatient['email']) {
                $patient['email_bounce'] = 0;
            }

            $patientResource->update($patient);
            $patientResource->updateChildrenPatients($patientId, ['email' => $patient['email']]);

            $insuranceInfoFieldsArray = [
                'p_m_relation', 'p_m_partyfname', 'p_m_partylname',
                'ins_dob', 'p_m_ins_type', 'p_m_ins_ass',
                'p_m_ins_id', 'p_m_ins_grp', 'p_m_ins_plan'
            ];

            $hasInsuranceInfoChanged = false;

            foreach ($insuranceInfoFieldsArray as $field) {
                if ($oldPatient[$field] != $patient[$field]) {
                    $hasInsuranceInfoChanged = true;
                    break;
                }
            }

            if ($hasInsuranceInfoChanged) {
                $userName = $this->currentUser->name ?: '';

                $updatedVob = $insurancePreauthResource->updateVob($newPatientId, $userName);

                if ($updatedVob) {
                    $c = create_vob($newPatientId);

                    if (isset($patient['location'])) {
                        
                    }
                }
            }
        }
    }
}
