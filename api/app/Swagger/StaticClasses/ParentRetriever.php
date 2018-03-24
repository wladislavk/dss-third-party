<?php
namespace DentalSleepSolutions\Swagger\StaticClasses;

class ParentRetriever
{
    /**
     * @param string $className
     * @return array
     */
    public static function getParents($className)
    {
        $class = new \ReflectionClass($className);

        $parents = [];

        $parent = $class->getParentClass();
        if ($parent) {
            $parents[] = $parent->getName();
            $parents = array_merge($parents, self::getParents($parent->getName()));
        }
        return $parents;
    }
}