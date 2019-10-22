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
		return $this->json_basehost . $this->type . '/resultados/' . $year . '/' . $this->ccaa . '/99/p99.json';
	}

	public function getProvinciaPath($year = '')
	{
		if (!isset($this->provincia) || empty($this->provincia) || $this->provincia == '99') {
			return '';
		}
		if (empty($year)) {
			$year = $this->year;
		}

		var_dump($this);
		die;

		$provincia = $this->provincia;
		if (count($this->datos_estado['ccaa'][$this->ccaa]['circunscripciones']) <= 1) {
			$provincia = '99';
		}

		return $this->json_basehost . $this->type . '/resultados/' . (isset($this->subType)&&!empty($this->subType)?$this->subType. '/' : '') . '/' . $year . '/' . $this->ccaa . '/' . $provincia . '/p99.json';
	}
}