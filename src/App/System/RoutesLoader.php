<?php

namespace App\System;

use Silex\Application;

class RoutesLoader {

    private $app;

    public function __construct(Application $app,array $controllers) {
        $this->app = $app;
        $this->loadControllers($controllers);
    }

    private function loadControllers(array $controllers)
    {
        foreach($controllers as $controller){
            $this->app[$controller."controller"] = $this->app->share(function($controller){
                $classControllerName = "App\Controllers\{$controller}";
                return new $classControllerName($this->app);
            });
        }
    }
    
    public function bindRoutesToControllers() {
        $api = $this->app["controllers_factory"];

        #Examples
        $api->get('/examples/{id}', 'example.controller:getId');
        $api->get('/examples', 'example.controller:getAll');
        
        $api->match("/examples", "example.controller:persist")->method("PUT|POST");
        $api->match("/examples/{id}", "example.controller:persist")->method("PUT|POST");
        
        $api->delete('/examples/{id}', 'example.controller:delete');

        $this->app->mount($this->app["api.endpoint"] . '/' . $this->app["api.version"], $api);
    }

}
