<?php
namespace Myapp\Models;
use Silex\Application;

class Product{
	protected $app;
	protected $idProduct;

	public function __construct(Application $app, $idProduct = null){
		$this->app = $app;
		$this->idProduct = $idProduct;
	}

	public function getDetails(){
		$query = "SELECT * 
				FROM productos as p 
				WHERE p.id = :idProduct 
				LIMIT 1";

		$stmt = $this->app["db"]->prepare($query);
		$stmt->bindValue(":idProduct", $this->idProduct, "integer");
		$stmt->execute();

		return $stmt->fetch();
	}

}