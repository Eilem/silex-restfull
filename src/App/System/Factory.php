<?php
namespace App\System;

use Doctrine\ORM\EntityManager;
use Silex\Application;

class Factory{
    
    /**
     * Instancia para Silex Application
     * @var Silex\Application 
     */
    private static $app;
    
    /**
     * Define uma referencia para Silex Application
     * @param Silex\Application $app
     */
    public static function setApp(Application $app)
    {
        self::$app = $app;
    }
    
    /**
     * Obtem uma referencia para Silex Application
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
     * Define a Instancia do EntityManager
     * @param Doctrine\ORM\EntityManager $entityManager
     */
    public static function setEntityManager(EntityManager $entityManager){
        self::$entityManager = $entityManager;
    }
    
    /**
     * Obtém a instancia do EntityManager
     * @throws ErrorException
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getInstanciaEM(){
        if(!(self::$entityManager instanceof EntityManager))
        {
            throw new \ErrorException("Definition missing entityManager!");            
        }
        return self::$entityManager;
    }
}