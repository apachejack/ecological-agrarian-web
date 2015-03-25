<?php
namespace Myapp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Myapp\Models\ProductsSearch;

class ProductsSearchController
{

	public function getAll(Application $app){

	    $ProductsSearch = new ProductsSearch($app);
	    $products = $ProductsSearch->getProducts();

	    $data = array(
	        "products" => $products, 
	        "menu" => $app["mainMenu"]->getData()
	    );

	    return $app['twig']->render('catalogue/index.html', $data);
	}

}