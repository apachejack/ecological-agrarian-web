<?php
namespace Myapp\Models;
use Silex\Application;

/* Las imágenes que muestren al principio los productos deben ser siempre las más recientes */

class GalleryPic{
	protected $title;
	protected $description;
	protected $path;
	protected $id;
	protected $created_at;

	protected $cache_data = null;


	public function __construct(array $params){
		$this->title = $params["title"];
		$this->description = $params["description"];
		$this->path = $params["path"];
		$this->id = $params["id"];
		$this->created_at = $params["created_at"];
	}

	public function get(){

		$data = array(
			"title" => $this->title, 
			"description" => $this->description, 
			"path" => array(
				"thumbnail" => GalleryPic::getThumbnailPath($this->path), 
				"medium" => GalleryPic::getMediumPath($this->path), 
				"original" => GalleryPic::getOriginalPath($this->path)
			), 
			"id" => $this->id
		);

		$this->cache_data = $data;

		return $data;
	}

	public function getBlueimpGalleryFormat(){
		/*
		https://github.com/blueimp/Gallery#initialization
		*/

		if(is_null($this->cache_data)){
			$this->get();
		}

		$data = array(
			"title" => $this->cache_data["title"], 
			"href" => $this->cache_data["path"]["medium"], 
			"thumbnail" => $this->cache_data["path"]["thumbnail"]
		);

		return $data;
	}


	public static function prependBasePath($string){
		return "uploads/images/".$string;
	}

	public static function getThumbnailPath($path){
		if(is_null($path)){
			return $path;
		}
		return self::prependBasePath("thumbnail/".$path);
	}

	public static function getMediumPath($path){
		if(is_null($path)){
			return $path;
		}
		return self::prependBasePath($path);
	}

	public static function getOriginalPath($path){
		if(is_null($path)){
			return $path;
		}
		return self::prependBasePath("original/".$path);
	}
}