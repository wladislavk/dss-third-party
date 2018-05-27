<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Services\Auth\Guard;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Config\Repository as Config;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\Auth\Factory as Auth;

abstract class Controller extends BaseController
{
    // TODO: this class should include common REST methods for all its children
    use DispatchesJobs, ValidatesRequests;

    /** @var Auth */
    protected $auth;

    /** @var Config */
    protected $config;

    /** @var Request */
    protected $request;

    /** @var Patient */
    protected $patient;

    /** @var User */
    protected $user;

    /** @var Admin */
    protected $admin;

    /**
     * @param Auth $auth
     * @param Config $config
     * @param Request $request
     * @throws \InvalidArgumentException
     */
    public function __construct(
        Auth $auth,
        Config $config,
        Request $request
    ) {
        $this->auth = $auth;
        $this->config = $config;
        $this->request = $request;
        $this->patient = new Patient();
        $this->user = new User();
        $this->admin = new Admin();

        $this->admin->adminid = 0;
        $this->user->userid = 0;
        $this->user->docid = 0;
        $this->user->user_type = 0;
        $this->user->status = 0;
        $this->patient->patientid = 0;
        $this->patient->docid = 0;

        /** @var Guard $guard */
        $guard = $auth->guard(JwtHelper::ROLE_ADMIN);
        if ($guard->user()) {
            $this->admin = $guard->user();
        }

        /** @var Guard $guard */
        $guard = $auth->guard(JwtHelper::ROLE_USER);
        if ($guard->user()) {
            $this->user = $guard->user();
        }

        /** @var Guard $guard */
        $guard = $auth->guard(JwtHelper::ROLE_PATIENT);
        if ($guard->user()) {
            $this->patient = $guard->user();
        }
    }

    /**
     * @return Admin
     * @throws \InvalidArgumentException
     */
    protected function admin(): Admin
    {
        /** @var Guard $guard */
        $guard = $this->auth->guard(JwtHelper::ROLE_ADMIN);
        if ($guard->user()) {
            return $guard->user();
        }
        return $this->admin;
    }

    /**
     * @return User
     * @throws \InvalidArgumentException
     */
    protected function user(): User
    {
        /** @var Guard $guard */
        $guard = $this->auth->guard(JwtHelper::ROLE_USER);
        if ($guard->user()) {
            return $guard->user();
        }
        return $this->user;
    }

    /**
     * @return Patient
     * @throws \InvalidArgumentException
     */
    protected function patient(): Patient
    {
        /** @var Guard $guard */
        $guard = $this->auth->guard(JwtHelper::ROLE_PATIENT);
        if ($guard->user()) {
            return $guard->user();
        }
        return $this->patient;
    }
}
