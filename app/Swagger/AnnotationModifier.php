<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class AnnotationModifier
{
    const MANUAL_ANNOTATION = '@DSS\\\\Manual';

    /**
     * @param string $fileContents
     * @param AnnotationData $annotation
     * @return string
     */
    public function replaceAnnotation($fileContents, AnnotationData $annotation)
    {
        if (!strstr($fileContents, $annotation->operator)) {
            return $fileContents;
        }
        $existingDocBlock = $this->getExistingDocBlock($fileContents, $annotation->operator);
        $hasManual = strstr($existingDocBlock, self::MANUAL_ANNOTATION);
        if ($hasManual) {
            return $fileContents;
        }
        $indentation = $this->getIndentation($fileContents, $annotation);
        $textByLines = explode("\n", $annotation->text);
        $padding = str_pad('', $indentation);
        if (!$existingDocBlock) {
            $newDocBlock = $this->insertNewDocBlock($textByLines, $padding);
            $fileContents = str_replace(
                "\n$padding{$annotation->operator}",
                "\n$newDocBlock$padding{$annotation->operator}",
                $fileContents
            );
            return $fileContents;
        }
        $swaggerAnnotationsRegexp = '/\s+?\*\s@SWG\\\\[A-Za-z]+?\(.*?\)/m';
        $newDocBlock = preg_replace($swaggerAnnotationsRegexp, '', $existingDocBlock);
        $annotationReplacementRegexp = '/(\/\*\*\n)/';
        $replacement = $this->getReplacementAnnotation($textByLines, $padding);
        $newDocBlock = preg_replace($annotationReplacementRegexp, $replacement, $newDocBlock);
        $fileContents = str_replace($existingDocBlock, $newDocBlock, $fileContents);
        return $fileContents;
    }

    /**
     * @param string $fileContents
     * @param string $operator
     * @return string
     */
    private function getExistingDocBlock($fileContents, $operator)
    {
        $existingDocBlockRegexp = "/\/\*\*(.*?)\*\/\s+?$operator/m";
        preg_match($existingDocBlockRegexp, $fileContents, $docBlockMatches);
        if (isset($docBlockMatches[1])) {
            return $docBlockMatches[1];
        }
        return '';
    }

    /**
     * @param string $fileContents
     * @param AnnotationData $annotation
     * @return int
     */
    private function getIndentation($fileContents, AnnotationData $annotation)
    {
        $indentationRegexp = "/^(\s*?){$annotation->operator}/";
        preg_match($indentationRegexp, $fileContents, $indentationMatches);
        if (isset($indentationMatches[1])) {
            return strlen($indentationMatches[1]);
        }
        return 0;
    }

    /**
     * @param array $textByLines
     * @param string $padding
     * @return string
     */
    private function insertNewDocBlock(array $textByLines, $padding)
    {
        $newDocBlock = <<<ANNOTATION
$padding/**
ANNOTATION;
        foreach ($textByLines as $line) {
            $newDocBlock .= <<<ANNOTATION
$padding * $line
ANNOTATION;
        }
        $newDocBlock .= <<<ANNOTATION
$padding */
ANNOTATION;
        return $newDocBlock;
    }

    /**
     * @param array $textByLines
     * @param string $padding
     * @return string
     */
    private function getReplacementAnnotation(array $textByLines, $padding)
    {
        $replacement = '';
        foreach ($textByLines as $line) {
            $replacement .= <<<ANNOTATION
$padding * $line
ANNOTATION;
        }
        $replacement .= <<<ANNOTATION
$padding *
ANNOTATION;
        return $replacement;
    }
}
