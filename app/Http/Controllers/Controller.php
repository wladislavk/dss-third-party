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
        'userid' => 0,
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
    protected $user;

    /** @var User */
    protected $admin;

    public function __construct(
        Config $config,
        Request $request
    ) {
        $this->config = $config;
        $this->request = $request;

        $this->user = new User();
        $this->admin = new User();

        $this->user->forceFill(self::EMPTY_MODEL_ATTRIBUTES);
        $this->admin->forceFill(self::EMPTY_MODEL_ATTRIBUTES);

        if ($request->user()) {
            $this->user = $request->user();
        }

        if ($request->admin()) {
            $this->admin = $request->admin();
        }
    }
}
