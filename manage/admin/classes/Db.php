<?php namespace Ds3\Libraries\Legacy; ?><?php 

class Db
{
	public $con;
	// Perfom query
	public function __construct()
	{
		$this->con = $GLOBALS['con'];
	}
	public function query($query_string)
	{
		if($query_string)
		{
			$result = mysqli_query($this->con, $query_string) or trigger_error($query_string . ' ' . mysqli_error($this->con), E_USER_ERROR);
			return $result;
		}
		return;
		
	}

	// Get the first result row
	public function getRow($query_string)
	{
		$result = $this->query($query_string);
		if ($result) {

			$return = mysqli_fetch_assoc($result);

		}
		return $return;		
	}

	public function getResults($query_string)
	{
		$return = array();

		$result = $this->query($query_string);
		if ($result) {
			while($row = mysqli_fetch_assoc($result)){
				$return[] = $row;
			}
		}
		
		return $return;
	}

	// Get count of result rows
	public function getNumberRows($query_string)
	{
		$result = $this->query($query_string);
		if ($result) {
			$return = mysqli_num_rows($result);
		} else {
			$return = 0;
		}
		return $return;
	}

	public function getInsertId($query_string)
	{
		$result = $this->query($query_string);
		return mysqli_insert_id($this->con);
	}

}
?>
