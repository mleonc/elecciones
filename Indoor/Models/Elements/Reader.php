<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Metadata;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

class Reader
{
	static function read($path, $type)
	{
		if (empty($path)) {
			return [];
		}
		$conv = true;
		
		$data = file_get_contents($path);
		if (!$data || empty($data)) {
			throw new HttpRequestDataNotFound();
		}
		$cData = iconv("UTF-8", "ISO-8859-1//IGNORE", $data);
		$jData = json_decode($cData, true);
		if (empty($jData)) {
			$jData = json_decode($data, true);
		}
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new HttpRequestDataNotFound();
		}
		return $jData;
	}
}