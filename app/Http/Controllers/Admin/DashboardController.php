<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Http\Controllers\Controller;

class DashboardController extends Controller {

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}