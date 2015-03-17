<?php
namespace Ds3\Libraries\Legacy;

use Illuminate\Foundation\Application;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Auth\Guard as Auth;
use Illuminate\Exception\WhoopsDisplayer;

class Loader
{
    private $app;
    private $request;
    private $response;
    private $auth;
    private $legacyPath = '';

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
            throw new LoaderException('Path to the legacy repository has not been defined');
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

    public function loadFile($relativePath)
    {
        $fullPath = "{$this->legacyPath}/$relativePath";
        $realPath = realpath($fullPath);

        /**
         * Ensure the file is inside the legacy path, the legacy path must
         * be the first match inside the real path
         */
        if (!$realPath || strpos($realPath, $this->legacyPath) !== 0 || !is_file($realPath)) {
            throw new LoaderException("The path '$relativePath' (full path '$fullPath') does not resolve to a valid legacy file");
        }

        /**
         * Prepare variables to catch the output and new headers. If the legacy script dies
         * we would need to add an exit function to output the buffer
         */
        $legacyOutput = '';

        try {
            ob_start();
            error_reporting(E_ALL);
            ini_set('display_errors', true);
            require_once $realPath;

            $legacyOutput = ob_get_clean();
        } catch (\Exception $exception) {
            // if ($this->auth->user() && $this->auth->user()->hasRole('Admin')) {
            if (true) {
                // $whoopsDisplayer = new WhoopsDisplayer($this->app->make('whoops'), false);
                // return $whoopsDisplayer->display($exception);
                throw $exception;
            } else {
                return $this->response->view('errors.503');
            }
        }

        /**
         * @Todo: Ensure the response methods are the correct ones
         */
        return $this->response->make($legacyOutput);
    }
}
