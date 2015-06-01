<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'dental_resources';
    protected $fillable = ['name', 'rank', 'docid'];
    protected $primaryKey = 'id';
}
