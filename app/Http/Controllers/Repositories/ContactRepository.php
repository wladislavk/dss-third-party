<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\ContactInterface;
use Ds3\Eloquent\Contact\Contact;

class ContactRepository implements ContactInterface
{
    public function get($where)
    {
        $contact = new Contact();

        foreach ($where as $attribute => $value) {
            $contact = $contact->where($attribute, '=', $value);
        }

        try {
            $contact = $contact->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $contact;
    }

    public function getInsContact($docId)
    {
        $insContact = Contact::active()
            ->whereNull('merge_id')
            ->where('contacttypeid', '=', 11)
            ->where('docid', '=', $docId)
            ->orderBy('company')
            ->get();

        return $insContact;
    }

    public function getContactTypeHolder($where, $letter = null, $order = null, $limit = null, $offset = null)
    {
        $contacts = DB::table(DB::raw('dental_contact dc'))
            ->select('dc.*')
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->whereNull('merge_id');

        if (!empty($where)) foreach ($where as $attribute => $value) {
            $contacts = $contacts->where($attribute, $value);
        }

        if (isset($letter)) {
            $contacts = $contacts->whereRaw("(dc.lastname LIKE '" . $letter . "%' OR (dc.lastname='' AND dc.company LIKE  '" . $letter . "%'))");
        }

        if (!empty($order)) foreach ($order as $attribute => $method) {
            $contacts = $contacts->orderBy($attribute, $method);
        }

        if (!empty($limit)) {
            $contacts = $contacts->take($limit);
        }

        if (!empty($offset)) {
            $contacts = $contacts->skip($offset);
        }

        return $contacts->get();
    }

    public function searchContacts($names, $partial, $docId)
    {
        $contacts = DB::table(DB::raw('dental_contact c'))
            ->leftJoin(DB::raw('dental_contacttype ct'), 'c.contacttypeid', '=', 'ct.contacttypeid')
            ->where(function($query) use ($names, $partial){
                $query->where(function($query) use ($names, $partial){
                        $query->whereRaw("(lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')")
                            ->whereRaw("(lastname LIKE '" . $names[1] . "%' OR firstname LIKE '" . $names[1] . "%')");
                    })
                    ->orWhereRaw("(firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" . $names[1] . "%' AND lastname LIKE '" . $names[2] . "%')")
                    ->orWhereRaw("(company LIKE '" . $partial . "%')");
            })
            ->whereNull('merge_id')
            ->where('c.status', '=', 1)
            ->where('docid', '=', $docId)
            ->orderBy('lastname');

        return $contacts->get();
    }

    public function updateData($contactId, $values)
    {
        $contact = Contact::where('contactid', '=', $contactId)->update($values);

        return $contact;
    }

    public function insertData($data)
    {
        $contact = new Contact();

        foreach ($data as $attribute => $value) {
            $contact->$attribute = $value;
        }

        try {
            $contact->save();
        } catch (QueryException $e) {
            return null;
        }

        return $contact->contactid;
    }

    public function deleteData($contactId)
    {
        $contact = Contact::where('contactid', '=', $contactId)->delete();

        return $contact;
    }

    public function getNewContacts($docId)
    {
        $contactType = DB::table('dental_contacttype')
            ->leftJoin('dental_contact', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
            ->where('docid', '=', $docId);

        $newContacts = Contact::leftJoin('dental_contacttype', 'dental_contact.contacttypeid', '=', 'dental_contacttype.contacttypeid')
            ->where('docid', '=', $docId)
            ->union($contactType)
            ->get();

        return $newContacts;
    }

    public function getDocsleep($contactId)
    {
        $docsleep = DB::table(DB::raw('dental_contact dc'))
            ->leftJoin(DB::raw('dental_contacttype dct'), 'dct.contacttypeid', '=', 'dc.contacttypeid')
            ->where('contactid', '=', $contactId)
            ->first();

        return $docsleep;
    }

    public function getPatientContacts($patientId)
    {
        $contacts = Contact::select('contactid')
            ->join('dental_patients', 'dental_patients.referred_by', '=', 'dental_contact.contactid')
            ->join(DB::raw('dental_contacttype ct'), 'ct.contacttypeid', '=', 'dental_contact.contacttypeid')
            ->where('dental_patients.patientid', '=', $patientId)
            ->where('ct.physician', '!=', 1)
            ->get();

        return $contacts;
    }
}
