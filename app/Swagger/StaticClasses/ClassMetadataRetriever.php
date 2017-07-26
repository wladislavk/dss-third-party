<?php

namespace DentalSleepSolutions\Swagger\StaticClasses;

class ClassMetadataRetriever
{
    /**
     * @param string $fileContents
     * @return string
     */
    public static function getClassNameFromFile($fileContents)
    {
        $tokens = token_get_all($fileContents);
        $classIndex = -1;
        $namespaceIndex = -1;
        $className = '';
        $namespace = '';
        foreach ($tokens as $index => $token) {
            $isClass = self::isCorrectToken($token, T_CLASS);
            if ($isClass && $classIndex == -1) {
                $classIndex = $index;
            }
            $isNamespace = self::isCorrectToken($token, T_NAMESPACE);
            if ($isNamespace) {
                $namespaceIndex = $index;
            }
        }
        if ($classIndex > -1) {
            $className = self::getClassName($tokens, $classIndex);
        }
        if (!$className) {
            return '';
        }
        if ($namespaceIndex > -1) {
            $namespace = self::getNamespace($tokens, $namespaceIndex);
        }
        $fullClassName = $namespace . '\\' . $className;
        return $fullClassName;
    }

    /**
     * @param string|array $token
     * @param int $code
     * @return bool
     */
    private static function isCorrectToken($token, $code)
    {
        if (!is_array($token)) {
            return false;
        }
        if ($token[0] == $code) {
            return true;
        }
        return false;
    }

    /**
     * @param string[] $tokens
     * @param int $index
     * @return string
     */
    private static function getClassName(array $tokens, $index)
    {
        if (
            isset($tokens[$index + 2]) &&
            isset($tokens[$index + 2][1])
        ) {
            return $tokens[$index + 2][1];
        }
        return '';
    }

    /**
     * @param array $tokens
     * @param int $index
     * @return string
     */
    private static function getNamespace(array $tokens, $index)
    {
        $namespace = '';
        $index += 2;
        while (
            isset($tokens[$index]) &&
            isset($tokens[$index][1]) &&
            $tokens[$index][1] != ';'
        ) {
            $namespace .= $tokens[$index][1];
            $index += 1;
        }
        return $namespace;
    }
}
