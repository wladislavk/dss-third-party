<?php

namespace DentalSleepSolutions\Http\Requests;

class Admin extends Request
{
    private $adminModel;

    protected $rules = [
        'name'         => 'string|max:250',
        'username'     => 'required|string|max:250|unique:admin',
        'password'     => 'required|string|max:250',
        'status'       => 'integer',
        'admin_access' => 'integer',
        'email'        => 'email|max:100',
        'first_name'   => 'string|max:50',
        'last_name'    => 'string|max:50',
    ];

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null, \DentalSleepSolutions\Eloquent\Admin $adminModel = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->adminModel = $adminModel;
    }

    /**
     * @return array
     */
    public function updateRules()
    {
        $rules = $this->rules;
        // @todo: uncomment this as soon as it's understood how to make it play nice with swagger
        //$ignore = $this->getIgnore();
        //$rules['username'] = 'sometimes|required|max:250|unique:admin,username,' . $ignore;
        $rules['username'] = 'sometimes|required|max:250|unique:admin,username';
        $rules['password'] = 'sometimes|required|max:250';

        return $rules;
    }

    /**
     * @return string
     */
    private function getIgnore()
    {
        /** @var \DentalSleepSolutions\Eloquent\Admin $admin */
        $admin = $this->adminModel->findOrFail(Request::input('id'));
        $ignore = $admin->getKeyName() . ',' . $admin->getKey();
        return $ignore;
    }
}
