<?php
namespace Myapp\Models;
use Silex\Application;

/* Las imágenes que muestren al principio los productos deben ser siempre las más recientes */

class Product{
	protected $app;
	protected $idProduct;

	public function __construct(Application $app, $idProduct = null){
		$this->app = $app;
		$this->idProduct = $idProduct;
	}

	public function getDetails(){
		$query = "SELECT p.title, 
						p.description, 
						p.created_at, 
						p.id, 
						s.status, 
						i.path as image_path 
				FROM productos as p 
				LEFT JOIN estados_cosecha as s 
				ON (p.idstatus = s.id) 
				LEFT JOIN images as i 
				ON (p.id = i.idProduct)
				WHERE p.id = :idProduct 
				ORDER BY i.id DESC 
				LIMIT 1";

		$stmt = $this->app["db"]->prepare($query);
		$stmt->bindValue(":idProduct", $this->idProduct, "integer");
		$stmt->execute();

		$product = $stmt->fetch();
		$product["image_path"] = Product::formatImagePath($product["image_path"]);


		return $product;

	}

	public static function formatImagePath($path){
		if(is_null($path)){
			return $path;
		}
		return "uploads/images/".$path;
	}

}