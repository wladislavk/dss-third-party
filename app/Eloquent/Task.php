<?php namespace Ds3;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Task extends Model
{
	protected $table = 'dental_task';

	protected $fillable = ['task', 'userid', 'responsibleid', 'status'];

	protected $primaryKey = 'id';

	public static function get($userId, $docId, $patientId, $task, $type = null, $input = null)
	{
		$tasks = DB::table('dental_task')->join('dental_users', 'dental_task.responsibleid', '=', 'dental_users.userid')
										->leftJoin('dental_patients', 'dental_patients.patientid', '=', 'dental_task.patientid')
										->select('dental_task.*', 'dental_users.name', 'dental_patients.firstname', 'dental_patients.lastname')
										->where(function($query)
										{
											$query->where('dental_task.status', '=', '0')
												  ->orWhereNull('dental_task.status');
										});
		if ($task == 'task') {
			$tasks = $tasks->where('dental_task.responsibleid', '=', $userId);
		} else {
			$tasks = $tasks->whereRaw('(dental_users.docid = ' . $docId . ' OR dental_users.userid = ' . $docId . ')')
						   ->where('dental_task.patientid', '=', $patientId);
		}

		switch ($type) {
			case 'od':
				$tasks = $tasks->where('dental_task.due_date', '<', 'CURDATE()');
				break;

			case 'tod':	
				$tasks = $tasks->where('dental_task.due_date', '=', 'CURDATE()');
				break;

			case 'tom':
				$tasks = $tasks->where('dental_task.due_date', '=', 'DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
				break;

			case 'fut':
				$tasks = $tasks->where('dental_task.due_date', '>', 'DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
				break;

			case 'tw':
				$tasks = $tasks->whereBetween('dental_task.due_date', array('DATE_ADD(CURDATE(), INTERVAL 2 DAY)', $inputValues['this_sun']));
				break;

			case 'nw':
				$tasks = $tasks->whereBetween('dental_task.due_date', array($input['next_mon'], $input['next_sun']));
				break;

			case 'lat':
				$tasks = $tasks->where('dental_task.due_date', '>', $input['next_sun'])
							   ->orderBy('dental_task.due_date', 'asc');
				break;

			default:
				break;
		}						

		return $tasks->get();
	}
}