<?php
namespace Ds3\Http\Controllers\Admin;

use Ds3\Http\Controllers\Controller;

class VobController extends Controller
{
    public function index()
    {
        return view('admin.vob');
    }
}
