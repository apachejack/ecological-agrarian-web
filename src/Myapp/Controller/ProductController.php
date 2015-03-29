<?php
namespace Myapp\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Myapp\Models\Product;
use Myapp\Models\GalleryProduct;

class ProductController
{

	public function get(Request $request, Application $app, $id){
		$Product = new Product($app, $id);
		$GalleryProduct = new GalleryProduct($app, $id);

	    $data = array(
	        "product" => $Product->getDetails(), 
	        "product_pics" => $GalleryProduct->getPicsCollection(), 
	        "blueimp_pics" => $GalleryProduct->getPicsBlueImp(), 
	        "menu" => $app["mainMenu"]->getData()
	    );

	    return $app['twig']->render('products/product-view.html', $data);
	}

	public function buy(Request $request, Application $app, $id){

	}

}