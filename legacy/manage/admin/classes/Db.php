<?php namespace Ds3\Libraries\Legacy; ?><?php 

class Db
{
	public $SHOW_QUERY = false;
	public $SHOW_TIMESTAMP = false;
	public $SHOW_TOTAL_TIME = false;
	private $totalTime;
	public $con;
	// Perfom query
	public function __construct()
	{
		$this->totalTime = 0;
		$this->con = $GLOBALS['con'];
	}

	public function resetTotalTime()
	{
		$this->totalTime = 0;
	}

	public function query($query_string)
	{
		if($query_string) {
			$time = microtime(TRUE);

			$result = mysqli_query($this->con, $query_string) or trigger_error($query_string . ' ' . mysqli_error($this->con), E_USER_ERROR);

			$time = microtime(TRUE) - $time;
			$this->totalTime += $time;

			if( $this->SHOW_TIMESTAMP ) {
				echo 'Query Time: ' . $time .  '<br>';
			}

			if( $this->SHOW_TOTAL_TIME ) {
				echo 'Total Query Time: ' . $this->totalTime .  '<br>';
			}
			if( $this->SHOW_QUERY ) {
				echo '<pre>' . $query_string . '</pre><br><hr>';
			}

			return $result;
		}
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
	}

    /**
     * Return column from the first row of the result
     *
     * @param string $queryString
     * @param string $columnName
     * @param mixed  $defaultValue
     * @return mixed
     */
    public function getColumn ($queryString, $columnName, $defaultValue=null) {
        $row = $this->getRow($queryString);

        return $row ? array_get($row, $columnName, $defaultValue) : $defaultValue;
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
			$insert_id = $result ? mysqli_insert_id($this->con) : 0;
			return $insert_id;
		}
	}

	public function getAffectedRows ($query) {
		if ($query) {
			$this->query($query);
			return mysqli_affected_rows($this->con);
		}

		return false;
	}

	public function escape($string)
	{
		return mysqli_real_escape_string($this->con, $string);
	}

    public function escapeList (Array $values, $isIdentifier=false) {
        $db = $this;
        $delimiter = $isIdentifier ? "`" : "'";

        array_walk($values, function (&$each) use ($db, $delimiter) {
            $each = $delimiter . $db->escape($each) . $delimiter;
        });

        return join(', ', $values);
    }

    public function escapeAssignmentList (Array $values) {
        $db = $this;

        array_walk($values, function (&$each, $key) use ($db) {
            $each = '`' . $db->escape($key) . "` = '" . $db->escape($each) . "'";
        });

        return join(', ', $values);
    }

    /**
     * Returns the columns of the given table
     *
     * @param string $tableName
     * @return mixed
     */
    public function getColumnNames ($tableName) {
        $tableName = $this->escape($tableName);
        $columns = $this->getResults("SELECT column_name FROM information_schema.columns WHERE table_name = '$tableName'");

        return array_pluck($columns, 'column_name');
    }

    /**
     * Auxiliary method to determine the intersection between the columns of two tables, aimed to simplify the process
     * of saving one table into its corresponding history table.
     *
     * @param string $sourceTable
     * @param string $historyTable
     * @return string
     */
    public function backupColumns ($sourceTable, $historyTable) {
        $sourceColumns = $this->getColumnNames($sourceTable);
        $historyColumns = $this->getColumnNames($historyTable);

        $backupColumns = array_intersect($sourceColumns, $historyColumns);
        $backupColumns = array_unique($backupColumns);
        $backupColumns = $this->escapeList($backupColumns, true);

        return $backupColumns;
    }
}
