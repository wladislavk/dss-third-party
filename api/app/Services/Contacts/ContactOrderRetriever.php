<?php

namespace DentalSleepSolutions\Services\Contacts;

class ContactOrderRetriever
{
    /**
     * @param string $sort
     * @return array
     */
    public function getOrderByColumns($sort)
    {
        if (!$sort) {
            return [];
        }
        switch ($sort) {
            case 'company':
                return ['company'];
            case 'type':
                return ['dct.contacttype'];
        }
        return ['dc.lastname', 'firstname'];
    }

    /**
     * @param string $sort
     * @return array
     */
    public function getContactsOrderByColumns($sort)
    {
        switch ($sort) {
            case 'contacttype':
                return ['contacttype'];
            case 'total':
                return ['num_ref'];
            case 'name':
                return ['lastname', 'firstname'];
        }
        return [];
    }

    /**
     * @param string $sort
     * @return array
     */
    public function getCorporateOrderByColumns($sort)
    {
        if (!$sort) {
            return [];
        }
        switch ($sort) {
            case 'company':
                return ['company'];
            case 'type':
                return ['ct.contacttype'];
        }
        return ['lastname', 'firstname'];
    }
}
