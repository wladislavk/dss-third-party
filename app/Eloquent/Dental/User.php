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
}
