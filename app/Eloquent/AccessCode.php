<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    protected $table = 'dental_access_codes';
    protected $primaryKey = 'id';
    protected $fillable = ['access_code', 'notes', 'status','ip_address','plan_id'];

    public function users()
    {
        return $this->hasMany('Ds3\Eloquent\Auth\User','plan_id');
    }

    public function getPlan($plan_id)
    {
        return Plan::find($plan_id);
    }
}
