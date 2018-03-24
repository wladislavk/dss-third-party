<?php namespace Ds3\Libraries\Legacy; ?><?php
namespace Core;
use Models\Db;
class Controller {
	
	public $db;
	public $view;
	
	function __construct()
	{
		$this->view = new View();
		$this->db = new Db();
	}
	
	// действие (action), вызываемое по умолчанию
	function action_index()
	{
		// todo	
	}
}
