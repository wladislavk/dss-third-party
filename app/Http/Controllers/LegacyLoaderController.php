<?php
namespace Ds3\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ds3\Libraries\Legacy\Loader;

class LegacyLoaderController extends Controller
{
    private $request;
    private $loader;

    public function __construct(Request $request, Loader $loader)
    {
        $this->request = $request;
        $this->loader = $loader;
    }

    public function index()
    {
        // return 'something';
        return $this->loader->loadFile('inner.php');
    }
}