<?php
namespace Ds3\Libraries\Legacy;

class ReflectionClass extends \ReflectionClass
{
    public function __construct($class)
    {
        if (
            is_string($class) &&
            !class_exists($class) &&
            class_exists(__NAMESPACE__ . '\\' . $class)) {
                $class = __NAMESPACE__ . '\\' . $class;
            }
        }

        parent::__construct($class);
    }
}
