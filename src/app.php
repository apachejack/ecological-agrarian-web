<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SessionServiceProvider;


$app = new Application();
$app->register(new RoutingServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
        return $app['request_stack']->getMasterRequest()->getBasepath().'/'.$asset;
    }));

    $twig->addFunction(new \Twig_SimpleFunction('link', function ($link) use ($app) {
        $prefix = "";
        if($app["debug"]){
            $prefix = "index_dev.php/";
        }

        $chain = array(
            $app['request_stack']->getMasterRequest()->getBasepath(), 
            "/", 
            $prefix, 
            $link
        );

        return implode("", $chain);
    }));

    return $twig;
});

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => DB_HOST,
        'dbname'    => DB_NAME,
        'user'      => DB_USER,
        'password'  => DB_PASS,
        'charset'   => 'utf8',
    )
));

$app["mainMenu"] = function($app){
    return new Myapp\Models\MainMenu();
};

return $app;
