<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

use Indoor\Traits\Renderizable;

class AutonomicasData extends Data
{
	public function getComunidadPath($year = '')
	{
		if (empty($year)) {
			$year = $this->year;
		}
		$path = $this->json_basehost . $this->type . '/resultados/' . $year . '/' . $this->ccaa . '/99/p99.json';
		
		if (in_array($this->type, ['elecciones-baleares'])) {
			$path = $this->json_basehost . $this->type . '/resultados/' . (isset($this->subType)&&!empty($this->subType)?$this->subType. '/' : '') . $year . '/' . $this->ccaa . '/99.json';
		}

		return $path;
	}

	public function getProvinciaPath($year = '')
	{
		if (empty($year)) {
			$year = $this->year;
		}
		
		$path = parent::getProvinciaPath($year);

		if (in_array($this->type, ['elecciones-asturias'])) {
			$path = $this->json_basehost . $this->type . '/resultados/'. $year . '/' . $this->ccaa . '/99/p99.json';
		}
		if (in_array($this->type, ['elecciones-baleares'])) {
			$path = $this->json_basehost . $this->type . '/resultados/' . $year . '/' . $this->ccaa . '/99.json';
		}
		return $path;
	}

	public function showIndex()
	{
		$showIndex = parent::showIndex();

		if (in_array($this->type, ['elecciones-murcia'])) {
			$showIndex = true;
		}

		return $showIndex;
	}
}