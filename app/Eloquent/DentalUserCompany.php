<?php

namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class DentalUserCompany extends Model
{

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['userid', 'companyid', 'adddate', 'ip_address'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_user_company';

    /**
     * @var bool
     */
    public $timestamps = false;

    public function Company()
    {
        $this->belongsTo('DentalSleepSolutions\Company', 'id', 'companyid');
    }

}
