<?php
namespace Myapp\Models;
use Silex\Application;

class ProductsSearch{
	protected $app;

	public function __construct(Application $app){
		$this->app = $app;
	}

	public function getProducts(){
		$query = "SELECT * 
				FROM productos as p 
				ORDER BY p.updated_at DESC";

		$stmt = $this->app["db"]->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function setSearch(array $data){
		/* define los parámetros de búsqueda */
	}

	public function getSearch(){
		/* devuelve los parámetros de búsqueda */
	}
}