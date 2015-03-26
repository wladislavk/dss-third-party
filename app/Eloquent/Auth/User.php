<?php
namespace Ds3\Eloquent\Auth;

use Ds3\Libraries\Constants;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Ds3\Eloquent\Location;
use Ds3\Eloquent\Contact;
use Ds3\Eloquent\Patient\Patient;
use Ds3\Eloquent\Invoice\PercaseInvoice;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'dental_users';
    protected $fillable = ['username', 'email', 'password'];
    protected $hidden = ['password'];
    protected $primaryKey = 'userid';

    public function getLocations()
    {
        return $this->hasMany(new Location, 'docid');
    }

    public function getContacts()
    {
        return $this->hasMany(new Contact, 'docid');
    }

    public function getPatients()
    {
        return $this->hasMany(new Patient, 'docid');
    }

    public function getStaff()
    {
        return $this->where('docid', $this->userid)->where('user_access', 1)->count();
    }

    public function getInvoices()
    {
        return $this->hasMany(new PercaseInvoice, 'docid');
    }

    public function isSuper($access)
    {
        return (Constants::DSS_ADMIN_ACCESS_SUPER === $access);
    }

    public function isAdmin($access)
    {
        return (Constants::DSS_ADMIN_ACCESS_ADMIN === $access || Constants::DSS_ADMIN_ACCESS_SUPER === $access);
    }

    public function isBilling($access)
    {
        return (Constants::DSS_ADMIN_ACCESS_BILLING_ADMIN === $access || Constants::DSS_ADMIN_ACCESS_BILLING_BASIC === $access);
    }

    public function isHstAdmin($adminAccess)
    {
        return (Constants::DSS_ADMIN_ACCESS_HST_ADMIN === $adminAccess);
    }
    
    public function isBillingAdmin($adminAccess)
    {
        return (Constants::DSS_ADMIN_ACCESS_BILLING_ADMIN === $adminAccess);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function scopeProducer($query)
    {
        return $query->where('producer', '=', 1);
    }
}
