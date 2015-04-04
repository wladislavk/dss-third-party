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
            $legacyFile = $request->path();

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
