<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table = 'dental_custom';
    protected $primaryKey = 'customid';
    //public $timestamps = false;
}
