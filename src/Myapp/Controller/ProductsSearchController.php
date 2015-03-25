<?php
namespace Myapp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ProductsSearchController
{

	public function getAll(Application $app){
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
	}

}