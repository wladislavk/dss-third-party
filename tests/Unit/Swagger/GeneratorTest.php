<?php

namespace Tests\Unit\Swagger;

use DentalSleepSolutions\Swagger\AnnotationComposers\ControllerComposer;
use DentalSleepSolutions\Swagger\AnnotationComposers\ModelComposer;
use DentalSleepSolutions\Swagger\AnnotationWriter;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;
use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Generator;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Structs\AnnotationParams;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;
use Mockery\MockInterface;
use Tests\Dummies\Http\Controllers\FirstDummiesController;
use Tests\TestCases\UnitTestCase;

class GeneratorTest extends UnitTestCase
{
    /** @var bool */
    private $namespacePresent = true;

    /** @var bool */
    private $classNamePresent = true;

    /** @var array */
    private $filenames = [];

    /** @var array */
    private $annotations = [];

    /** @var Generator */
    private $generator;

    public function setUp()
    {
        $annotationWriter = $this->mockAnnotationWriter();
        $controllerComposer = $this->mockControllerComposer();
        $modelComposer = $this->mockModelComposer();
        $classRetriever = $this->mockClassRetriever();
        $filesystemWrapper = $this->mockFilesystemWrapper();
        $this->generator = new Generator(
            $annotationWriter,
            $controllerComposer,
            $modelComposer,
            $classRetriever,
            $filesystemWrapper
        );
    }

    public function testGenerate()
    {
        $this->generator->generateSwagger();
        $expectedFilenames = [
            Generator::MODEL_DIR . '/FirstDummy.php',
            Generator::MODEL_DIR . '/SecondDummy.php',
            Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/FirstDummiesController.php',
            Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/SecondDummiesController.php',
        ];
        $this->assertEquals($expectedFilenames, $this->filenames);
        /** @var AnnotationData[] $firstModelAnnotations */
        $firstModelAnnotations = $this->annotations[0];
        $this->assertEquals(1, sizeof($firstModelAnnotations));
        $firstModelAnnotation = $firstModelAnnotations[0];
        $this->assertEquals('First model annotation', $firstModelAnnotation->text);
        $this->assertEquals('Tests\\Dummies\\Eloquent\\FirstDummy', $firstModelAnnotation->params->modelClassName);
        /** @var AnnotationData[] $secondModelAnnotations */
        $secondModelAnnotations = $this->annotations[1];
        $this->assertEquals(1, sizeof($secondModelAnnotations));
        $secondModelAnnotation = $secondModelAnnotations[0];
        $this->assertEquals('Second model annotation', $secondModelAnnotation->text);
        /** @var AnnotationData[] $firstControllerAnnotations */
        $firstControllerAnnotations = $this->annotations[2];
        $this->assertEquals(2, sizeof($firstControllerAnnotations));
        $firstControllerIndexAnnotation = $firstControllerAnnotations[0];
        $this->assertEquals('First index annotation', $firstControllerIndexAnnotation->text);
        $this->assertEquals(
            FirstDummiesController::class,
            $firstControllerIndexAnnotation->params->controllerClassName
        );
        $this->assertEquals('Tests\\Dummies\\Eloquent\\FirstDummiesModel', $firstControllerIndexAnnotation->params->modelClassName);
        $this->assertEquals(
            'Tests\\Dummies\\Http\\Requests\\FirstDummiesRequest',
            $firstControllerIndexAnnotation->params->requestClassName
        );
        $firstControllerShowAnnotation = $firstControllerAnnotations[1];
        $this->assertEquals('First show annotation', $firstControllerShowAnnotation->text);
        $this->assertEquals(
            FirstDummiesController::class,
            $firstControllerShowAnnotation->params->controllerClassName
        );
        $this->assertEquals('Tests\\Dummies\\Eloquent\\FirstDummiesModel', $firstControllerShowAnnotation->params->modelClassName);
        $this->assertEquals(
            'Tests\\Dummies\\Http\\Requests\\FirstDummiesRequest',
            $firstControllerShowAnnotation->params->requestClassName
        );
        /** @var AnnotationData[] $secondControllerAnnotations */
        $secondControllerAnnotations = $this->annotations[3];
        $this->assertEquals(2, sizeof($secondControllerAnnotations));
        $secondControllerIndexAnnotation = $secondControllerAnnotations[0];
        $this->assertEquals('Second index annotation', $secondControllerIndexAnnotation->text);
        $secondControllerShowAnnotation = $secondControllerAnnotations[1];
        $this->assertEquals('Second show annotation', $secondControllerShowAnnotation->text);
    }

    public function testWithClassNameAbsentFromFile()
    {
        $this->classNamePresent = false;
        $this->expectException(SwaggerGeneratorException::class);
        $filename = Generator::MODEL_DIR . '/FirstDummy.php';
        $this->expectExceptionMessage('Namespace or class not found in ' . $filename);
        $this->generator->generateSwagger();
    }

    private function mockAnnotationWriter()
    {
        /** @var AnnotationWriter|MockInterface $annotationWriter */
        $annotationWriter = \Mockery::mock(AnnotationWriter::class);
        $annotationWriter->shouldReceive('writeAnnotations')
            ->andReturnUsing([$this, 'writeAnnotationsCallback']);
        return $annotationWriter;
    }

