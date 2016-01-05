<?php
namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'contacttype', 'description', 'sortby', 'status',
        'adddate', 'ip_address', 'physician', 'corporate'
    ];

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
    protected $table = 'dental_contacttype';

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
    protected $primaryKey = 'contacttypeid';
}
