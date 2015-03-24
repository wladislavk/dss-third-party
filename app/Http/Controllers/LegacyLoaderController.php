<?php
namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Config\Repository as Config;
use Ds3\Libraries\Legacy\Loader;

class LegacyLoaderController extends Controller
{
    private $request;
    private $loader;
    private $config;

    public function __construct(Request $request, Config $config, Loader $loader)
    {
        $this->request = $request;
        $this->loader = $loader;
        $this->config = $config;
    }

    public function index()
    {
        $legacyPath = $this->config->get('app.legacy_path');
        $loader = new Loader();

        $response = $loader->setLegacyPath($legacyPath)
            ->setRequestParams('post', [
                'loginsub' => 1,
                'username' => 'admin',
                'password' => 'admin'
            ])
            ->load('manage/admin/index.php');

        ob_start();
        dd($response);

        $output = ob_get_clean();

        return $output;
    }
}