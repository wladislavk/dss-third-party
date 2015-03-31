<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\UserInterface;
use Ds3\Eloquent\Auth\User;
use Ds3\Libraries\Password;

class UserRepository implements UserInterface
{
    public function attemptAuth($username, $password)
    {
        $userSalt = User::select('salt')
            ->where('username', '=', $username)
            ->first();

        if ($userSalt) {
            $hashPassword = Password::genPassword($password, $userSalt->salt);

            $dataUser = User::leftJoin('dental_user_company', 'dental_user_company.userid', '=', 'dental_users.userid')
                ->select('dental_users.*', 'dental_user_company.companyid')
                ->where('username', '=', $username)
                ->where('password', '=', $hashPassword)
                ->whereBetween('status', array(1, 3))
                ->first();

            if (!empty($dataUser)) {
                return ['success' => true, 'user' => $dataUser];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }

        return $user;
    }

    public function getType($docId)
    {
        try {
            $user = User::where('userid', '=', $docId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $user->user_type;
    }

    public function findUser($userId)
    {
        return User::find($userId);
    }

    public function getCourseJoin($userId)
    {
        $courseJoin = DB::table(DB::raw('dental_users s'))
            ->select(DB::raw('s.use_course, d.use_course_staff'))
            ->join(DB::raw('dental_users d'), 'd.userid', '=', 's.docid')
            ->where('s.userid', '=', $userId)
            ->first();

        return $courseJoin;
    }

    public function getProviderSelect($docId)
    {
        $users = User::whereRaw('(docid = ' . $docId . ' OR userid = ' . $docId . ')')
            ->where('npi', '!=', '')
            ->where(function($query){
                $query->producer()->orWhere('docid', '=', 0);
            })
            ->orderBy('docid')
            ->get();

        return $users;
    }

    public function getProducerOptions($docId)
    {
        $producerOptions = User::where('userid', '=', $docId)
            ->orWhereRaw('(docid = ' . $docId . ' AND producer = 1)')
            ->get();

        return $producerOptions;
    }

    public function getCheck($username, $password, $docId)
    {
        $check = User::where('username', '=', $username)
            ->where('password', '=', $password)
            ->active()
            ->whereRaw('(sign_notes = 1 OR userid = ' . $docId . ')')
            ->get();

        return $check;
    }

    public function getLocation($where, $defaultLocation = null)
    {
        $location = DB::table(DB::raw('dental_users u'))
            ->select(DB::raw('l.phone mailing_phone, u.user_type, u.logo, l.location mailing_practice, l.address mailing_address, l.city mailing_city, l.state mailing_state, l.zip mailing_zip'))
            ->join(DB::raw('dental_patients p'), 'u.userid', '=', 'p.docid');

        if (!empty($defaultLocation)) {
            $location = $location->leftJoin(DB::raw('dental_locations l'), function($join){
                $join->on('l.docid', '=', 'u.userid')
                     ->where('l.default_location', '=', '1');
            });
        } else {
            $location = $location->leftJoin(DB::raw('dental_locations l'), 'l.docid', '=', 'u.userid');
        }

        foreach ($where as $attribute => $value) {
            $location = $location->where($attribute, '=', $value);
        }

        return $location->first();
    }

    public function isUniqueField($field, $userId)
    {
        reset($field);
        $attribute = key($field);
        $value = $field[$attribute];

        $user = User::where($attribute, '=', $value)->where('userid', '!=', $userId);

        return $user->get();
    }

    public function getResponsible($userId, $docId)
    {
        $responsible = User::active()
            ->where(function($query) use ($userId, $docId){
                $query->where('userid', '=', $userId)
                      ->orWhere('docid', '=', $docId);
            })
            ->get();

        return $responsible;
    }

    public function updateData($userId, $values)
    {
        $user = User::where('userid', '=', $userId)->update($values);

        return $user;
    }

    public function insertData($data)
    {
        $user = new User();

        foreach ($data as $attribute => $value) {
            $user->$attribute = $value;
        }

        try {
            $user->save();
        } catch (ModelNotFoundException $e) {
            return null;
        }

        return $user->userid;
    }
}
