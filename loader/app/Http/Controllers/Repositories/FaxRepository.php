<?php
namespace Ds3\Repositories;

use Ds3\Contracts\FaxInterface;
use Ds3\Eloquent\Fax;

class FaxRepository implements FaxInterface
{
    public function getFaxAlerts($docId)
    {
        $faxAlerts = Fax::where('docid', '=', $docId)
            ->nonViewed()
            ->withError()
            ->get();

        return $faxAlerts;
    }

    public function updateData($where, $values)
    {
        $fax = new Fax();

        foreach ($where as $attribute => $value) {
            $fax = $fax->where($attribute, '=', $value);
        }

        $fax = $fax->update($values);

        return $fax;
    }
}
