<?php namespace Ds3\Libraries\Legacy; ?><?php

namespace Controllers;

class TestController
{
	function index()
	{
		echo "<pre>"; var_dump('test'); die();
		include_once(APP_PATH.'/views/index/index.phtml');
	}
}
