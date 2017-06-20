<?php

namespace DentalSleepSolutions\Http\Requests;

class Admin extends Request
{
    private $adminModel;

    protected $rules = [
        'name'         => 'max:250',
        'username'     => 'required|max:250|unique:admin',
        'password'     => 'required|max:250',
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
        /** @var \DentalSleepSolutions\Eloquent\Admin $admin */
        $admin = $this->adminModel->findOrFail(Request::input('id'));
        $ignore = $admin->getKeyName() . ',' . $admin->getKey();

        $rules = $this->rules;
        $rules['username'] = 'sometimes|required|max:250|unique:admin,username,' . $ignore;
        $rules['password'] = 'sometimes|required|max:250';

        return $rules;
    }
}
