<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_contact';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'contactid';
}
