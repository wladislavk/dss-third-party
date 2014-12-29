<?php namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

use Ds3\User;
use Ds3\DocumentCategory;

class IndexController extends Controller
{
	public function index()
	{
 		$receivedValues = User::getValues(Session::get('docId'), array('homepage', 'manage_staff', 'use_course', 'use_eligible_api'));

 		if ($receivedValues['homepage'] != 1) {
 			return redirect('/manage/index2');
 		}

 		$documentCategories = DocumentCategory::get();

 		$course = User::getCourse(Auth::user()->userid);

 		return view('manage.index', compact('documentCategories', 'receivedValues', 'course'));
 	}
}