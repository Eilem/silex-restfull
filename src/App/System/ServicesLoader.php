<?php
namespace App\System;

use Silex\Application;

class ServicesLoader
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Set gateways to access datas
     * @param array $gateways
     */
    public function bindServicesIntoContainer(array $gateways)
    {
        foreach($gateways as $gateway=>$classNameGateway){
            $this->app[$gateway.".service"] = $this->app->share(function($classNameGateway){
                return new $classNameGateway();
            });
        }
    }
}