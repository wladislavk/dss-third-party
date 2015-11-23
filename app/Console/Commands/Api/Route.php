<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Console\Command;

class Route extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:route {controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add routing from controller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = __DIR__.'/../../../Http/';
        $file = file_get_contents($dir.'apiroutes.php');

        $pos = strpos($file, 'Route::group');
        $len = strlen($file);

        for (; $pos < $len; ++$pos) {
            if ($file[$pos] == "\n") {
                ++$pos;
                break;
            }
        }

        if ($pos < $len) {
            $name = str_replace(['Api','Controller'], '', $this->argument('controller'));
            $name[0] = strtolower($name[0]);
            $name = str_replace('_', '-', snake_case($name));

            $str = substr($file, 0, $pos);

            $str .= "\n    /** Api/".$this->argument('controller').".php */\n";
            $str .= "    Route::resource('$name', 'Api\\" . $this->argument('controller') . "');\n";
            $str .= substr($file, $pos);

            rename($dir.'apiroutes.php', $dir.'apiroutes-temp.php');

            try {
                file_put_contents($dir.'apiroutes.php', $str);
            } catch (\Exception $e) {
                unlink($dir.'apiroutes.php');
                copy($dir.'apiroutes-temp.php', $dir.'apiroutes.php');
            } finally {
                unlink($dir.'apiroutes-temp.php');
            }
        }
    }
}
