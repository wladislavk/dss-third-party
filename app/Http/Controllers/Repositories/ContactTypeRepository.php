<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\ContactTypeInterface;
use Ds3\Eloquent\Contact\ContactType;

class ContactTypeRepository implements ContactTypeInterface
{
    public function find($contactTypeId)
    {
        $contactType = ContactType::where('contacttypeid', '=', $contactTypeId)->first();

        return $contactType;
    }

    public function getPhysicians()
    {
        $physicians = ContactType::physician()->get();

        return $physicians;
    }

    public function getContactTypes()
    {
        $contactTypes = ContactType::active()
            ->nonCorporate()
            ->orderBy('sortby')
            ->get();

        return $contactTypes;
    }

    public function getAll()
    {
        return ContactType::all();
    }
}
