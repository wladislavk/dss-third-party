<?php
namespace DentalSleepSolutions\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimElectronic extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['claimid', 'response', 'adddate', 'ip_address', 'reference_id', 'percase_date', 'percase_name', 'percase_amount', 'percase_status', 'percase_invoice', 'percase_free'];

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
    protected $table = 'dental_claim_electronic';

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
