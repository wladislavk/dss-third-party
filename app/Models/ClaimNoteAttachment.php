<?php
namespace DentalSleepSolutions\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimNoteAttachment extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['note_id', 'filename', 'adddate', 'ip_address'];

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
    protected $table = 'dental_claim_note_attachment';

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
