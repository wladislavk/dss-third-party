<?php

namespace Tests\Unit\Services\Users;

use Barryvdh\DomPDF\PDF;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Services\Users\PdfHelper;
use DentalSleepSolutions\Structs\PdfFontData;
use DentalSleepSolutions\Structs\PdfHeaderData;
use DentalSleepSolutions\Structs\PdfMarginData;
use DentalSleepSolutions\Wrappers\FileWrapper;
use Illuminate\Routing\UrlGenerator;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PdfHelperTest extends UnitTestCase
{
    const PUBLIC_PATH = '/public';

    /** @var int */
    private $userType;

    /** @var string */
    private $currentView;

    /** @var array */
    private $currentData = [];

    /** @var string */
    private $currentFilename;

    /** @var PdfHelper */
    private $pdfHelper;

    public function setUp()
    {
        $this->userType = 2;

        $domPdfWrapper = $this->mockDomPdfWrapper();
        $urlGenerator = $this->mockUrlGenerator();
        $fileWrapper = $this->mockFileWrapper();
        $userRepository = $this->mockUserRepository();
        $letterRepository = $this->mockLetterRepository();
        $this->pdfHelper = new PdfHelper(
            $domPdfWrapper, $urlGenerator, $fileWrapper, $userRepository, $letterRepository
        );
    }

    public function testWithoutHeaders()
    {
        $template = 'pdf';
        $content = ['foo' => 'bar'];
        $filename = 'new.pdf';
        $url = $this->pdfHelper->create($template, $content, $filename);
        $this->assertEquals('pdf', $this->currentView);
        $this->assertEquals('/public/letter_pdfs/new.pdf', $this->currentFilename);
        $this->assertEquals('http://letter_pdfs/new.pdf', $url);
        $expected = [
            'header_info' => [
                'title' => PdfHeaderData::DEFAULT_TITLE,
                'subject' => PdfHeaderData::DEFAULT_SUBJECT,
                'keywords' => PdfHeaderData::DEFAULT_KEYWORDS,
                'author' => PdfHeaderData::DEFAULT_AUTHOR,
            ],
            'font' => [
                'family' => PdfFontData::DEFAULT_FAMILY,
                'size' => PdfFontData::DEFAULT_SIZE,
            ],
            'margins' => [
                'top' => PdfMarginData::DEFAULT_TOP,
                'left' => PdfMarginData::DEFAULT_LEFT,
                'right' => PdfMarginData::DEFAULT_RIGHT,
                'bottom' => PdfMarginData::DEFAULT_BOTTOM,
                'header' => PdfMarginData::DEFAULT_HEADER,
                'footer' => PdfMarginData::DEFAULT_FOOTER,
            ],
            'content' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $this->currentData);
    }

    public function testWithHeaders()
    {
        $template = 'pdf';
        $content = ['foo' => 'bar'];
        $filename = 'new.pdf';
        $headers = new PdfHeaderData();
        $headers->title = 'foo';
        $headers->subject = 'bar';
        $headers->keywords = 'baz';
        $url = $this->pdfHelper->create($template, $content, $filename, $headers);
        $this->assertEquals('pdf', $this->currentView);
        $this->assertEquals('/public/letter_pdfs/new.pdf', $this->currentFilename);
        $this->assertEquals('http://letter_pdfs/new.pdf', $url);
        $expected = [
            'header_info' => [
                'title' => 'foo',
                'subject' => 'bar',
                'keywords' => 'baz',
                'author' => PdfHeaderData::DEFAULT_AUTHOR,
            ],
            'font' => [
                'family' => PdfFontData::DEFAULT_FAMILY,
                'size' => PdfFontData::DEFAULT_SIZE,
            ],
            'margins' => [
                'top' => PdfMarginData::DEFAULT_TOP,
                'left' => PdfMarginData::DEFAULT_LEFT,
                'right' => PdfMarginData::DEFAULT_RIGHT,
                'bottom' => PdfMarginData::DEFAULT_BOTTOM,
                'header' => PdfMarginData::DEFAULT_HEADER,
                'footer' => PdfMarginData::DEFAULT_FOOTER,
            ],
            'content' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $this->currentData);
    }

    public function testWithDocId()
    {
        $template = 'pdf';
        $content = ['foo' => 'bar'];
        $filename = 'new.pdf';
        $docId = 1;
        $this->userType = 1;
        $url = $this->pdfHelper->create($template, $content, $filename, null, $docId);
        $this->assertEquals('pdf', $this->currentView);
        $this->assertEquals('/public/letter_pdfs/new.pdf', $this->currentFilename);
        $this->assertEquals('http://letter_pdfs/new.pdf', $url);
        $expected = [
            'header_info' => [
                'title' => PdfHeaderData::DEFAULT_TITLE,
                'subject' => PdfHeaderData::DEFAULT_SUBJECT,
                'keywords' => PdfHeaderData::DEFAULT_KEYWORDS,
                'author' => PdfHeaderData::DEFAULT_AUTHOR,
            ],
            'font' => [
                'family' => PdfFontData::DEFAULT_FAMILY,
                'size' => PdfFontData::DEFAULT_SIZE,
            ],
            'margins' => [
                'top' => PdfMarginData::DEFAULT_TOP,
                'left' => PdfMarginData::DEFAULT_LEFT,
                'right' => PdfMarginData::DEFAULT_RIGHT,
                'bottom' => PdfMarginData::DEFAULT_BOTTOM,
                'header' => PdfMarginData::DEFAULT_HEADER,
                'footer' => PdfMarginData::DEFAULT_FOOTER,
            ],
            'content' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $this->currentData);
    }

    public function testWithDocUserTypeOfTwo()
    {
        $template = 'pdf';
        $content = ['foo' => 'bar'];
        $filename = 'new.pdf';
        $docId = 1;
        $url = $this->pdfHelper->create($template, $content, $filename, null, $docId);
        $this->assertEquals('pdf', $this->currentView);
        $this->assertEquals('/public/letter_pdfs/new.pdf', $this->currentFilename);
        $this->assertEquals('http://letter_pdfs/new.pdf', $url);
        $expected = [
            'header_info' => [
                'title' => PdfHeaderData::DEFAULT_TITLE,
                'subject' => PdfHeaderData::DEFAULT_SUBJECT,
                'keywords' => PdfHeaderData::DEFAULT_KEYWORDS,
                'author' => PdfHeaderData::DEFAULT_AUTHOR,
            ],
            'font' => [
                'family' => PdfFontData::DEFAULT_FAMILY,
                'size' => PdfFontData::DEFAULT_SIZE,
            ],
            'margins' => [
                'top' => 50,
                'left' => 50,
                'right' => 50,
                'bottom' => 50,
                'header' => 50,
                'footer' => 50,
            ],
            'content' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $this->currentData);
    }

    public function testWithLetterId()
    {
        $template = 'pdf';
        $content = ['foo' => 'bar'];
        $filename = 'new.pdf';
        $docId = 1;
        $letterId = 2;
        $url = $this->pdfHelper->create($template, $content, $filename, null, $docId, $letterId);
        $this->assertEquals('pdf', $this->currentView);
        $this->assertEquals('/public/letter_pdfs/new.pdf', $this->currentFilename);
        $this->assertEquals('http://letter_pdfs/new.pdf', $url);
        $expected = [
            'header_info' => [
                'title' => PdfHeaderData::DEFAULT_TITLE,
                'subject' => PdfHeaderData::DEFAULT_SUBJECT,
                'keywords' => PdfHeaderData::DEFAULT_KEYWORDS,
                'author' => PdfHeaderData::DEFAULT_AUTHOR,
            ],
            'font' => [
                'family' => PdfFontData::DEFAULT_FAMILY,
                'size' => PdfFontData::DEFAULT_SIZE,
            ],
            'margins' => [
                'top' => 50,
                'left' => 50,
                'right' => 50,
                'bottom' => 50,
                'header' => 50,
                'footer' => 50,
            ],
            'content' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $this->currentData);
    }

    public function testWithLetter()
    {
        $template = 'pdf';
        $content = ['foo' => 'bar'];
        $filename = 'new.pdf';
        $docId = 1;
        $letterId = 1;
        $url = $this->pdfHelper->create($template, $content, $filename, null, $docId, $letterId);
        $this->assertEquals('pdf', $this->currentView);
        $this->assertEquals('/public/letter_pdfs/new.pdf', $this->currentFilename);
        $this->assertEquals('http://letter_pdfs/new.pdf', $url);
        $expected = [
            'header_info' => [
                'title' => PdfHeaderData::DEFAULT_TITLE,
                'subject' => PdfHeaderData::DEFAULT_SUBJECT,
                'keywords' => PdfHeaderData::DEFAULT_KEYWORDS,
                'author' => PdfHeaderData::DEFAULT_AUTHOR,
            ],
            'font' => [
                'family' => 'Verdana',
                'size' => 20,
            ],
            'margins' => [
                'top' => 50,
                'left' => 50,
                'right' => 50,
                'bottom' => 50,
                'header' => 50,
                'footer' => 50,
            ],
            'content' => ['foo' => 'bar'],
        ];
        $this->assertEquals($expected, $this->currentData);
    }

    private function mockDomPdfWrapper()
    {
        /** @var PDF|MockInterface $domPdfWrapper */
        $domPdfWrapper = \Mockery::mock(PDF::class);
        $domPdfWrapper->shouldReceive('loadView')->andReturnUsing([$this, 'loadViewCallback']);
        $domPdfWrapper->shouldReceive('save')->andReturnUsing([$this, 'savePdfCallback']);
        return $domPdfWrapper;
    }

    private function mockUrlGenerator()
    {
        /** @var UrlGenerator|MockInterface $urlGenerator */
        $urlGenerator = \Mockery::mock(UrlGenerator::class);
        $urlGenerator->shouldReceive('to')->andReturnUsing([$this, 'generateUrlCallback']);
        return $urlGenerator;
    }

    private function mockFileWrapper()
    {
        /** @var FileWrapper|MockInterface $fileWrapper */
        $fileWrapper = \Mockery::mock(FileWrapper::class);
        $fileWrapper->shouldReceive('getPublicPath')->andReturn(self::PUBLIC_PATH);
        return $fileWrapper;
    }

    private function mockUserRepository()
    {
        /** @var UserRepository|MockInterface $userRepository */
        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('find')->andReturnUsing([$this, 'findUserCallback']);
        return $userRepository;
    }

    private function mockLetterRepository()
    {
        /** @var LetterRepository|MockInterface $letterRepository */
        $letterRepository = \Mockery::mock(LetterRepository::class);
        $letterRepository->shouldReceive('find')->andReturnUsing([$this, 'findLetterCallback']);
        return $letterRepository;
    }

    public function loadViewCallback($view, array $data)
    {
        $this->currentView = $view;
        $this->currentData = $data;
    }

    public function savePdfCallback($filename)
    {
        $this->currentFilename = $filename;
    }

    public function generateUrlCallback($filename)
    {
        return 'http://' . $filename;
    }

    public function findUserCallback($id)
    {
        $doctor = new User();
        $doctor->user_type = $this->userType;
        $doctor->letter_margin_top = 50;
        $doctor->letter_margin_bottom = 50;
        $doctor->letter_margin_left = 50;
        $doctor->letter_margin_right = 50;
        $doctor->letter_margin_header = 50;
        $doctor->letter_margin_footer = 50;
        return $doctor;
    }

    public function findLetterCallback($id)
    {
        if ($id == 1) {
            $letter = new Letter();
            $letter->font_family = 'Verdana';
            $letter->font_size = 20;
            return $letter;
        }
        return null;
    }
}
