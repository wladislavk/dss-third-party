<?php namespace Ds3\Http\Controllers;

class WelcomeController extends Controller {

	public function index($id)
	{
		return view('welcome');
	}

}
