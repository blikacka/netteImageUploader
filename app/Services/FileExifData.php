<?php


namespace App\Services;


/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 */

class FileExifData {


	/**
	 * @param string $file - full path to file
	 * @return array
	 */
	public function getExifData($file) {

		$exifData = exif_read_data($file, 0, true);

		return $exifData;
	}


	/**
	 * @param array $exifData
	 * @return array
	 */
	public function getExifGps($exifData) {

		if (isset($exifData['GPS']) && isset($exifData['GPS']['GPSLatitude']) && count($exifData['GPS']['GPSLatitude']) > 2 && isset($exifData['GPS']['GPSLongitude']) && count($exifData['GPS']['GPSLongitude']) > 2) {
			$coords['lat'] = $this->getGps([$exifData['GPS']['GPSLatitude'][0], $exifData['GPS']['GPSLatitude'][1], $exifData['GPS']['GPSLatitude'][2]]);
			$coords['lng'] = $this->getGps([$exifData['GPS']['GPSLongitude'][0], $exifData['GPS']['GPSLongitude'][1], $exifData['GPS']['GPSLongitude'][2]]);
		} else {
			$coords = array('lat' => null, 'lng' => null);
		}

		return $coords;
	}

	/**
	 * Explode and return first parameter
	 * @param array  $data
	 * @param string $delimiter
	 * @return mixed|array
	 */
	public function ex($data, $delimiter = "/") {
		$exploded = explode($delimiter, $data);
		return $exploded[0];
	}

	/** Converts DMS ( Degrees / minutes / seconds )
	 * to decimal format longitude / latitude
	 *
	 * @param int|float $deg
	 * @param int|float $min
	 * @param int|float $sec
	 * @return mixed|float
	 */
	public function DMStoDEC($deg, $min, $sec) {
		return $deg + ((($min * 60) + ($sec)) / 3600);
	}


	/** Converts decimal longitude / latitude to DMS
	 *  ( Degrees / minutes / seconds )
	 *  This is the piece of code which may appear to
	 *  be inefficient, but to avoid issues with floating
	 *  point math we extract the integer part and the float
	 *  part by using a string function.
	 *
	 * @param int|float $dec
	 * @return array
	 */
	public function DECtoDMS($dec) {
		$vars = explode(".", $dec);
		$deg = $vars[0];
		$tempma = "0." . $vars[1];

		$tempma = $tempma * 3600;
		$min = floor($tempma / 60);
		$sec = $tempma - ($min * 60);

		return array("deg" => $deg, "min" => $min, "sec" => $sec);
	}

	/**
	 * @param array $exifCoord
	 * @return mixed|float
	 */
	public function getGps($exifCoord) {
		$degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
		$minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
		$seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

		//normalize
		$minutes += 60 * ($degrees - floor($degrees));
		$degrees = floor($degrees);

		$seconds += 60 * ($minutes - floor($minutes));
		$minutes = floor($minutes);

		//extra normalization, probably not necessary unless you get weird data
		if ($seconds >= 60) {
			$minutes += floor($seconds / 60.0);
			$seconds -= 60 * floor($seconds / 60.0);
		}

		if ($minutes >= 60) {
			$degrees += floor($minutes / 60.0);
			$minutes -= 60 * floor($minutes / 60.0);
		}

		return $this->DMStoDEC($degrees, $minutes, $seconds);
//		return array('degrees' => $degrees, 'minutes' => $minutes, 'seconds' => $seconds);
	}

	/**
	 * @param array $coordPart
	 * @return float|int
	 */
	public function gps2Num($coordPart) {
		$parts = explode('/', $coordPart);

		if (count($parts) <= 0)// jic
			return 0;
		if (count($parts) == 1) return $parts[0];

		return floatval($parts[0]) / floatval($parts[1]);
	}


}