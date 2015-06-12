<?php namespace Ds3\Libraries\Legacy; ?><?php

namespace Models;
use PDO;

class Db extends Config
{
	protected $dataBase;
	public function __construct(){
		$this->dBConnection();
	}

	private function dBConnection(){ 
		// mysql_connect($this->host, $this->user, $this->password);	
		// mysql_select_db($this->dBName);
		$this->dataBase = new PDO('mysql:host='.$this->host.'; dbname='.$this->dBName, $this->user , $this->password);
	}

	public function queryPDO($query_string)
	{
		$query = $this->dataBase->prepare($query_string);
		$query->execute();
		return $query;
	}

	public function getResultsPDO($query_string)
	{
		$query = $this->queryPDO($query_string);
        $result = $query->fetchAll();
        return $result;
	}

	public function getRowPDO($query_string)
	{
		$query = $this->queryPDO($query_string);
        $result = $query->fetchAll();
        return $result[0];
	}


	// // Perfom query
	// public function query($query_string)
	// {
	// 	return mysql_query($query_string);
	// }

	// // Get the first result row
	// public function getRow($query_string)
	// {
	// 	$result = $this->query($query_string);
	// 	return mysql_fetch_assoc($result);		
	// }

	// public function getResults($query_string)
	// {
	// 	$result = $this->query($query_string);
	// 	while($row = mysql_fetch_assoc($result)){
	// 		$return[] = $row;
	// 	}
	// 	return $return;
	// }

	// // Get count of result rows
	// public function getNumberRows($query_string)
	// {
	// 	$result = $this->query($query_string);
	// 	return mysql_num_rows($result);
	// }

	// public function getInsertId($query_string)
	// {
	// 	$result = $this->query($query_string);
	// 	return mysql_insert_id();
	// }

}
?>
