<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\EnrollmentInvoice;
use DentalSleepSolutions\Eloquent\Models\Dental\PercaseInvoice;
use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use DentalSleepSolutions\Exceptions\InvoiceException;
use DentalSleepSolutions\Helpers\InvoiceHelper;
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
        $perCaseInvoiceModel = $this->mockPerCaseInvoiceModel();
        $enrollmentModel = $this->mockEnrollmentModel();
        $enrollmentInvoiceModel = $this->mockEnrollmentInvoiceModel();
        $requestWrapper = $this->mockRequestWrapper();
        $this->invoiceHelper = new InvoiceHelper(
            $perCaseInvoiceModel, $enrollmentModel, $enrollmentInvoiceModel, $requestWrapper
        );
    }

    public function testAddEnrollmentWithUserTypeOfOne()
    {
        $userType = 1;
        $userId = 1;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(1, $enrollment->enrollment_invoice_id);
    }

    public function testAddEnrollmentWithUserTypeOfTwo()
    {
        $userType = 2;
        $userId = 1;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(2, $enrollment->enrollment_invoice_id);
    }

    public function testAddEnrollmentWithInvoiceId()
    {
        $userType = 1;
        $userId = 2;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(3, $enrollment->enrollment_invoice_id);
    }

    public function testAddEnrollmentWithInvoiceIdNotFound()
    {
        $userType = 1;
        $userId = 3;
        $enrollmentId = 1;
        $enrollment = $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
        $this->assertEquals(1, $enrollment->id);
        $this->assertEquals(4, $enrollment->enrollment_invoice_id);
    }

    public function testAddEnrollmentWithBadUserType()
    {
        $userType = 3;
        $userId = 1;
        $enrollmentId = 1;
        $this->expectException(InvoiceException::class);
        $this->expectExceptionMessage('User type must be either 1 or 2');
        $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
    }

    public function testAddEnrollmentWithBadEnrollmentId()
    {
        $userType = 1;
        $userId = 1;
        $enrollmentId = 2;
        $this->expectException(InvoiceException::class);
        $this->expectExceptionMessage('Enrollment with ID 2 does not exist');
        $this->invoiceHelper->addEnrollment($userType, $userId, $enrollmentId);
    }

    private function mockPerCaseInvoiceModel()
    {
        /** @var PercaseInvoice|MockInterface $perCaseInvoiceModel */
        $perCaseInvoiceModel = \Mockery::mock(PercaseInvoice::class);
        $perCaseInvoiceModel->shouldReceive('add')
            ->andReturnUsing([$this, 'addPerCaseInvoiceCallback']);
        $perCaseInvoiceModel->shouldReceive('getInvoiceId')
            ->andReturnUsing([$this, 'getInvoiceIdCallback']);
        $perCaseInvoiceModel->shouldReceive('getInvoiceIdWithEnrollmentInvoice')
            ->andReturnUsing([$this, 'getInvoiceIdWithEnrollmentInvoiceCallback']);
        return $perCaseInvoiceModel;
    }

    private function mockEnrollmentModel()
    {
        /** @var Enrollment|MockInterface $enrollmentModel */
        $enrollmentModel = \Mockery::mock(Enrollment::class);
        $enrollmentModel->shouldReceive('find')
            ->andReturnUsing([$this, 'findEnrollmentCallback']);
        return $enrollmentModel;
    }

    private function mockEnrollmentInvoiceModel()
    {
        /** @var EnrollmentInvoice|MockInterface $enrollmentInvoiceModel */
        $enrollmentInvoiceModel = \Mockery::mock(EnrollmentInvoice::class);
        $enrollmentInvoiceModel->shouldReceive('add')
            ->andReturnUsing([$this, 'addEnrollmentInvoiceCallback']);
        return $enrollmentInvoiceModel;
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

    public function addEnrollmentInvoiceCallback($id, $ip)
    {
        return $id;
    }
}
