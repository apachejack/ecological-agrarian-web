<?php
namespace Myapp\Models;
use Silex\Application;
use Myapp\Models\Product;

/* Las imágenes que muestren los productos deben ser siempre las más recientes */

class ProductsSearch{
	protected $app;

	public function __construct(Application $app){
		$this->app = $app;
	}

	public function getProducts(){
		$query = "SELECT p.title, 
						p.description, 
						p.id, 
						s.status, 
						p.updated_at, 
						(SELECT images.path 
						FROM images 
						WHERE images.idProduct = p.id 
						ORDER BY images.id DESC LIMIT 1) as image_path  
				FROM productos as p 
				LEFT JOIN estados_cosecha as s 
				ON (p.idstatus = s.id) 
				GROUP BY p.id 
				ORDER BY p.updated_at DESC";

		$stmt = $this->app["db"]->prepare($query);
		$stmt->execute();

		$products = $stmt->fetchAll();
		$products = $this->formatAllImagesPaths($products);

		return $products;
	}

	protected function formatAllImagesPaths(array $products){
		array_walk($products, function(&$product){
			$product["image_path"] = Product::formatImagePath($product["image_path"]);
		});

		return $products;
	}

	public function setSearch(array $data){
		/* define los parámetros de búsqueda */
	}

	public function getSearch(){
		/* devuelve los parámetros de búsqueda */
	}
}