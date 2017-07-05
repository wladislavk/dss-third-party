<?php

namespace DentalSleepSolutions\Swagger\Wrappers;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class FilesystemWrapper
{
    /** @var resource|bool */
    private $fh;

    /** @var Filesystem */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
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
     * @return string[]
     */
    public function allFiles($directory)
    {
        /** @var SplFileInfo[] $files */
        $files = $this->filesystem->allFiles($directory);
        $filenames = [];
        foreach ($files as $file) {
            $filenames[] = $file->getPathname();
        }
        return $filenames;
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
        $this->fh = null;
    }

    public function __destruct()
    {
        if ($this->fh) {
            fclose($this->fh);
        }
    }
}
