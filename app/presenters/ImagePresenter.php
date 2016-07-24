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

			$exifGps = $this->fileExifData->getExifGps($this->fileExifData->getExifData($dirForUpload . "/" . $path . "/" . $name));

			$imageEntity = new Image();
			$imageEntity->imageName = $name;
			$imageEntity->imagePath = $path;
			$imageEntity->user = $this->user->identity;
			$imageEntity->lat = $exifGps['lat'];
			$imageEntity->lng = $exifGps['lng'];
			$this->em->getDao(Image::class)->save($imageEntity);

		}
		$this->sendResponse(new JsonResponse($result));
	}

}