<?php
namespace Myapp\Models;
use Silex\Application;

/* Las imágenes que muestren al principio los productos deben ser siempre las más recientes */

class GalleryProduct{
	protected $app;
	protected $idProduct;

	protected $cache_pics = null;

	public function __construct(Application $app, $idProduct = null){
		$this->app = $app;
		$this->idProduct = $idProduct;
	}

	protected function getPicsFromDb(){

		$query = "SELECT images.path, 
						images.title, 
						images.description, 
						images.created_at, 
						images.id  
					FROM images 
					WHERE images.idProduct = :idProduct 
					ORDER BY images.created_at DESC";

		$stmt = $this->app["db"]->prepare($query);
		$stmt->bindValue(":idProduct", $this->idProduct, "integer");
		$stmt->execute();

		$pics = $stmt->fetchAll();
		$this->cache_pics = $pics;

		return $pics;

	}

	protected function getPics(){
		if(is_null($this->cache_pics)){
			$this->getPicsFromDb();
		}

		return $this->cache_pics;
	}


	public function getPicsCollection(){
		$pics = $this->getPics();
		$gallery_pics = array();

		array_walk($pics, function($pic) use (&$gallery_pics){

			$GalleryPic = new GalleryPic($pic);
			$gallery_pics[] = $GalleryPic->get();
		});

		return $gallery_pics;
	}


	public function getPicsBlueImp(){
		$pics = $this->getPics();
		$gallery_blueimp = array();

		$prependBase = function($path){
			return $this->app['request_stack']->getMasterRequest()->getBasepath().'/'.$path;
		};

		array_walk($pics, function($pic) use (&$gallery_blueimp, $prependBase){

			$GalleryPic = new GalleryPic($pic);

			$new_pic = $GalleryPic->getBlueimpGalleryFormat();
			$new_pic["href"] = $prependBase($new_pic["href"]);
			$new_pic["thumbnail"] = $prependBase($new_pic["thumbnail"]);

			$gallery_blueimp[] = $new_pic;
		});

		return json_encode($gallery_blueimp);
	}

	public static function formatImagePath($path){
		return GalleryPic::getMediumPath($path);
	}

}