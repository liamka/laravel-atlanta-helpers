<?php namespace Atlanta\Helpers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * register the service provider
     *
     * @return void
     */
    public function register()
    {
        //register commands
        $this->commands([
            Commands\HelperMakeCommand::class,
        ]);

        //include the active package atlanta helpers
        foreach (config('atlanta.package_helpers', []) as $activeHelper) {

            $file = __DIR__ . '/AtlantaHelpers/' . $activeHelper . '.php';

            if (file_exists($file)) {
                require_once($file);
            }
        }

        //load custom helpers with a mapper
        if (count(config('atlanta.custom_helpers', []))) {

            foreach (config('atlanta.custom_helpers', []) as $customHelper) {

                $file = app_path() . '/' . $this->getAtlantaHelpersDirectory() . '/' . $customHelper . '.php';

                if(file_exists($file)) {
                    require_once($file);
                }
            }
        }

        //load custom helpers automatically
        else {

            //include the custom atlanta helpers
            foreach (glob(app_path() . '/' . $this->getAtlantaHelpersDirectory() . '/*.php') as $file) {
                require_once($file);
            }
        }
    }

    /**
     * boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        //publish configuration
        $this->publishes([
            __DIR__ . '/config/atlanta.php' => config_path('atlanta.php'),
        ], 'config');
    }

    /**
     * get the directory the helpers are stored in
     *
     * @return mixed
     */
    public function getAtlantaHelpersDirectory()
    {
        return config('atlanta.directory', 'AtlantaHelpers');
    }
}
