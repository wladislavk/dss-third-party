<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
    public function model()
    {
        return User::class;
    }

    /**
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getLastAccessedDate($userId)
    {
        return $this->model->select('last_accessed_date')
            ->where('userid', $userId)
            ->first();
    }

    /**
     * @param int $docId
     * @return User|null
     */
    public function getLetterInfo($docId)
    {
        return $this->model->select('use_letters', 'intro_letters')
            ->where('userid', $docId)
            ->first();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @param int $locationId
     * @return User|null
     */
    public function getMailingData($docId, $patientId, $locationId)
    {
        $query = $this->model->select(
            'l.phone AS mailing_phone',
            'u.user_type',
            'u.logo',
            'l.location AS mailing_practice',
            'l.address AS mailing_address',
            'l.city AS mailing_city',
            'l.state AS mailing_state',
            'l.zip AS mailing_zip'
        )->from(\DB::raw('dental_users u'))
            ->join(\DB::raw('dental_patients p'), 'u.userid', '=', 'p.docid')
            ->leftJoin(\DB::raw('dental_locations l'), 'l.docid', '=', 'u.userid');

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
     * @param int $userId
     * @return User|null
     */
    public function getDocId($userId)
    {
        return $this->model->select(\DB::raw('
            CASE docid
                WHEN 0 THEN userid
                ELSE docid
            END as docid'))
            ->where('userid', $userId)
            ->first();
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function getUserType($userId)
    {
        return $this->model->select('user_type')
            ->where('userid', $userId)
            ->first();
    }
}
