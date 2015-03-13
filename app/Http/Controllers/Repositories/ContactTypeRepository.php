<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\ContactTypeInterface;
use Ds3\Eloquent\Contact\ContactType;

class ContactTypeRepository implements ContactTypeInterface
{
    public function get($contactTypeId)
    {
        try {
            $contactType = ContactType::where('contacttypeid', '=', $contactTypeId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $contactType;
    }

    public function getPhysicians()
    {
        $physicians = ContactType::where('physician', '=', 1)->get();

        return $physicians;
    }

    public function getContactTypes()
    {
        $contactTypes = ContactType::where('status', '=', 1)
            ->where('corporate', '=', 0)
            ->orderBy('sortby')
            ->get();

        return $contactTypes;
    }

    public function getAll()
    {
        return ContactType::all();
    }
}
