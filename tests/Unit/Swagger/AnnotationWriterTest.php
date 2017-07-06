<?php

namespace Tests\Unit\Swagger;

use DentalSleepSolutions\Swagger\AnnotationModifier;
use DentalSleepSolutions\Swagger\AnnotationWriter;
use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class AnnotationWriterTest extends UnitTestCase
{
    /** @var bool */
    private $shouldThrowException = false;

    /** @var bool */
    private $fileOpened = false;

    /** @var string */
    private $writtenContents = '';

    /** @var AnnotationData[] */
    private $annotations = [];

    /** @var AnnotationWriter */
    private $annotationWriter;

    public function setUp()
    {
        $firstAnnotation = new AnnotationData();
        $firstAnnotation->action = 'firstAction';
        $firstAnnotation->text = 'First text';
        $secondAnnotation = new AnnotationData();
        $secondAnnotation->action = 'secondAction';
        $secondAnnotation->text = 'Second text';
        $this->annotations = [$firstAnnotation, $secondAnnotation];

        $annotationModifier = $this->mockAnnotationModifier();
        $filesystemWrapper = $this->mockFilesystemWrapper();
        $this->annotationWriter = new AnnotationWriter($annotationModifier, $filesystemWrapper);
    }

    public function testWithoutException()
    {
        $filename = 'my_file.php';
        $this->annotationWriter->writeAnnotations($filename, $this->annotations);
        $this->assertFalse($this->fileOpened);
        $expected = 'my_file.php: 1) First text, 2) Second text';
        $this->assertEquals($expected, $this->writtenContents);
    }

    public function testWithException()
    {
        $this->shouldThrowException = true;
        $filename = 'my_file.php';
        $this->expectException(SwaggerGeneratorException::class);
        $this->expectExceptionMessage("Could not rewrite file my_file.php: Foo");
        $this->annotationWriter->writeAnnotations($filename, $this->annotations);
        $this->assertFalse($this->fileOpened);
    }

    private function mockAnnotationModifier()
    {
        /** @var AnnotationModifier|MockInterface $annotationModifier */
        $annotationModifier = \Mockery::mock(AnnotationModifier::class);
        $annotationModifier->shouldReceive('replaceAnnotation')
            ->andReturnUsing([$this, 'replaceAnnotationCallback']);
        return $annotationModifier;
    }

    private function mockFilesystemWrapper()
    {
        /** @var FilesystemWrapper|MockInterface $filesystemWrapper */
        $filesystemWrapper = \Mockery::mock(FilesystemWrapper::class);
        $filesystemWrapper->shouldReceive('fileGetContents')
            ->andReturnUsing([$this, 'fileGetContentsCallback']);
        $filesystemWrapper->shouldReceive('fOpen')->andReturnUsing([$this, 'fOpenCallback']);
        $filesystemWrapper->shouldReceive('fWrite')->andReturnUsing([$this, 'fWriteCallback']);
        $filesystemWrapper->shouldReceive('fClose')->andReturnUsing([$this, 'fCloseCallback']);
        return $filesystemWrapper;
    }

    public function replaceAnnotationCallback($contents, AnnotationData $annotationData)
    {
        return str_replace($annotationData->action, $annotationData->text, $contents);
    }

    public function fileGetContentsCallback($filename)
    {
        return "$filename: 1) firstAction, 2) secondAction";
    }

    public function fOpenCallback()
    {
        $this->fileOpened = true;
    }

    public function fWriteCallback($contents)
    {
        if ($this->shouldThrowException) {
            throw new \Exception('Foo');
        }
        $this->writtenContents = $contents;
    }

    public function fCloseCallback()
    {
        $this->fileOpened = false;
    }
}
