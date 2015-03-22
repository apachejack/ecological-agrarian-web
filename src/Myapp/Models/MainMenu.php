<?php
namespace Myapp\Models;

class MainMenu{

	public function __construct(){
	}

	protected function getItems(){
		return array(
			array(
				"title" => "Inicio", 
				"link" => "", 
				"active" => true
			), 
			array(
				"title" => "Productos", 
				"link" => "productos", 
				"active" => false
			), 
		);
	}

	public function getData(){
		$items = $this->getItems();
		return $items;
	}

}