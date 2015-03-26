<?php
namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Config\Repository as Config;
use Ds3\Libraries\Legacy\Loader;

class LegacyLoaderController extends Controller
{
    private $loader;
    private $config;

    public function __construct(Config $config, Loader $loader)
    {
        $this->loader = $loader;
        $this->config = $config;
    }

    public function index(Request $request, $legacyFile)
    {
        $legacyPath = $this->config->get('app.legacy_path');
        $loader = new Loader();

        $loader->setLegacyPath($legacyPath)
            ->setRequestParams('get', $request->query());

        if ($request->method() === 'post') {
            $loader->setRequestParams('post', $request->input());
        }

        $response = $loader->load($legacyFile);
        return $response;
    }
}