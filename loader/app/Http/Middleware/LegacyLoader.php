<?php
namespace Ds3\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as Config;
use Ds3\Libraries\Legacy\Loader;
use Ds3\Libraries\Legacy\LoaderException;
use Closure;

class LegacyLoader
{
    private $config;
    private $debugBar = null;

    public function __construct(Application $app, Config $config)
    {
        $this->config = $config;

        if ($config->get('app.debug') && $app['debugbar']) {
            $this->debugBar = $app['debugbar'];
        }
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\Response|mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $legacyPath = $this->config->get('app.legacy_path');
            $legacyFile = $request->path();

            $queryString = null;
            $requestUri = $request->getRequestUri();

            if (strpos($requestUri, '?') !== false) {
                $queryString = strstr($requestUri, '?');
                $queryString = substr($queryString, 1);
            }

            // Set transaction name before modifying the URI
            if (extension_loaded('newrelic')) {
                newrelic_name_transaction($legacyFile);
            }

            // Set default file when no file has been detected
            if ($legacyFile === '' || $legacyFile === '/') {
                $legacyFile = 'index.php';
            }

            $loader = new Loader();
            $loader->setLegacyPath($legacyPath);

            // Try to determine if we are dealing with a folder
            if ($loader->isLegacyFile("$legacyFile/index.php", true)) {
                $legacyFile = "$legacyFile/index.php";
            }

            if ($loader->isLegacyFile("$legacyFile.php", true)) {
                $legacyFile = "$legacyFile.php";
            }

            $loader->setRequestParams('get', $request->query());

            if (strtolower($request->method()) === 'post') {
                $loader->setRequestParams('post', $request->input());
            }

            $response = $loader->load($legacyFile, $queryString);

            if ($this->debugBar) {
                $response = $this->debugBar->modifyResponse($request, $response);
            }

            return $response;
        } catch (LoaderException $exception) {
            die($exception->getMessage());
            // Legacy file not found
        }

        return $next($request);
    }
}
