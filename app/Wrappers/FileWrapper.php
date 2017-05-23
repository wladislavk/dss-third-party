<?php

namespace DentalSleepSolutions\Wrappers;

class FileWrapper
{
    /**
     * @param string $filename
     * @return bool
     */
    public function isFile($filename)
    {
        return is_file($filename);
    }

    /**
     * @return string
     */
    public function getPublicPath()
    {
        return public_path();
    }
}
