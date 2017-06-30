<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Exceptions\SwaggerGeneratorException;
use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class AnnotationWriter
{
    /** @var AnnotationModifier */
    private $annotationModifier;

    public function __construct(AnnotationModifier $annotationModifier)
    {
        $this->annotationModifier = $annotationModifier;
    }

    /**
     * @param string $filename
     * @param AnnotationData[] $annotations
     * @throws SwaggerGeneratorException
     */
    public function writeAnnotations($filename, array $annotations)
    {
        $contents = file_get_contents($filename);
        foreach ($annotations as $annotation) {
            $contents = $this->annotationModifier->replaceAnnotation($contents, $annotation);
        }
        $fh = fopen($filename, 'w');
        try {
            fwrite($fh, $contents);
        } catch (\Exception $e) {
            throw new SwaggerGeneratorException("Could not rewrite file $filename: {$e->getMessage()}");
        } finally {
            fclose($fh);
        }
    }
}
