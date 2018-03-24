<?php
namespace Ds3\Eloquent\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $table = 'dental_contacttype';
    protected $primaryKey = 'contacttypeid';

    public function scopePhysician($query)
    {
        return $query->where('physician', '=', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function scopeNonCorporate($query)
    {
        return $query->where('corporate', '=', 0);
    }
}
