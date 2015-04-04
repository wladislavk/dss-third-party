<?php
namespace Ds3\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Config\Repository as Config;
use Ds3\Libraries\Legacy\Loader;
use Ds3\Libraries\Legacy\LoaderException;
use Closure;

class LegacyLoader implements Middleware
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function handle($request, Closure $next)
    {
        try {
            $legacyPath = $this->config->get('app.legacy_path');
            $baseUrl = $this->config->get('app.url');
            $url = $request->url();

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

            $response = $loader->load($legacyFile);
            return $response;
        } catch (LoaderException $exception) {
            // Legacy file not found
        }

        return $next($request);
    }
}
