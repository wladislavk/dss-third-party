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
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
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
            Generator::MODEL_DIR . '/FirstModel.php',
            Generator::MODEL_DIR . '/SecondModel.php',
            Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/FirstController.php',
            Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/SecondController.php',
        ];
        $this->assertEquals($expectedFilenames, $this->filenames);
        /** @var AnnotationData[] $firstModelAnnotations */
        $firstModelAnnotations = $this->annotations[0];
        $this->assertEquals(1, sizeof($firstModelAnnotations));
        $firstModelAnnotation = $firstModelAnnotations[0];
        $this->assertEquals('First model annotation', $firstModelAnnotation->text);
        $this->assertEquals('Tests\\Models\\FirstModel', $firstModelAnnotation->params->modelClassName);
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
            'Tests\\Http\\Controllers\\FirstController',
            $firstControllerIndexAnnotation->params->controllerClassName
        );
        $this->assertEquals('Tests\\Models\\FirstModel', $firstControllerIndexAnnotation->params->modelClassName);
        $this->assertEquals(
            'Tests\\Http\\Requests\\FirstRequest',
            $firstControllerIndexAnnotation->params->requestClassName
        );
        $firstControllerShowAnnotation = $firstControllerAnnotations[1];
        $this->assertEquals('First show annotation', $firstControllerShowAnnotation->text);
        $this->assertEquals(
            'Tests\\Http\\Controllers\\FirstController',
            $firstControllerShowAnnotation->params->controllerClassName
        );
        $this->assertEquals('Tests\\Models\\FirstModel', $firstControllerShowAnnotation->params->modelClassName);
        $this->assertEquals(
            'Tests\\Http\\Requests\\FirstRequest',
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

    public function testWithNamespaceAbsentFromFile()
    {
        $this->namespacePresent = false;
        $this->expectException(SwaggerGeneratorException::class);
        $filename = Generator::MODEL_DIR . '/FirstModel.php';
        $this->expectExceptionMessage('Namespace or class not found in ' . $filename);
        $this->generator->generateSwagger();
    }

    public function testWithClassNameAbsentFromFile()
    {
        $this->classNamePresent = false;
        $this->expectException(SwaggerGeneratorException::class);
        $filename = Generator::MODEL_DIR . '/FirstModel.php';
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
            case 'FirstController':
                $firstAnnotation->text = 'First index annotation';
                $secondAnnotation->text = 'First show annotation';
                break;
            case 'SecondController':
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
            case 'FirstModel':
                $annotation->text = 'First model annotation';
                break;
            case 'SecondModel':
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
        $modelName = 'Tests\\Models\\' . $shortName;
        $modelName = str_replace('Controller', 'Model', $modelName);
        return $modelName;
    }

    public function getRequestClassCallback($controllerClassName, $httpDir)
    {
        $splitName = explode('\\', $controllerClassName);
        $shortName = $splitName[count($splitName) - 1];
        $requestName = 'Tests\\Http\\Requests\\' . $shortName;
        $requestName = str_replace('Controller', 'Request', $requestName);
        return $requestName;
    }

    public function allFilesCallback($dirName)
    {
        if (strstr($dirName, 'Controllers')) {
            return [
                Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/FirstController.php',
                Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/SecondController.php',
                Generator::HTTP_DIR . Generator::CONTROLLER_DIR . '/ThirdController.php',
            ];
        }
        if (strstr($dirName, 'Eloquent')) {
            return [
                Generator::MODEL_DIR . '/FirstModel.php',
                Generator::MODEL_DIR . '/SecondModel.php',
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
            $namespace = 'Tests\\Http\\Controllers';
            if ($className != 'ThirdController') {
                $extends = Generator::BASE_CONTROLLER;
            }
        }
        if (strstr($className, 'Model')) {
            $namespace = 'Tests\\Models';
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
