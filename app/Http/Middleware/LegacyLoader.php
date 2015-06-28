<?php
namespace Ds3\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as Config;
use Ds3\Libraries\Legacy\Loader;
use Ds3\Libraries\Legacy\LoaderException;
use Closure;

class LegacyLoader implements Middleware
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

    public function handle($request, Closure $next)
    {
        try {
            $legacyPath = $this->config->get('app.legacy_path');
            $baseUrl = $this->config->get('app.url');
            $url = $request->url();

            $queryString = null;
            $requestUri = $request->getRequestUri();

            if (strpos($requestUri, '?') !== false) {
                $queryString = strstr($requestUri, '?');
                $queryString = substr($queryString, 1);
            }

            /**
             * The current url could not match the base url if
             * the request is the root and there is no trailing slash
             */
            if (strpos($url, $baseUrl) === false) {
                $legacyFile = '';
            } else {
                $legacyFile = preg_replace('@^' . preg_quote($baseUrl) . '@', '', $url);
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
            // Legacy file not found
        }

        return $next($request);
    }
}
