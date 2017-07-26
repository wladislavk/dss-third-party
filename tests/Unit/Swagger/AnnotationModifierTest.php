<?php

namespace Tests\Unit\Swagger;

use DentalSleepSolutions\Swagger\AnnotationModifier;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use Tests\TestCases\UnitTestCase;

class AnnotationModifierTest extends UnitTestCase
{
    /** @var string */
    private $fileContents = '';

    /** @var AnnotationData */
    private $annotationData;

    /** @var AnnotationModifier */
    private $annotationModifier;

    public function setUp()
    {
        $this->annotationData = new AnnotationData();
        $this->annotationData->operator = 'class MyClass';
        $this->annotationData->text = <<<FILE
@SWG\Property(
    path="/foo",
    @SWG\Schema(ref="#/foo")
)
FILE;
        $this->fileContents = <<<FILE

    class MyClass
    {
FILE;

        $this->annotationModifier = new AnnotationModifier();
    }

    public function testWithExistingDocBlock()
    {
        $this->annotationData->docBlock = <<<FILE
/**
     * @SWG\Property(
     *     path="/bar",
     *     @SWG\Schema(ref="#/bar")
     * )
     *
     * some comment here
     */
FILE;
        $this->fileContents = <<<FILE

    {$this->annotationData->docBlock}
    class MyClass
    {
FILE;
        $modified = $this->annotationModifier->replaceAnnotation($this->fileContents, $this->annotationData);
        $expected = <<<FILE

    /**
     * @SWG\Property(
     *     path="/foo",
     *     @SWG\Schema(ref="#/foo")
     * )
     *
     * some comment here
     */
    class MyClass
    {
FILE;
        $this->assertEquals($expected, $modified);
    }

    public function testWithNewDocBlock()
    {
        $modified = $this->annotationModifier->replaceAnnotation($this->fileContents, $this->annotationData);
        $expected = <<<FILE

    /**
     * @SWG\Property(
     *     path="/foo",
     *     @SWG\Schema(ref="#/foo")
     * )
     */
    class MyClass
    {
FILE;
        $this->assertEquals($expected, $modified);
    }

    public function testWithoutIndentation()
    {
        $this->fileContents = <<<FILE

class MyClass
{
FILE;
        $modified = $this->annotationModifier->replaceAnnotation($this->fileContents, $this->annotationData);
        $expected = <<<FILE

/**
 * @SWG\Property(
 *     path="/foo",
 *     @SWG\Schema(ref="#/foo")
 * )
 */
class MyClass
{
FILE;
        $this->assertEquals($expected, $modified);
    }

    public function testWithoutOperator()
    {
        $this->fileContents = 'foo';
        $modified = $this->annotationModifier->replaceAnnotation($this->fileContents, $this->annotationData);
        $this->assertEquals('foo', $modified);
    }

    public function testWithManualAnnotation()
    {
        $this->annotationData->docBlock = <<<FILE
    /**
     * @DSS\Manual(foo)
     */
FILE;
        $this->fileContents = <<<FILE
{$this->annotationData->docBlock}
    class MyClass
    {
FILE;
        $modified = $this->annotationModifier->replaceAnnotation($this->fileContents, $this->annotationData);
        $this->assertEquals($this->fileContents, $modified);
    }
}
