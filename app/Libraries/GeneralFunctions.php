<?php namespace Ds3\Libraries;

use Ds3\Libraries\Constants;

class GeneralFunctions
{
	public static function uploadImage($image, $filePath, $type = 'general')
	{
		$uploadedFile = $image->getPathName();
		$fileName = $image->getClientOriginalName();
		$lastdot = strrpos($fileName, ".");
		$name = substr($fileName, 0, $lastdot);
		$fileSize = $image->getSize();
		$extension = $image->getClientOriginalExtension();
		list($width, $height) = getimagesize($uploadedFile);

		if (($width > Constants::DSS_IMAGE_MAX_WIDTH || $height > Constants::DSS_IMAGE_MAX_HEIGHT)
			|| $fileSize > Constants::DSS_IMAGE_MAX_SIZE
			|| ($type == 'profile' && ($width > Constants::DSS_IMAGE_PROFILE_WIDTH || $height > Constants::DSS_IMAGE_PROFILE_HEIGHT))
			|| ($type == 'device' && ($width > Constants::DSS_IMAGE_DEVICE_WIDTH || $height > Constants::DSS_IMAGE_DEVICE_HEIGHT))) {

			if(strtolower($extension) == "jpg" || strtolower($extension) == "jpeg" ) {
				$src = imagecreatefromjpeg($uploadedFile);
			} elseif (strtolower($extension) == "png") {
				$src = imagecreatefrompng($uploadedFile);
			} else {
				$src = imagecreatefromgif($uploadedFile);
			}

			if (($width > Constants::DSS_IMAGE_MAX_WIDTH || $height > Constants::DSS_IMAGE_MAX_HEIGHT)
				|| ($type == 'profile' && ($width > Constants::DSS_IMAGE_PROFILE_WIDTH || $height > Constants::DSS_IMAGE_PROFILE_HEIGHT))
				|| ($type == 'device' && ($width > Constants::DSS_IMAGE_DEVICE_WIDTH || $height > Constants::DSS_IMAGE_DEVICE_HEIGHT))) {

				if ($type == 'profile') {
					$resizeWidth = Constants::DSS_IMAGE_PROFILE_WIDTH;
					$resizeHeight = Constants::DSS_IMAGE_PROFILE_HEIGHT;
				} elseif ($type=='device') {
					$resizeWidth = Constants::DSS_IMAGE_DEVICE_WIDTH;
					$resizeHeight = Constants::DSS_IMAGE_DEVICE_HEIGHT;
				} else {
					$resizeWidth = Constants::DSS_IMAGE_RESIZE_WIDTH;
					$resizeHeight = Constants::DSS_IMAGE_RESIZE_HEIGHT;
				}

				$propWidth = $width / $resizeWidth;
				$propHeight = $height / $resizeHeight;
				if ($propWidth > $propHeight) {
					$newWidth = $resizeWidth;
					$newHeight = ($height / $width) * $newWidth;
				} elseif ($propHeight > $propWidth) {
					$newHeight = $resizeHeight;
					$newWidth = ($width / $height) * $newHeight;
				} else {
					$newWidth = $resizeWidth;
					$newHeight = $resizeHeight;
				}
			} else {
				$newWidth = $width;
				$newHeight = $height;
			}

			$tmp = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			if ($extension == 'jpg' || $extension == 'jpeg') {
				imagejpeg($tmp, $filePath, 60);
			} elseif ($extension == 'png') {
				imagepng($tmp, $filePath, 6);
			} else {
				imagegif($tmp, $filePath, 60);
			}

			$uploaded = true;
			if (filesize($filePath) > Constants::DSS_FILE_MAX_SIZE) {
				@unlink($filePath);
				$uploaded = false;
			}

			imagedestroy($src);
			imagedestroy($tmp);
		} else {
			if ($image->getSize() <= Constants::DSS_FILE_MAX_SIZE) {
				$image->move($filePath);
				$uploaded = true;
			} else {
				$uploaded =false;
			}
		}

		@chmod($filePath, 0777);
		return $uploaded;
	}

	public static function formatPhone($data)
	{
		if (preg_match('/.*(\d{3}).*(\d{3}).*(\d{4}).*(\d*)$/', $data,  $matches)) {
			$result = '(' . $matches[1] . ') ' .$matches[2] . '-' . $matches[3];

			if (!empty($matches[4])) {
				$result .= ' x'.$matches[4];
			}

			return $result;
		}
	}

	public static function num($n, $phone = true)
	{
		$n = preg_replace('/\D/', '', $n);
		if (!$phone) {
			return $n;
		}
		$pattern = '/([1]*)(.*)/'; 
		preg_match($pattern, $n, $matches);
		
		return $matches[2];
	}
}