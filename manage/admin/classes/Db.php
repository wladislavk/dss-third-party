<?php namespace Ds3\Libraries\Legacy; ?><?php 

class Db
{
	public $SHOW_QUERY = false;
	public $SHOW_TIMESTAMP = false;
	public $con;
	// Perfom query
	public function __construct()
	{
		$this->con = $GLOBALS['con'];
	}
	public function query($query_string)
	{
		if($query_string) {
			if( $this->SHOW_TIMESTAMP ) {
				$time = microtime(TRUE);
			}

			$result = mysqli_query($this->con, $query_string) or trigger_error($query_string . ' ' . mysqli_error($this->con), E_USER_ERROR);

			if( $this->SHOW_TIMESTAMP ) {
				$time = microtime(TRUE) - $time;
				echo 'Query Time: ' . $time .  '<br>';
			}

			if( $this->SHOW_QUERY ) {
				echo '<pre>' . $query_string . '</pre><br><hr>';
			}

			return $result;
		}
		return;
	}

	// Get the first result row
	public function getRow($query_string)
	{
		if( $query_string ) {
			$result = $this->query($query_string);
			if ($result) {
				$return = mysqli_fetch_assoc($result);
			}
			return $return;
		}
		return;
	}

	public function getResults($query_string)
	{
		if( $query_string ) {
			$return = array();
			$result = $this->query($query_string);
			if ($result) {
				while ($row = mysqli_fetch_assoc($result)) {
					$return[] = $row;
				}
			}
			return $return;
		}
		return;
	}

	// Get count of result rows
	public function getNumberRows($query_string)
	{
		if( $query_string ) {
			$result = $this->query($query_string);
			if ($result) {
				$return = mysqli_num_rows($result);
			} else {
				$return = 0;
			}
			return $return;
		}
	}

	public function getInsertId($query_string)
	{
		if( $query_string ) {
			$result = $this->query($query_string);
			$indert_id = mysqli_insert_id($this->con);
			return $indert_id;
		}
		return NULL;
	}

	public function escape($string)
	{
		return mysqli_real_escape_string($this->con, $string);
	}

}
