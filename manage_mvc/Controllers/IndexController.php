<?php

namespace Controllers;

class IndexController
{
	function index()
	{
		
		include_once(APP_PATH.'/views/index/index.phtml');
	}
}