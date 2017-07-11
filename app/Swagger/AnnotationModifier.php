<?php

namespace DentalSleepSolutions\Swagger;

use DentalSleepSolutions\Swagger\Structs\AnnotationData;

class AnnotationModifier
{
    const MANUAL_ANNOTATION = '@DSS\\Manual';

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
        $existingDocBlock = $this->getExistingDocBlock($annotation);
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
        $swaggerAnnotationsRegexp = $this->formSwaggerAnnotationsRegexp();
        $newDocBlock = preg_replace($swaggerAnnotationsRegexp, '', $existingDocBlock);
        $replacement = $this->getReplacementAnnotation($textByLines, $padding);
        $newDocBlock = $replacement . $newDocBlock;
        $fileContents = str_replace($existingDocBlock, $newDocBlock, $fileContents);
        $fileContents = str_replace('**/', '*/', $fileContents);
        return $fileContents;
    }

    /**
     * Will match the following string:
     *     * @SWG\Foo(something goes here)
     *     either end of doc block or empty doc block line
     *
     * @return string
     */
    private function formSwaggerAnnotationsRegexp()
    {
        return '/\s+?\*\s@SWG\\\\[A-Za-z]+?\(.*?\)\n\s+?(?:$|\*\s*?(?=\n))/sm';
    }

    /**
     * @param AnnotationData $annotation
     * @return string
     */
    private function getExistingDocBlock(AnnotationData $annotation)
    {
        $existingDocBlock = $annotation->docBlock;
        $existingDocBlock = str_replace('/**', '', $existingDocBlock);
        $existingDocBlock = str_replace('*/', '', $existingDocBlock);
        return $existingDocBlock;
    }

    /**
     * @param string $fileContents
     * @param AnnotationData $annotation
     * @return int
     */
    private function getIndentation($fileContents, AnnotationData $annotation)
    {
        $operator = preg_quote($annotation->operator);
        $indentationRegexp = "/\\n( *?)$operator/m";
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
        $replacement = "\n";
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
