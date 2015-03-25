<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Cosa;
use App\Db\Db;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {

    $data = array(
        "users" => null, 
        "menu" => $app["mainMenu"]->getData()
    );

    return $app['twig']->render('index.html', $data);
})
->bind('homepage')
;

$app->get('/productos', function () use ($app) {

    $products = array(
        array(
            "title" => "sadfasd", 
            "prize" => "12€", 
            "description" => "lore lore", 
            "id" => 5
        ), 
        array(
            "title" => "sadfads", 
            "prize" => "15€", 
            "description" => "penes", 
            "id" => 5
        ), 
        array(
            "title" => "sadfasd", 
            "prize" => "12€", 
            "description" => "lore lore", 
            "id" => 5
        ), 
        array(
            "title" => "sadfads", 
            "prize" => "15€", 
            "description" => "penes", 
            "id" => 5
        )
    );

    $data = array(
        "products" => $products, 
        "menu" => $app["mainMenu"]->getData()
    );

    return $app['twig']->render('catalogue/index.html', $data);
})
->bind('productos')
;


$app->get('/producto/{id}', function ($id) use ($app) {
    $data = array(
        "id" => $id, 
        "menu" => $app["mainMenu"]->getData()
    );

    return $app['twig']->render('products/product-view.html', $data);
})
->bind('producto');


$app->get('/sobre-nosotros/', function() use ($app) {
    $data = array(
        "menu" => $app["mainMenu"]->getData()
    );

    return $app["twig"]->render('about_us/index.html', $data);
})
->bind('sobre_nosotros');


$app->get('/contacta/', function() use ($app) {

    $data = array(
        "menu" => $app["mainMenu"]->getData()
    );

    return $app["twig"]->render('contact/index.html', $data);

})
->bind('contacta');


$app->get('/shopping_cart/', function() use ($app){

    $data = array(
        "menu" => $app["mainMenu"]->getData()
    );

    return $app["twig"]->render('shopping_cart/index.html', $data);

})
->bind('shopping_cart');


$app->get('/login/', function() use ($app){
    $data = array(
        "menu" => $app["mainMenu"]->getData()
    );

    return $app["twig"]->render('login/index.html', $data);

})
->bind("login");


$app->get('/admin/', function() use ($app){
    return $app["twig"]->render('admin/layout.html', array());
})
->bind("admin");

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
