<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PatientContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\PatientContacts as Repository;
use DB;

class PatientContact extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patient_contacts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getCurrent($docId = 0, $patientId = 0)
    {
        return $this->from(DB::raw('dental_patient_contacts pc'))
            ->select(DB::raw('pc.id, pc.contacttype, pc.firstname, pc.lastname, pc.address1,'
                . 'pc.address2, pc.city, pc.state, pc.zip, pc.phone, p.firstname as patfirstname,'
                . 'p.lastname as patlastname'))
            ->join(DB::raw('dental_patients p'), 'pc.patientid', '=', 'p.patientid')
            ->where('p.docid', $docId)
            ->where('p.patientid', $patientId)
            ->get();
    }

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(id) AS total'))
            ->from(DB::raw('dental_patient_contacts pc'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'pc.patientid')
            ->where('p.docid', $docId)
            ->first();
    }
}
