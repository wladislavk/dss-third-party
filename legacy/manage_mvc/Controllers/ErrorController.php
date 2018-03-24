<?php namespace Ds3\Libraries\Legacy; ?><?php

namespace Controllers;

class ErrorController
{
	function index()
	{
		echo "<pre>"; var_dump('Page not found'); trigger_error("Die called", E_USER_ERROR);
	}
}
