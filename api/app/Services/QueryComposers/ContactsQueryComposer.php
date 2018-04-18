<?php

namespace DentalSleepSolutions\Services\QueryComposers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use Illuminate\Database\Eloquent\Collection;

class ContactsQueryComposer
{
    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param int $contactType
     * @param int $status
     * @param int $docId
     * @param string $letter
     * @param string $sortDir
     * @param array $orderByColumns
     * @return Collection|array
     */
    public function composeFindContactQuery(
        $contactType,
        $status,
        $docId,
        $letter,
        $sortDir,
        array $orderByColumns
    ) {
        $query = $this->contactRepository->getFindContactBaseQuery($docId, $status);
        if ($contactType) {
            $query = $this->contactRepository->getContactQueryWhereContactTypeId($query, $contactType);
        }
        if ($letter) {
            $query = $this->contactRepository
                ->getContactQueryWhereLastNameOrCompanyLikeLetter($query, $letter);
        }

        $order = $this->setOrderColumns($orderByColumns);
        $query = $this->contactRepository
            ->getContactQueryOrderByColumnOrNull($query, $order[0], $sortDir);
        foreach ($order as $column) {
            $direction = 'asc';
            if (in_array($column, $orderByColumns)) {
                $direction = $sortDir;
            }
            $query = $this->contactRepository
                ->getContactQueryOrderByColumnAndDirection($query, $column, $direction);
        }

        return $query->get();
    }

    /**
     * @param array $orderByColumns
     * @return array
     */
    private function setOrderColumns(array $orderByColumns)
    {
        $order = [
            'dc.lastname',
            'firstname',
            'company',
            'dct.contacttype',
        ];
        foreach ($order as $key => $column) {
            if (in_array($column, $orderByColumns)) {
                unset($order[$key]);
            }
        }
        $order = array_values($order);
        array_splice($order, 0, 0, $orderByColumns);
        return $order;
    }

    /**
     * @param int $docId
     * @param string $partial
     * @param bool $withoutCompanies
     * @return Collection|array
     */
    public function composeListContactsAndCompaniesQuery(
        $docId,
        $partial,
        $withoutCompanies
    ) {
        $query = $this->contactRepository->getListContactsAndCompaniesBaseQuery($docId);
        if ($withoutCompanies) {
            return $this->contactRepository
                ->getContactQueryWithConditionsForNamesOnly($query, $partial)->get();
        }
        return $this->contactRepository
            ->getContactQueryWithConditionsForNamesAndCompanies($query, $partial)->get();
    }
}
