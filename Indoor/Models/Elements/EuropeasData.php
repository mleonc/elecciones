<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

use Indoor\Traits\Renderizable;

class EuropeasData extends Data
{
	public function getHeadLine($year = '')
	{
		$headline = '';
		if (isset($this->place['name'])) {
			$headline = 'Resultados de ' . $this->place['name'] . ' en las elecciones europeas '. $year;
		}
		return $headline;
	}

	public function getComunidadPath($year = '')
	{
		if (empty($year)) {
			$year = $this->year;
		}
		if ($this->isTotal()) {
			if ($this->ccaa != '99') {
				return $this->json_basehost . $this->type . '/resultados/' . $year . '/' . $this->ccaa . '/p99.json';
			}
			return $this->json_basehost . $this->type . '/resultados/' . $year . '/pe99.json';
		}
		return Data::getComunidadPath($year);
	}

	public function setPlaceComunidad()
	{
		$path = $this->getComunidadPath($this->year);
		if (empty($this->comunidadData[$path])) {
			$this->comunidadData[$path] = $this->getComunidadData();
		}
		$code = 'code';
		if (isset($this->comunidadData[$path]['ccaa_code'])) {
			$code = 'ccaa_code';
		}
		if (isset($this->comunidadData[$path]['name']) && isset($this->comunidadData[$path]['slug']) && isset($this->comunidadData[$path][$code])) {
			$this->place['comunidad'] = [
				'name' => $this->comunidadData[$path]['name'],
				'slug' => $this->comunidadData[$path]['slug'],
				'code' => sprintf('%02d', $this->comunidadData[$path][$code]),
			];
		}
		return $this;
	}

	public function getProvinciaPath($year = '')
	{
		if ($this->isTotal()) {
			return '';
		}

		return Data::getProvinciaPath($year);
	}

	public function getMunicipioPath($year = '')
	{
		if ($this->isTotal()) {
			return '';
		}

		return Data::getMunicipioPath($year);
	}

	public function getBreadcrumb()
	{
		return '';
	}

	public function isTotal()
	{
		if (!empty($this->municipio) && $this->municipio == '99' && ($this->ccaa == '99' || preg_match('/[a-z]+/', $this->ccaa))) {
			return true;
		}

		return false;
	}

	public function showIndex()
	{
		$result = !$this->isTotal() && ((isset($this->datos_estado['ccaa'][$this->place['comunidad']['code']]['circunscripciones']) && sizeof($this->datos_estado['ccaa'][$this->place['comunidad']['code']]['circunscripciones']) == 1 && $this->isComunidad()) || (!$this->isComunidad()));
		return $result;
	}
}