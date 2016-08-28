<?php


namespace App\Presenters;
use App\Entities\Image;
use App\Services\FileExifData;
use App\Services\UploadHandler;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\Responses\JsonResponse;


/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 */

class ImagePresenter extends BasePresenter {

	/** @var EntityManager @inject */
	public $em;

	/** @var FileExifData @inject */
	public $fileExifData;

	public function handleUploadPicture() {
		$uploadHandle = new UploadHandler();
		$dirForUpload = __DIR__ . '/../../www/uploads';
		$allowFiles = array("jpeg", "jpg", "png", "gif");
		$uploadHandle->setAllowedExtensions($allowFiles);

		$result = $uploadHandle->handleUpload($dirForUpload);

		if (isset($result["success"]) && $result["success"] == true) {
			$path = $result['uuid'];
			$name = $result['name'];
			$explodedName = explode(".",$name);

			$exifGps = $this->fileExifData->getExifGps($this->fileExifData->getExifData($dirForUpload . "/" . $path . "/" . $name));

			$thumb = \Nette\Utils\Image::fromFile($dirForUpload . "/" . $path . "/" . $name);
			$thumb->resize(300, 300);
			$thumb->save($dirForUpload . "/" . $path . "/" . $name . "-thumb." . $explodedName[count($explodedName) - 1]);

			$img = \Nette\Utils\Image::fromFile($dirForUpload . "/" . $path . "/" . $name);
			$img->resize(1800, 1800);
			$img->save($dirForUpload . "/" . $path . "/" . $name);


			$imageEntity = new Image();
			$imageEntity->name = $name;
			$imageEntity->path = $path;
			$imageEntity->thumb = $name . "-thumb." . $explodedName[count($explodedName) - 1];
			$imageEntity->user = $this->user->identity;
			$imageEntity->lat = $exifGps['lat'];
			$imageEntity->lng = $exifGps['lng'];
			$this->em->persist($imageEntity);
			$this->em->flush();

		}
		$this->sendResponse(new JsonResponse($result));
	}

}