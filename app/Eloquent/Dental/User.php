<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\User as Resource;
use DentalSleepSolutions\Contracts\Repositories\Users as Repository;
use DB;

class User extends Model implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['userid', 'password', 'salt'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'salt'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'dental_users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
     protected $primaryKey = 'userid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'recover_time', 'last_accessed_date', 'text_date',
        'access_code_date', 'registration_email_date',
        'registration_date', 'suspended_date'
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * Get user type by user id
     *
     * @param integer $userId
     * @return \DentalSleepSolutions\Eloquent\Dental\User
     */
    public function getUserType($userId)
    {
        return self::select('user_type')
            ->where('userid', $userId)
            ->first();
    }


    /**
     * Get doc id by user id
     *
     * @param integer $userId
     * @return \DentalSleepSolutions\Eloquent\Dental\User
     */
    public function getDocId($userId)
    {
        return self::select(DB::raw('
            CASE docid
                WHEN 0 THEN userid
                ELSE docid
            END as docid'))
            ->where('userid', $userId)
            ->first();
    }

    /**
     * Get course staff by user id
     *
     * @param integer $userId
     * @return \DentalSleepSolutions\Eloquent\Dental\User
     */
    public function getCourseStaff($userId)
    {
        return self::from(DB::raw('dental_users s'))
            ->select(DB::raw('s.use_course, d.use_course_staff'))
            ->join(DB::raw('dental_users d'), 'd.userid', '=', 's.docid')
            ->where('s.userid', $userId)
            ->first();
    }

    public function getPaymentReports($docId = 0)
    {
        return $this->select('use_payment_reports')
            ->where('userid', $docId)
            ->first();
    }

    public function getLastAccessedDate($userId = 0)
    {
        return $this->select('last_accessed_date')
            ->where('userid', $userId)
            ->first();
    }

    public function getLetterInfo($docId = 0)
    {
        return $this->select('use_letters', 'intro_letters')
            ->where('userid', $docId)
            ->first();
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
    public function getWithFilter(array $fields = [], array $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    /**
     * @param $docId
     * @param $patientId
     * @param int $locationId
     * @return User|null
     */
    public function getMailingData($docId, $patientId, $locationId = 0)
    {
        $query = $this->select(
                'l.phone AS mailing_phone',
                'u.user_type',
                'u.logo',
                'l.location AS mailing_practice',
                'l.address AS mailing_address',
                'l.city AS mailing_city',
                'l.state AS mailing_state',
                'l.zip AS mailing_zip'
            )->from(DB::raw('dental_users u'))
            ->join(DB::raw('dental_patients p'), 'u.userid', '=', 'p.docid')
            ->leftJoin(DB::raw('dental_locations l'), 'l.docid', '=', 'u.userid');

        if ($locationId) {
            $query = $query->where('l.id', $locationId)
                ->where('l.docid', $docId);
        } else {
            $query = $query->where('l.default_location', 1)
                ->where('p.patientid', $patientId);
        }

        return $query->first();
    }

    /**
     * @return int
     */
    public function getDocIdOrZero()
    {
        if ($this->docid) {
            return $this->docid;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getUserIdOrZero()
    {
        // TODO: there is no ID field by default on this model
        if (property_exists($this, 'id') && $this->id) {
            return $this->id;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getUserTypeOrZero()
    {
        if ($this->user_type) {
            return $this->user_type;
        }
        return 0;
    }
}
