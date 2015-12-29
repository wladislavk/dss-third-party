<?php
namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class ClaimText extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'adddate', 'ip_address', 'default_text', 'companyid'];

    /**
     * Defining guarded attributes
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Mass of nondisplayed attributes
     * 
     * @var array
     */
    protected $hidden = ['ip_address'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_claim_text';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
