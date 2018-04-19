<?php

namespace Tests\Unit\Services\ApiEnrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Eloquent\Repositories\Dental\EnrollmentInvoiceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PercaseInvoiceRepository;
use DentalSleepSolutions\Exceptions\InvoiceException;
use DentalSleepSolutions\Services\ApiEnrollments\InvoiceHelper;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\EnrollmentRepository;
use DentalSleepSolutions\Wrappers\RequestWrapper;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class InvoiceHelperTest extends UnitTestCase
{
    const IP = '127.0.0.1';

    /** @var InvoiceHelper */
    private $invoiceHelper;

    public function setUp()
    {
        $perCaseInvoiceRepository = $this->mockPerCaseInvoiceRepository();
        $enrollmentRepository = $this->mockEnrollmentRepository();
        $enrollmentInvoiceRepository = $this->mockEnrollmentInvoiceRepository();
        $requestWrapper = $this->mockRequestWrapper();
        $this->invoiceHelper = new InvoiceHelper(
            $perCaseInvoiceRepository,
            $enrollmentRepository,
            $enrollmentInvoiceRepository,
            $requestWrapper
        );
    }

    /**
     * @throws InvoiceException
     */
    public function testAddEnrollmentWithUserTypeOfOne()
    {
        $userType = 1;
        $userId = 1;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(1, $enrollment->enrollment_invoice_id);
    }

    /**
     * @throws InvoiceException
     */
    public function testAddEnrollmentWithUserTypeOfTwo()
    {
        $userType = 2;
        $userId = 1;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(2, $enrollment->enrollment_invoice_id);
    }

    /**
     * @throws InvoiceException
     */
    public function testAddEnrollmentWithInvoiceId()
    {
        $userType = 1;
        $userId = 2;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(3, $enrollment->enrollment_invoice_id);
    }

    /**
     * @throws InvoiceException
     */
    public function testAddEnrollmentWithInvoiceIdNotFound()
    {
        $userType = 1;
        $userId = 3;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(4, $enrollment->enrollment_invoice_id);
    }

    /**
     * @throws InvoiceException
     */
    public function testAddEnrollmentWithBadUserType()
    {
        $userType = 3;
        $userId = 1;
        $enrollmentId = 1;
        $this->expectException(InvoiceException::class);
        $this->expectExceptionMessage('User type must be either 1 or 2');
        $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
    }

    /**
     * @throws InvoiceException
     */
    public function testAddEnrollmentWithBadEnrollmentId()
    {
        $userType = 1;
        $userId = 1;
        $enrollmentId = 2;
        $this->expectException(InvoiceException::class);
        $this->expectExceptionMessage('Enrollment with ID 2 does not exist');
        $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
    }

    private function mockPerCaseInvoiceRepository()
    {
        /** @var PercaseInvoiceRepository|MockInterface $perCaseInvoiceRepository */
        $perCaseInvoiceRepository = \Mockery::mock(PercaseInvoiceRepository::class);
        $perCaseInvoiceRepository->shouldReceive('add')
            ->andReturnUsing([$this, 'addPerCaseInvoiceCallback']);
        $perCaseInvoiceRepository->shouldReceive('getInvoiceId')
            ->andReturnUsing([$this, 'getInvoiceIdCallback']);
        $perCaseInvoiceRepository->shouldReceive('getInvoiceIdWithEnrollmentInvoice')
            ->andReturnUsing([$this, 'getInvoiceIdWithEnrollmentInvoiceCallback']);
        return $perCaseInvoiceRepository;
    }

    private function mockEnrollmentRepository()
    {
        /** @var EnrollmentRepository|MockInterface $enrollmentRepository */
        $enrollmentRepository = \Mockery::mock(EnrollmentRepository::class);
        $enrollmentRepository->shouldReceive('find')
            ->andReturnUsing([$this, 'findEnrollmentCallback']);
        return $enrollmentRepository;
    }

    private function mockEnrollmentInvoiceRepository()
    {
        /** @var EnrollmentInvoiceRepository|MockInterface $enrollmentInvoiceRepository */
        $enrollmentInvoiceRepository = \Mockery::mock(EnrollmentInvoiceRepository::class);
        $enrollmentInvoiceRepository->shouldReceive('add')
            ->andReturnUsing([$this, 'addEnrollmentInvoiceCallback']);
        return $enrollmentInvoiceRepository;
    }

    private function mockRequestWrapper()
    {
        /** @var RequestWrapper|MockInterface $requestWrapper */
        $requestWrapper = \Mockery::mock(RequestWrapper::class);
        $requestWrapper->shouldReceive('getRequest')->andReturn($this->mockIlluminateRequest());
        return $requestWrapper;
    }

    private function mockIlluminateRequest()
    {
        /** @var Request|MockInterface $request */
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('server')->andReturn(self::IP);
        return $request;
    }

    public function findEnrollmentCallback($enrollmentId)
    {
        if ($enrollmentId == 1) {
            $enrollment = new Enrollment();
            $enrollment->id = 1;
            return $enrollment;
        }
        return null;
    }

    public function getInvoiceIdCallback($column, $userId, $invoiceType, $status)
    {
        if ($userId == 2) {
            return 3;
        }
        return null;
    }

    public function getInvoiceIdWithEnrollmentInvoiceCallback($column, $userId)
    {
        if ($userId != 1) {
            return 0;
        }
        if ($column == InvoiceHelper::DOC_ID_COLUMN) {
            return 1;
        }
        if ($column == InvoiceHelper::COMPANY_ID_COLUMN) {
            return 2;
        }
        return 0;
    }

    public function addPerCaseInvoiceCallback()
    {
        return 4;
    }

    public function addEnrollmentInvoiceCallback($id)
    {
        return $id;
    }
}
