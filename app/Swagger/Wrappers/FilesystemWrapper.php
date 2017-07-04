<?php

namespace DentalSleepSolutions\Swagger\Wrappers;

use Illuminate\Filesystem\FilesystemAdapter;

class FilesystemWrapper
{
    /** @var resource|bool */
    private $fh;

    /** @var FilesystemAdapter */
    private $filesystemAdapter;

    public function __construct(FilesystemAdapter $filesystemAdapter)
    {
        $this->filesystemAdapter = $filesystemAdapter;
    }

    /**
     * @param string $filename
     * @return bool|string
     */
    public function fileGetContents($filename)
    {
        return file_get_contents($filename);
    }

    /**
     * @param string $directory
     * @return array
     */
    public function allFiles($directory)
    {
        return $this->filesystemAdapter->allFiles($directory);
    }

    /**
     * @param string $filename
     * @param string $mode
     */
    public function fOpen($filename, $mode)
    {
        $this->fh = fopen($filename, $mode);
    }

    /**
     * @param string $contents
     */
    public function fWrite($contents)
    {
        fwrite($this->fh, $contents);
    }

    public function fClose()
    {
        fclose($this->fh);
    }

    public function __destruct()
    {
        if ($this->fh) {
            fclose($this->fh);
        }
    }
}
