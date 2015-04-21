<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class QImage extends Model
{
    protected $table = 'dental_q_image';
    protected $primaryKey = 'imageid';
    public $timestamps = false;
}
