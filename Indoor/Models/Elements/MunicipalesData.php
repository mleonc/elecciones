<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

use Indoor\Traits\Renderizable;

class MunicipalesData extends Data
{
	public function getComunidadPath($year = '')
	{
		if (empty($year)) {
			$year = $this->year;
		}
		return $this->json_basehost . $this->type . '/resultados/' . $year . '/' . $this->ccaa . '/p99.json';
	}

	public function getBreadcrumb()
	{
		return '';
	}
}