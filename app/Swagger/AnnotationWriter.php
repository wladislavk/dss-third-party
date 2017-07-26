<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;
use DentalSleepSolutions\Swagger\Wrappers\FilesystemWrapper;

class AnnotationWriter
{
    /** @var AnnotationModifier */
    private $annotationModifier;

    /** @var FilesystemWrapper */
    private $filesystemWrapper;

    public function __construct(
        AnnotationModifier $annotationModifier,
        FilesystemWrapper $filesystemWrapper
    ) {
        $this->annotationModifier = $annotationModifier;
        $this->filesystemWrapper = $filesystemWrapper;
    }

    /**
     * @param string $filename
     * @param AnnotationData[] $annotations
     * @throws SwaggerGeneratorException
     */
    public function writeAnnotations($filename, array $annotations)
    {
        $contents = $this->filesystemWrapper->fileGetContents($filename);
        foreach ($annotations as $annotation) {
            $contents = $this->annotationModifier->replaceAnnotation($contents, $annotation);
        }
        $this->filesystemWrapper->fOpen($filename, 'w');
        try {
            $this->filesystemWrapper->fWrite($contents);
        } catch (\Exception $e) {
            throw new SwaggerGeneratorException("Could not rewrite file $filename: {$e->getMessage()}");
        } finally {
            $this->filesystemWrapper->fClose();
        }
    }
}
