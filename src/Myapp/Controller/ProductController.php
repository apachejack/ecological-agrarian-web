<?php
namespace Myapp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Myapp\Models\Product;

class ProductController
{

	public function get(Request $request, Application $app, $id){
		$Product = new Product($app, $id);
	    $data = array(
	        "product" => $Product->getDetails(), 
	        "menu" => $app["mainMenu"]->getData()
	    );

	    return $app['twig']->render('products/product-view.html', $data);
	}

	public function buy(Request $request, Application $app, $id){

	}

}