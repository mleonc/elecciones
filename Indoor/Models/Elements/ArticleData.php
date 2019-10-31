<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

use Indoor\Traits\Renderizable;

class ArticleData extends Data
{
	public function getContent()
	{
		return '';
	}

	public function getProvinciaPath($year = '')
	{
		if (!isset($this->provincia) || empty($this->provincia) || $this->provincia == '99') {
			return '';
		}
		if (empty($year)) {
			$year = $this->year;
		}
		return $this->json_basehost . $this->type . '/resultados/' . (isset($this->subType)&&!empty($this->subType)?$this->subType. '/' : '') . '/' . $year . '/' . $this->ccaa . '/' . $this->provincia . '/p99.json';
	}
}