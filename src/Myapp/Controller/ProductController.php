<?php
namespace Myapp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ProductController
{

	public function get(Request $request, Application $app, $id){
	    $data = array(
	        "id" => $id, 
	        "menu" => $app["mainMenu"]->getData()
	    );

	    return $app['twig']->render('products/product-view.html', $data);
	}

	public function buy(Request $request, Application $app, $id){

	}

}