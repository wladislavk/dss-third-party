<?php

namespace Models;

class Db extends Config
{
	public function __construct()
	{
		mysql_connect($this->host, $this->user, $this->password);	
		mysql_select_db($this->dBName);
	}

	// Perfom query
	public function query($query_string)
	{
		return mysql_query($query_string);
	}

	// Get the first result row
	public function getRow($query_string)
	{
		$result = $this->query($query_string);
		return mysql_fetch_assoc($result);		
	}

	public function getResults($query_string)
	{
		$result = $this->query($query_string);
		while($row = mysql_fetch_assoc($result)){
			$return[] = $row;
		}
		return $return;
	}

	// Get count of result rows
	public function getNumberRows($query_string)
	{
		$result = $this->query($query_string);
		return mysql_num_rows($result);
	}

	public function getInsertId($query_string)
	{
		$result = $this->query($query_string);
		return mysql_insert_id();
	}

}
?>
