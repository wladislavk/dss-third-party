<?php

namespace DentalSleepSolutions\Structs\QueryCollections;

use Illuminate\Database\Eloquent\Builder;

class ReportDataQueryCollection extends AbstractQueryCollection
{
    const BASE_QUERY_KEY = 'base';
    const FIRST_LEDGER_PAYMENT_QUERY_KEY = 'first_ledger_payment';
    const SECOND_LEDGER_PAYMENT_QUERY_KEY = 'second_ledger_payment';
    const LEDGER_NOTES_USER_QUERY_KEY = 'ledger_notes_user';
    const LEDGER_NOTES_ADMIN_QUERY_KEY = 'ledger_notes_admin';
    const LEDGER_STATEMENTS_QUERY_KEY = 'ledger_statements';
    const INSURANCE_QUERY_KEY = 'insurance';

    public function setBaseQuery(Builder $query)
    {
        $this->put(self::BASE_QUERY_KEY, $query);
        return $this;
    }

    public function getBaseQuery()
    {
        return $this->get(self::BASE_QUERY_KEY);
    }

    public function setFirstLedgerPaymentQuery(Builder $query)
    {
        $this->put(self::FIRST_LEDGER_PAYMENT_QUERY_KEY, $query);
        return $this;
    }

    public function getFirstLedgerPaymentQuery()
    {
        return $this->get(self::FIRST_LEDGER_PAYMENT_QUERY_KEY);
    }

    public function setSecondLedgerPaymentQuery(Builder $query)
    {
        $this->put(self::SECOND_LEDGER_PAYMENT_QUERY_KEY, $query);
        return $this;
    }

    public function getSecondLedgerPaymentQuery()
    {
        return $this->get(self::SECOND_LEDGER_PAYMENT_QUERY_KEY);
    }

    public function setLedgerNotesUserQuery(Builder $query)
    {
        $this->put(self::LEDGER_NOTES_USER_QUERY_KEY, $query);
        return $this;
    }

    public function getLedgerNotesUserQuery()
    {
        return $this->get(self::LEDGER_NOTES_USER_QUERY_KEY);
    }

    public function setLedgerNotesAdminQuery(Builder $query)
    {
        $this->put(self::LEDGER_NOTES_ADMIN_QUERY_KEY, $query);
        return $this;
    }

    public function getLedgerNotesAdminQuery()
    {
        return $this->get(self::LEDGER_NOTES_ADMIN_QUERY_KEY);
    }

    public function setLedgerStatementsQuery(Builder $query)
    {
        $this->put(self::LEDGER_STATEMENTS_QUERY_KEY, $query);
        return $this;
    }

    public function getLedgerStatementsQuery()
    {
        return $this->get(self::LEDGER_STATEMENTS_QUERY_KEY);
    }

    public function setInsuranceQuery(Builder $query)
    {
        $this->put(self::INSURANCE_QUERY_KEY, $query);
        return $this;
    }

    public function getInsuranceQuery()
    {
        return $this->get(self::INSURANCE_QUERY_KEY);
    }
}
