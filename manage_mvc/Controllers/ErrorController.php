<?php

namespace Controllers;

class ErrorController
{
	function index()
	{
		echo "<pre>"; var_dump('Page not found'); die();
	}
}