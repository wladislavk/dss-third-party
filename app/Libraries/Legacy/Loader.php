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

        $cwd = getcwd();

        try {
            // Hide non fatal errors
            error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED | E_WARNING));

            // Prepare output buffering, change dir to the one for the file being executed
            ob_start();
            chdir(dirname($realPath));

            require_once $realPath;

            // Save script output, restore working directory
            $legacyOutput = ob_get_clean();
            chdir($cwd);
        } catch (\Exception $exception) {
            // if ($this->auth->user() && $this->auth->user()->hasRole('Admin')) {
            //     $whoopsDisplayer = new WhoopsDisplayer($this->app->make('whoops'), false);
            //     return $whoopsDisplayer->display($exception);
            // }

            /**
             * @Todo: Validate that the user is logged in and is able to see exceptions
             *        In the meantime, always show an exception
             */
            if (true) {
                throw $exception;
            } else {
                return $this->response->view('errors.503');
            }
        }

        return $this->response->make($legacyOutput);
    }
}
