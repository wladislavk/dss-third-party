<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'dental_contact';
    protected $primaryKey = 'contactid';
}
