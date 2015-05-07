<?php
use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\ServicesLoader;
use App\RoutesLoader;
use Carbon\Carbon;
use App\System\Factory;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/*
| -------------------------------------------------------------------
| CORS
| @link http://pt.wikipedia.org/wiki/Cross-origin_resource_sharing
| -------------------------------------------------------------------
*/
$app->before(function (Request $request) {
    if ($request->getMethod() === "OPTIONS") {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Origin","*");
        $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers","Content-Type");
        $response->setStatusCode(200);
        //$response->send();
        return $response;
    }
}, Application::EARLY_EVENT);

$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin","*");
    $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
});

/*
| -------------------------------------------------------------------
| JSON
| @link http://pt.wikipedia.org/wiki/JSONP
| -------------------------------------------------------------------
*/
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
}); 

/*
| -------------------------------------------------------------------
| Add Services
| -------------------------------------------------------------------
*/
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => ROOT_PATH . "/storage/cache"));

$config = Setup::createAnnotationMetadataConfiguration(
    array($app["path_class"]), true);
$eM = EntityManager::create($app["db"]["db.options"], $config);

Factory::setEntityManager($eM);

$servicesLoader = new ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

$routesLoader = new RoutesLoader($app);
$routesLoader->bindRoutesToControllers();


/*
| -------------------------------------------------------------------
| Log da App
| -------------------------------------------------------------------
*/
$app->register(new MonologServiceProvider(), array(
    "monolog.logfile" => $app["log.file"]. Carbon::now('America/Sao_Paulo')->format("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "application"
));

/*
| -------------------------------------------------------------------
| Errors
| -------------------------------------------------------------------
*/
$app->error(function (\Exception $e, $code) use ($app) {
    
    switch ($code) {
        case 404:
            $app['monolog']->addError("404 NOT FOUND !");
            break;
        default:
            $app['monolog']->addError("Houston we have a problem !");
            break;
    }
    
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    return new JsonResponse($e->getMessage(), $code);
});

/*
| -------------------------------------------------------------------
| Return App to Index
| -------------------------------------------------------------------
*/
return $app;