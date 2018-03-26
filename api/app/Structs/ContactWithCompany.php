<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Database\Eloquent\Model;

class ContactWithCompany
{
    public $id;
    public $referralType;
    public $firstName;
    public $middleName;
    public $lastName;
    public $contactType;
    public $company;

    public function __construct(Model $item)
    {
        $this->id = $item->contactid;
        $this->referralType = $item->referral_type;
        $this->firstName = $item->firstname;
        $this->middleName = $item->middlename;
        $this->lastName = $item->lastname;
        $this->company = $item->company;
        $this->contactType = $item->contacttype;
    }
}
