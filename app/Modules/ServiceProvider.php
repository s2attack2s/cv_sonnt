<?php

namespace App\Modules;
use File;

/**
* ModulesServiceProvider
*
* The service provider for the modules. After being registered
* it will make sure that each of the modules are properly loaded
* i.e. with their routes, views etc.
*
* @author QuyPN <quypn@toploop.co>
* @package App\Modules
*/
class ServiceProvider extends  \Illuminate\Support\ServiceProvider{
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot(){
        // For each of the registered modules, include their routes and Views
        $listModule = array_map('basename', File::directories(__DIR__));
        foreach ($listModule as $module) {
            // Load the routes for each of the modules
            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                include __DIR__.'/'.$module.'/routes.php';
            }
            // Load the views
            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
        }
    }
    public function register(){}
}
