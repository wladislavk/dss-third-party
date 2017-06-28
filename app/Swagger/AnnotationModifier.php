<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class AnnotationModifier
{
    public function replaceAnnotation($contents, AnnotationData $annotation)
    {
        $existingDocBlockRegexp = '//';
        preg_match($existingDocBlockRegexp, $contents, $docBlockMatches);
        $existingDocBlock = '';
        if (isset($docBlockMatches[1])) {
            $existingDocBlock = $docBlockMatches[1];
        }
        $findManualRegexp = '//';
        $hasManual = preg_match($findManualRegexp, $existingDocBlock);
        if ($hasManual) {
            return $contents;
        }
        $annotationReplacementRegexp = '//';
        $newDocBlock = preg_replace($annotationReplacementRegexp, $annotation->text, $existingDocBlock);
        $contents = str_replace($existingDocBlock, $newDocBlock, $contents);
        return $contents;
    }
}
