<?php
namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'docid', 'salutation', 'lastname', 'firstname',
        'middlename', 'company', 'add1', 'add2',
        'city', 'state', 'zip', 'phone1',
        'phone2', 'fax', 'email', 'national_provider_id',
        'qualifier', 'qualifierid', 'greeting', 'sincerely',
        'contacttypeid', 'notes', 'preferredcontact', 'status',
        'adddate', 'ip_address', 'referredby_info', 'referredby_notes',
        'merge_id', 'merge_date', 'corporate', 'dea_number'
    ];

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
    protected $table = 'dental_contact';

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
    protected $primaryKey = 'contactid';
}
