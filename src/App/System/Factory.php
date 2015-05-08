<?php

namespace App\System;

use Doctrine\ORM\EntityManager;
use Silex\Application;

class Factory
{

    /**
     * Instance of Silex Application
     * @var Silex\Application 
     */
    private static $app;

    /**
     * Set Reference Instance Silex App
     * @param Silex\Application $app
     */
    public static function setApp(Application $app)
    {
        self::$app = $app;
    }

    /**
     * Get Reference Instance Silex App
     * @return Silex\Application $app
     */
    public static function getApp()
    {
        return self::$app;
    }

    /**
     * Instancia do EntityManager
     * @var \Doctrine\ORM\EntityManager
     */
    private static $entityManager;

    /**
     * Set EntityManager
     * @param Doctrine\ORM\EntityManager $entityManager
     */
    public static function setEntityManager(EntityManager $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    /**
     * Get Instance EM
     * @throws ErrorException
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getInstanciaEM()
    {
        if (!(self::$entityManager instanceof EntityManager))
        {
            throw new \ErrorException("Definition missing entityManager!");
        }
        return self::$entityManager;
    }

    /**
     * Get List Controllers Avaliables
     * @return array
     */
    public static function getListControllers()
    {
        $Items = new DirectoryIterator($app["path_controllers"]);
        $controllers = array();
        foreach ($Items as $Item)
        {
            if ($Item->isFile() && !$Item->isDot())
            {
                if ($Item->getExtension() == "php")
                {
                    $controllers[] = $Item->getBasename(".php");
                }
            }
        }
        
        return $controllers;
    }

}
