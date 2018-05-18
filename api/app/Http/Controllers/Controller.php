<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Config\Repository as Config;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    const EMPTY_MODEL_ATTRIBUTES = [
        'id' => '',
        'adminid' => 0,
        'userid' => 0,
        'patientid' => 0,
        'docid' => 0,
        'user_type' => 0,
        'status' => 0,
    ];

    // TODO: this class should include common REST methods for all its children
    use DispatchesJobs, ValidatesRequests;

    /** @var Config */
    protected $config;

    /** @var Request */
    protected $request;

    /** @var User */
    protected $patient;

    /** @var User */
    protected $user;

    /** @var User */
    protected $admin;

    public function __construct(
        Config $config,
        Request $request
    ) {
        $this->config = $config;
        $this->request = $request;

        $this->patient = new User();
        $this->user = new User();
        $this->admin = new User();

        $this->patient->forceFill(self::EMPTY_MODEL_ATTRIBUTES);
        $this->user->forceFill(self::EMPTY_MODEL_ATTRIBUTES);
        $this->admin->forceFill(self::EMPTY_MODEL_ATTRIBUTES);

        if ($request->patient()) {
            $this->patient = $request->patient();
        }

        if ($request->user()) {
            $this->user = $request->user();
        }

        if ($request->admin()) {
            $this->admin = $request->admin();
        }
    }

    /**
     * @return User
     */
    protected function admin()
    {
        $model = $this->request->admin();
        if ($model) {
            return $model;
        }
        return $this->admin;
    }

    /**
     * @return User
     */
    protected function user()
    {
        $model = $this->request->user();
        if ($model) {
            return $model;
        }
        return $this->user;
    }

    /**
     * @return User
     */
    protected function patient()
    {
        $model = $this->request->patient();
        if ($model) {
            return $model;
        }
        return $this->patient;
    }
}
