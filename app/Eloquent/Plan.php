<?php namespace Ds3\Eloquent;

use Ds3\Eloquent\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'dental_plans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','monthly_fee','trial_period','fax_fee','free_fax','eligibility_fee','free_eligibility',
        'enrollment_fee','free_enrollment','claim_fee','free_claim','efile_fee','free_efile','vob_fee',
        'free_vob','producer_fee','user_fee','patient_fee','duration','office_type','status',
    ];

    public function users()
    {
        return $this->hasMany(new User,'plan_id');
    }
}
