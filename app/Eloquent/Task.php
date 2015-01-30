<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $table = 'dental_task';

	protected $primaryKey = 'id';
}