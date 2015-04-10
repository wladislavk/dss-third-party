<?php
namespace Ds3\Libraries\Legacy;

use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class Loader
{
    public static $redirectRegex = '@
            \s*<script[^>]*?>\s*
                (?:alert\(.*?\);\s*)?
                (?:
                    window\.location\.replace\(\s*(?:["\'])(?<replacePath>.+)\1\s*\);
                    |
                    window\.location\s*=\s*(?:["\'])(?<assignPath>.+)\1\s*;
                )
            \s*</script>\s*
        @isx';

    private $legacyPath = '';       // Config value of the legacy files
    private $outputBuffer = '';     // Buffer capture of the legacy load
    private $outputHeaders = [];    // Headers as set by the legacy load

    private $backupDepot = [
        'currentDir' => '',
        'headers' => [],
        'superglobals' => [
            'post' => [],
            'get' => [],
            'server' => []
        ],
        'errorLevel' => 0,
        'bufferLevel' => 0
    ];
    private $serverBackupFields = [
        'PHP_SELF',
        'REQUEST_METHOD',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'SCRIPT_FILENAME',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI'
    ];

    private $requestType = 'get';   // Data to simulate GET/POST requests
    private $requestParams = [
        'get' => [],
        'post' => []
    ];

    private $onStage = false;       // Flag to not screw up when unstaging changes


    /**
     * @param string $path
     * @throws LoaderException
     * @return $this
     */
    public function setLegacyPath($path) {
        $this->legacyPath = realpath($path);

        if (!is_dir($this->legacyPath)) {
            throw new LoaderException('The path specified does not exist');
        }

        return $this;
    }

    /**
     * Real path to the legacy repository, as specified in the app.legacy_path config option
     *
     * @return string
     */
    public function getLegacyPath()
    {
        return $this->legacyPath;
    }

    /**
     * Sets the values of the GET (query string) or POST (payload) request
     *
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
     * @return array
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    /**
     * @return string
     */
    public function getOutputBuffer()
    {
        return $this->outputBuffer;
    }

    /**
     * @return Array
     */
    public function getOutputHeaders()
    {
        return $this->outputHeaders;
    }

    /**
     * Receives a relative path to a legacy file, sets up a request scenario and loads the file
     * The \ErrorException with severity = E_USER_ERROR is a reserved indicator for the legacy file
     * which indicates the script attempted to use exit() or die() to end the execution
     *
     * @param string $relativePath
     * @return \Illuminate\Http\Response
     * @throws LoaderException
     * @throws \Exception
     */
    public function load($relativePath)
    {
        $realPath = $this->getRealPath($relativePath);

        if (!$this->isLegacyFile($realPath)) {
            throw new LoaderException("The path '$relativePath' (full path '$realPath') does not resolve to a valid legacy file");
        }

        $this->stageEnvironment($relativePath, $realPath);

        /**
         * Legacy files should use trigger_error(..., E_USER_ERROR) instead of
         * exit() or die()
         *
         * The private method will catch the first exception and determine if its
         * severity matches E_USER_ERROR. Otherwise the original exception is rethrown
         */
        try {
            $this->requireLegacyFile($realPath);
        } catch (\Exception $exception) {
            $this->unstageEnvironment();
            throw $exception;
        }

        $this->unstageEnvironment();

        $redirection = self::getRedirection($this->outputHeaders, $this->outputBuffer, $relativePath);

        if ($redirection) {
            unset($this->outputHeaders['location']);
            $response = new RedirectResponse($redirection, 302, $this->outputHeaders);
        } else {
            $this->outputBuffer = self::injectBaseTag($this->outputBuffer, $relativePath);
            $response = new Response($this->outputBuffer, 200, $this->outputHeaders);
        }

        return $response;
    }

    /**
     * Appends the relative path to the legacy path and applies realpath() to it
     *
     * @param string $relativePath
     * @return string
     */
    public function getRealPath($relativePath)
    {
        $fullPath = "{$this->legacyPath}/$relativePath";
        return realpath($fullPath);
    }

    /**
     * Determines if the path is a valid file inside the legacy path folder
     *
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
     * Modifies $_GET, $_POST, $_SERVER and current working dir.
     *
     * @param string $relativePath
     * @param string $realPath
     */
    private function stageEnvironment($relativePath, $realPath)
    {
        $this->onStage = true;
        $this->backupDepot = [
            'currentDir' => getcwd(),
            'headers' => headers_list(),
            'superglobals' => [
                'get' => $_GET,
                'post' => $_POST,
                'server' => array_intersect_key($_SERVER, array_flip($this->serverBackupFields)),
            ],
            'bufferLevel' => ob_get_level(),
            'errorLevel' => error_reporting()
        ];

        $this->outputBuffer = '';
        $this->outputHeaders = [];

        $queryString = http_build_query($this->requestParams['get']);
        $scriptPath = "/$relativePath";

        $_POST = $this->requestParams['post'];
        $_GET = $this->requestParams['get'];

        $_SERVER['REQUEST_METHOD'] = $this->requestType;
        $_SERVER['QUERY_STRING'] = $queryString;

        $_SERVER['DOCUMENT_ROOT'] = $this->legacyPath;
        $_SERVER['PATH_TRANSLATED'] = $realPath;
        $_SERVER['PHP_SELF'] = $scriptPath;
        $_SERVER['SCRIPT_FILENAME'] = $scriptPath;
        $_SERVER['SCRIPT_NAME'] = $scriptPath;
        $_SERVER['REQUEST_URI'] = $scriptPath . ($queryString ? "?$queryString" : '');

        chdir(dirname($realPath));

        // Hide non fatal errors
        error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED | E_WARNING));

        ob_start();
    }

    /**
     * Resets values of $_GET, $_POST, $_SERVER variables, returns to the proper working dir
     * and
     */
    private function unstageEnvironment()
    {
        if (!$this->onStage) {
            return;
        }

        error_reporting($this->backupDepot['errorLevel']);
        chdir($this->backupDepot['currentDir']);

        for ($n = ob_get_level(); $n > $this->backupDepot['bufferLevel']; $n--) {
            ob_get_contents();
        }

        $this->outputBuffer = ob_get_clean();
        $headers = headers_list();

        // Remove headers set by the legacy file
        foreach ($headers as $header) {
            $headerName = $header;
            $headerValue = '';

            if (preg_match('@(?<name>.+?)(?:$|:\s*(?<value>.*))@', $header, $match)) {
                $headerName = strtolower($match['name']);
                $headerValue = isset($match['value']) ? $match['value'] : '';
            }

            $this->outputHeaders[$headerName] = $headerValue;
            header_remove($headerName);
        }

        // Restore the headers from the backup
        foreach ($this->backupDepot['headers'] as $header) {
            header($header);
        }

        $_GET = $this->backupDepot['superglobals']['get'];
        $_POST = $this->backupDepot['superglobals']['post'];
        $_SERVER = $this->backupDepot['superglobals']['server'] + $_SERVER;

        $this->onStage = false;
    }

    /**
     * Loads the legacy file, expects to communicate exit() and die()
     * through trigger_error(..., E_USER_ERROR);
     *
     * @param string $legacyFile Full, real path to the file
     * @throws \ErrorException
     * @throws \Exception
     */
    private function requireLegacyFile($legacyFile)
    {
        try {
            require_once $legacyFile;
        } catch (\ErrorException $exitException) {
            /**
             * This is a die() or exit() exception only if the severity
             * matches E_USER_ERROR
             */
            if (
                $exitException->getSeverity() !== E_USER_ERROR ||
                !preg_match('/^(exit|die) called/i', $exitException->getMessage())
            ) {
                throw $exitException;
            }
        }
    }

    /**
     * Analyzes headers and output buffer to determine if it contains redirections
     *
     * @param array $headers
     * @param string $buffer
     * @param string $relativePath Legacy path
     * @return string Detected redirection
     */
    public static function getRedirection($headers = [], $buffer = '', $relativePath)
    {
        $location = '';

        /**
         * The Location header can be relative and might not work properly
         */
        if (!empty($headers['location'])) {
            $location = $headers['location'];
        } elseif (strpos($buffer, 'window.location') !== false && preg_match(self::$redirectRegex, $buffer, $match)) {
            $location = $match['replacePath'] ?: $match['assignPath'];
        }

        if (strlen($location)) {
            /**
             * Test if the redirection has the base domain hardcoded, and remove it
             * Also test if the redirection is relative: it does not contain "://" or doesn't start with a slash
             */
            if (strpos($location, '://dentalsleepsolutions.com')) {
                $location = preg_replace('https?://dentalsleepsolutions\.com/?', '/', $location);
            } elseif (!preg_match('@://|^/@', $location)) {
                $location = dirname("/$relativePath") . "/{$headers['location']}";
            }

            // Remove index.php
            $location = preg_replace('@^(/.*)index\.php$@', '$1', $location);

            // Remove .php extension
            $location = preg_replace('@^(/.*)\.php$@', '$1', $location);
        }

        return $location;
    }

    /**
     * @param string $buffer Output buffer from the legacy file
     * @param string $relativePath
     * @return string Modified buffer (if applicable)
     */
    public static function injectBaseTag($buffer, $relativePath)
    {
        $baseHref = "/$relativePath";
        $baseHref = preg_replace('@//+@', '/', $baseHref);
        $buffer = preg_replace('@(<head[^>]*>)@i', '$1<base href="' . htmlspecialchars($baseHref) . '">', $buffer);

        return $buffer;
    }
}
