<?php

namespace DentalSleepSolutions\Services\ApiEnrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Repositories\Dental\EnrollmentInvoiceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PercaseInvoiceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\EnrollmentRepository;
use DentalSleepSolutions\Exceptions\InvoiceException;
use DentalSleepSolutions\Wrappers\RequestWrapper;

class InvoiceHelper
{
    /** invoice status */
    const DSS_INVOICE_PENDING = 4;
    const DSS_INVOICE_INVOICED = 0;
    const DSS_INVOICE_PAID = 1;
    const DSS_INVOICE_ERROR = 2;
    const DSS_INVOICE_PAYMENT_ERROR = 3;

    /** invoice type */
    const DSS_INVOICE_TYPE_SU_FO = 1; //Super invoices front office
    const DSS_INVOICE_TYPE_BC_FO = 2; //Billing company invoices front office
    const DSS_INVOICE_TYPE_SU_BC = 3; //Super invoices billing company

    const DOC_ID_COLUMN = 'docid';
    const COMPANY_ID_COLUMN = 'companyid';

    /** @var PercaseInvoiceRepository */
    private $perCaseInvoiceRepository;

    /** @var EnrollmentRepository */
    private $enrollmentRepository;

    /** @var EnrollmentInvoiceRepository */
    private $enrollmentInvoiceRepository;

    /** @var RequestWrapper */
    private $requestWrapper;

    public function __construct(
        PercaseInvoiceRepository $perCaseInvoiceRepository,
        EnrollmentRepository $enrollmentRepository,
        EnrollmentInvoiceRepository $enrollmentInvoiceRepository,
        RequestWrapper $requestWrapper
    ) {
        $this->perCaseInvoiceRepository = $perCaseInvoiceRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->enrollmentInvoiceRepository = $enrollmentInvoiceRepository;
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * add invoice when enrollment is added
     *
     * @param int $userType
     * @param int $userId
     * @param int $enrollmentId
     * @return Enrollment
     * @throws InvoiceException
     * @throws \Exception
     */
    public function addEnrollment($userType, $userId, $enrollmentId)
    {
        // TODO: this function only ever gets called with $userType of 1. do we need the first argument?
        /** @var Enrollment|null $enrollment */
        $enrollment = $this->enrollmentRepository->find($enrollmentId);
        if (!$enrollment) {
            throw new InvoiceException("Enrollment with ID $enrollmentId does not exist");
        }

        $column = $this->getColumn($userType);
        $invoiceId = $this->perCaseInvoiceRepository->getInvoiceIdWithEnrollmentInvoice(
            $column, $userId, self::DSS_INVOICE_PENDING
        );

        if (!$invoiceId) {
            $existingInvoiceId = $this->find($userType, $userId);
            $invoiceId = $this->enrollmentInvoiceRepository->add($existingInvoiceId, $this->getIp());
        }

        $enrollment->enrollment_invoice_id = $invoiceId;
        return $enrollment;
    }

    /**
     * Find existing pending invoice for user
     *
     * @param int $userType
     * @param int $userId
     * @return int
     * @throws \Exception
     */
    private function find($userType, $userId)
    {
        $column = $this->getColumn($userType);
        $invoiceType = $this->getInvoiceType($userType);

        $invoiceId = $this->perCaseInvoiceRepository->getInvoiceId(
            $column, $userId, $invoiceType, self::DSS_INVOICE_PENDING
        );

        if (!$invoiceId) {
            $invoiceId = $this->perCaseInvoiceRepository->add(
                $column,
                $userId,
                $invoiceType,
                self::DSS_INVOICE_PENDING,
                $this->getIp()
            );
        }
        return $invoiceId;
    }

    /**
     * @param int $userType
     * @return string
     * @throws InvoiceException
     */
    private function getColumn($userType)
    {
        // TODO: what do 1 and 2 mean?
        if ($userType == 1) {
            return self::DOC_ID_COLUMN;
        }
        if ($userType == 2) {
            return self::COMPANY_ID_COLUMN;
        }
        throw new InvoiceException('User type must be either 1 or 2');
    }

    /**
     * @param int $userType
     * @return int
     * @throws InvoiceException
     */
    private function getInvoiceType($userType)
    {
        // TODO: what do 1 and 2 mean?
        if ($userType == 1) {
            return self::DSS_INVOICE_TYPE_SU_FO;
        }
        if ($userType == 2) {
            return self::DSS_INVOICE_TYPE_SU_BC;
        }
        throw new InvoiceException('User type must be either 1 or 2');
    }

    /**
     * @return string
     */
    private function getIp()
    {
        $request = $this->requestWrapper->getRequest();
        return $request->server('REMOTE_ADDR');
    }
}
