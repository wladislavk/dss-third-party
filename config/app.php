<?php

return [
    'debug' => env('APP_ENV') === 'production' ? false : env('APP_DEBUG', false),
    'legacy_path' => env('LEGACY_PATH', '/var/www/html/legacy'),
    'url' => env('APP_URL', 'https://www.dentalsleepsolutions.com/'),
    'apiUrl' => env('API_URL', 'https://api.dentalsleepsolutions.com/'),
    'domain' => env('APP_URL_NAME', 'DentalSleepSolutions.com'),
    'name' => env('APP_NAME', 'Dental Sleep Solutions'),
    'timezone' => 'US/Eastern',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => env('APP_KEY'),
    'cipher' => MCRYPT_RIJNDAEL_128,
    'log' => 'daily', // single, daily, syslog

    'providers' => [
        /*
         * Application Service Providers...
         */
        'Ds3\Providers\AppServiceProvider',
        'Ds3\Providers\EventServiceProvider',
        'Ds3\Providers\RouteServiceProvider',
        'Ds3\Providers\UserServiceProvider',
        'Ds3\Providers\AdminServiceProvider',
        'Ds3\Providers\Ds3AuthServiceProvider',
        'Ds3\Providers\AccessCodeServiceProvider',
        'Ds3\Providers\BackOfficeServiceProvider',
        'Ds3\Providers\PlanServiceProvider',
        'Ds3\Providers\CompanyServiceProvider',
        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',

        'Illuminate\Html\HtmlServiceProvider',
        'Barryvdh\Debugbar\ServiceProvider',
        'Intouch\LaravelNewrelic\NewrelicServiceProvider'
    ],

    'manifest' => storage_path().'/framework',

    'aliases' => [
        'App'       => 'Illuminate\Support\Facades\App',
        'Artisan'   => 'Illuminate\Support\Facades\Artisan',
        'Auth'      => 'Illuminate\Support\Facades\Auth',
        'Blade'     => 'Illuminate\Support\Facades\Blade',
        'Cache'     => 'Illuminate\Support\Facades\Cache',
        'Config'    => 'Illuminate\Support\Facades\Config',
        'Cookie'    => 'Illuminate\Support\Facades\Cookie',
        'Crypt'     => 'Illuminate\Support\Facades\Crypt',
        'DB'        => 'Illuminate\Support\Facades\DB',
        'Event'     => 'Illuminate\Support\Facades\Event',
        'File'      => 'Illuminate\Support\Facades\File',
        'Hash'      => 'Illuminate\Support\Facades\Hash',
        'Input'     => 'Illuminate\Support\Facades\Input',
        'Inspiring' => 'Illuminate\Foundation\Inspiring',
        'Lang'      => 'Illuminate\Support\Facades\Lang',
        'Log'       => 'Illuminate\Support\Facades\Log',
        'Mail'      => 'Illuminate\Support\Facades\Mail',
        'Paginator' => 'Illuminate\Support\Facades\Paginator',
        'Password'  => 'Illuminate\Support\Facades\Password',
        'Queue'     => 'Illuminate\Support\Facades\Queue',
        'Redirect'  => 'Illuminate\Support\Facades\Redirect',
        'Redis'     => 'Illuminate\Support\Facades\Redis',
        'Request'   => 'Illuminate\Support\Facades\Request',
        'Response'  => 'Illuminate\Support\Facades\Response',
        'Route'     => 'Illuminate\Support\Facades\Route',
        'Schema'    => 'Illuminate\Support\Facades\Schema',
        'Session'   => 'Illuminate\Support\Facades\Session',
        'URL'       => 'Illuminate\Support\Facades\URL',
        'Validator' => 'Illuminate\Support\Facades\Validator',
        'View'      => 'Illuminate\Support\Facades\View',

        'Form'        => 'Illuminate\Html\FormFacade',
        'HTML'        => 'Illuminate\Html\HtmlFacade'
    ],
];