    private function mockControllerComposer()
    {
        /** @var ControllerComposer|MockInterface $controllerComposer */
        $controllerComposer = \Mockery::mock(ControllerComposer::class);
        $controllerComposer->shouldReceive('composeAnnotation')
            ->andReturnUsing([$this, 'composeControllerAnnotationCallback']);
        return $controllerComposer;
    }

    private function mockModelComposer()
    {
        /** @var ModelComposer|MockInterface $modelComposer */
        $modelComposer = \Mockery::mock(ModelComposer::class);
        $modelComposer->shouldReceive('composeAnnotation')
            ->andReturnUsing([$this, 'composeModelAnnotationCallback']);
        return $modelComposer;
    }

    private function mockClassRetriever()
    {
        /** @var ClassRetrieverInterface|MockInterface $classRetriever */
        $classRetriever = \Mockery::mock(ClassRetrieverInterface::class);
        $classRetriever->shouldReceive('getModelClass')
            ->andReturnUsing([$this, 'getModelClassCallback']);
        $classRetriever->shouldReceive('getRequestClass')
            ->andReturnUsing([$this, 'getRequestClassCallback']);
        return $classRetriever;
    }

    private function mockFilesystemWrapper()
    {
        /** @var FilesystemWrapper|MockInterface $filesystemWrapper */
        $filesystemWrapper = \Mockery::mock(FilesystemWrapper::class);
        $filesystemWrapper->shouldReceive('allFiles')
            ->andReturnUsing([$this, 'allFilesCallback']);
        $filesystemWrapper->shouldReceive('fileGetContents')
            ->andReturnUsing([$this, 'fileGetContentsCallback']);
        return $filesystemWrapper;
    }

    public function writeAnnotationsCallback($filename, array $annotations)
    {
        $this->filenames[] = $filename;
        $this->annotations[] = $annotations;
    }

    public function composeControllerAnnotationCallback(AnnotationParams $annotationParams)
    {
        $splitClassName = explode('\\', $annotationParams->controllerClassName);
        $shortClassName = $splitClassName[count($splitClassName) - 1];
        $firstAnnotation = new AnnotationData();
        $firstAnnotation->params = $annotationParams;
        $secondAnnotation = new AnnotationData();
        $secondAnnotation->params = $annotationParams;
        switch ($shortClassName) {
            case 'FirstDummiesController':
                $firstAnnotation->text = 'First index annotation';
                $secondAnnotation->text = 'First show annotation';
                break;
            case 'SecondDummiesController':
                $firstAnnotation->text = 'Second index annotation';
                $secondAnnotation->text = 'Second show annotation';
                break;
        }
        $annotations[0] = $firstAnnotation;
        $annotations[1] = $secondAnnotation;
        return $annotations;
    }

    public function composeModelAnnotationCallback(AnnotationParams $annotationParams)
    {
        $annotation = new AnnotationData();
        $annotation->params = $annotationParams;
        $splitClassName = explode('\\', $annotationParams->modelClassName);
        $shortClassName = $splitClassName[count($splitClassName) - 1];
        switch ($shortClassName) {
            case 'FirstDummy':
                $annotation->text = 'First model annotation';
                break;
            case 'SecondDummy':
                $annotation->text = 'Second model annotation';
                break;
        }
        $annotations[0] = $annotation;
        return $annotations;
    }

    public function getModelClassCallback($controllerClassName)
    {
        $splitName = explode('\\', $controllerClassName);
        $shortName = $splitName[count($splitName) - 1];
        $modelName = 'Tests\\Dummies\\Eloquent\\' . $shortName;
        $modelName = str_replace('Controller', 'Model', $modelName);
        return $modelName;
    }

    public function getRequestClassCallback($controllerClassName, $httpDir)
    {
        $splitName = explode('\\', $controllerClassName);
        $shortName = $splitName[count($splitName) - 1];
        $requestName = 'Tests\\Dummies\\Http\\Requests\\' . $shortName;
        $requestName = str_replace('Controller', 'Request', $requestName);
        return $requestName;
    }

    public function allFilesCallback($dirName)
    {
        if (strstr($dirName, 'Controllers')) {
            return [
                Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/FirstDummiesController.php',
                Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/SecondDummiesController.php',
                Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/ThirdDummiesController.php',
            ];
        }
        if (strstr($dirName, 'Eloquent')) {
            return [
                Generator::MODEL_DIR . '/FirstDummy.php',
                Generator::MODEL_DIR . '/SecondDummy.php',
                Generator::MODEL_DIR . '/AbstractThirdDummy.php',
            ];
        }
        return [];
    }

    public function fileGetContentsCallback($filename)
    {
        $splitPath = explode('/', $filename);
        $lastElement = $splitPath[count($splitPath) - 1];
        $className = str_replace('.php', '', $lastElement);
        $namespace = '';
        $extends = 'Foo';
        if (strstr($className, 'Controller')) {
            $namespace = 'Tests\\Dummies\\Http\\Controllers';
            if ($className != 'ThirdDummiesController') {
                $extends = Generator::BASE_CONTROLLER;
            }
        }
        if (strstr($className, 'Dummy')) {
            $namespace = 'Tests\\Dummies\\Eloquent';
        }
        $contents = "<?php\n";
        if ($this->namespacePresent) {
            $contents .= "namespace $namespace;\n\n";
        }
        if ($this->classNamePresent) {
            $contents .= <<<FILE
class $className extends $extends
{

FILE;
        }
        return $contents;
    }
}
