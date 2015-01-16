<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Http\Controllers\Controller;

class VobController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.vob');
	}


}
