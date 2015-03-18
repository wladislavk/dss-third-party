<?php
namespace Ds3\Libraries\Legacy;

use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Auth\Guard as Auth;
// use Illuminate\Exception\WhoopsDisplayer;

class Loader
{
    private $app;
    private $request;
    private $response;
    private $auth;

    private $legacyPath = '';
    private $dirBackup = '';
    private $outputBuffer = '';

    private $requestType = 'get';
    private $requestParams = [
        'get' => [],
        'post' => []
    ];

    /**
     * @param Application $app
     * @param Config $config
     * @param Request $request
     * @param Response $response
     * @param Auth $auth
     * @throws LoaderException
     */
    public function __construct(Application $app, Config $config, Request $request, Response $response, Auth $auth) {
        $path = $config->get('app.legacy_path');
        $this->legacyPath = realpath($path);

        if (!is_dir($this->legacyPath)) {
            throw new LoaderException('Path to the legacy repository has not been defined or is invalid');
        }

        $this->app = $app;
        $this->request = $request;
        $this->response = $response;
        $this->auth = $auth;

        /**
         * Be aware that this change solves the problem with loading path,
         * but does not address the problem with files written to disk.
         *
         * Paths might differ and the file saved to disk will not be found
         */
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->legacyPath);
    }

    /**
     * @param string $type get, post
     * @param Array $parameters Array
     * @param bool $reset Delete previous contents of the parameters
     * @return $this
     */
    public function setRequestParams($type, Array $parameters, $reset = false)
    {
        $type = strtolower($type);

        if (!array_key_exists($type, $this->requestParams) || !is_array($parameters)) {
            return $this;
        }

        if ($reset) {
            $this->requestParams[$type] = [];
        }

        $this->requestParams[$type] = $parameters + $this->requestParams[$type];
        $this->requestType = $type === 'post' ? 'post' : $this->requestType;
        return $this;
    }

    /**
     * @param string $relativePath
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws LoaderException
     * @throws \Exception
     */
    public function load($relativePath)
    {
        $realPath = $this->getRealPath($relativePath);

        if (!$this->isLegacyFile($realPath)) {
            throw new LoaderException("The path '$relativePath' (full path '$realPath') does not resolve to a valid legacy file");
        }

        $this->stageEnvironment($realPath);

        try {
            require_once $realPath;
        } catch (\Exception $exception) {
            $this->unstageEnvironment();

            if (true) {
                throw $exception;
            } else {
                return $this->response->view('errors.503');
            }
        }

        $this->unstageEnvironment();
        return $this->response->make(htmlspecialchars($this->outputBuffer));
    }

    /**
     * @param string $relativePath
     * @return string
     */
    public function getRealPath($relativePath)
    {
        $fullPath = "{$this->legacyPath}/$relativePath";
        return realpath($fullPath);
    }

    /**
     * @param string $filePath
     * @param bool $relative
     * @return bool
     */
    public function isLegacyFile($filePath, $relative = false)
    {
        $realPath = $relative ? $this->getRealPath($filePath) : $filePath;
        return $realPath && strpos($realPath, $this->legacyPath) === 0 && is_file($realPath);
    }

    /**
     * Sets up the environment to execute the legacy file and mimicking GET/POST requests
     *
     * @param string $legacyFile
     */
    private function stageEnvironment($legacyFile)
    {
        // Assume the framework already has a copy of these globals
        $_POST = $this->requestParams['post'];
        $_GET = $this->requestParams['get'];
        $_SERVER['REQUEST_METHOD'] = $this->requestType;
        $_SERVER['DOCUMENT_ROOT'] = $this->legacyPath;

        $this->dirBackup = getcwd();
        chdir(dirname($legacyFile));

        // Hide non fatal errors
        error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED | E_WARNING));

        /**
         * Start output buffer
         *
         * Note that the legacy script might start output buffering, but fail to
         * restore the buffers and let the script exit and take care of it.
         *
         * A better implementation will take into account the level of buffering
         * (nested buffering) and will retrieve all of the buffers up to the level
         * where it started capturing the buffer.
         */
        $this->outputBuffer = '';
        ob_start();
    }

    /**
     * Undoes changes done by stageEnvironment() and retrieves the output buffer
     */
    private function unstageEnvironment()
    {
        $this->outputBuffer = ob_get_clean();

        chdir($this->dirBackup);

        $_POST = [];
        $_GET = [];
    }
}
