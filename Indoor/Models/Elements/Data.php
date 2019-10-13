<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

class Data
{
	private $ccaa;
	private $provincia;
	private $municipio;

	private $ccaaData;
	private $provinciaData;
	private $municipioData;

	private $json_basehost;
	private $type;
	private $subType;

	private $year;
	private $previous;

	public function __construct($params = [])
	{
		if (isset($params[Descriptor::_JSONBASEHOST])) {
			$this->json_basehost = $params[Descriptor::_JSONBASEHOST];
		}
		if (isset($params[Descriptor::_TYPE])) {
			$this->type = $params[Descriptor::_TYPE];
		}
		if (isset($params[Descriptor::_SUBTYPE])) {
			$this->subType = $params[Descriptor::_SUBTYPE];
		}
		if (isset($params[Descriptor::_YEAR])) {
			$this->year = $params[Descriptor::_YEAR];
		}
		if (isset($params[Descriptor::_PREVIOUSYEAR])) {
			$this->previous = $params[Descriptor::_PREVIOUSYEAR];
		}
	}

	public function setComunidad($value)
	{
		$this->ccaa = $value;
		return $this;
	}

	public function setProvincia($value)
	{
		$this->provincia = preg_replace('/p(.*)\.html/', '', $value);
		return $this;
	}

	public function setMunicipio($value)
	{
		$this->municipio = preg_replace('/p(.*)\.html/', '$1', $value);
		return $this;
	}

	public function isLocalidad()
	{
		if (!empty($this->municipio) && $this->municipio != 'p99') {
			return true;
		}

		return false;
	}

	public function getYear()
	{
		return $this->year;
	}

	public function getPrevious()
	{
		return $this->previous;
	}

	public function getComunidadPath($year = '')
	{
		if (empty($year)) {
			$year = $this->year;
		}
		return $this->json_basehost . $this->type . '/resultados/' . $this->subType . '/' . $year . '/' . $this->ccaa . '/99.json';
	}

	public function getComunidadData($year = '')
	{
		$path = $this->getComunidadPath($year);
		if (!empty($this->ccaaData[$path])) {
			return $this->ccaaData[$path];
		}
		$this->ccaaData[$path] = json_decode(file_get_contents($path), true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new HttpRequestDataNotFound();
		}
		return $this->ccaaData[$path];
	}

	public function getProvinciaPath($year = '')
	{
		if (empty($year)) {
			$year = $this->year;
		}
		return $this->json_basehost . $this->type . '/resultados/' . $this->subType . '/' . $year . '/' . $this->ccaa . '/' . $this->provincia . '/p99.json';
	}

	public function getProvinciaData($year = '')
	{
		$path = $this->getProvinciaPath($year);
		if (!empty($this->provinciaData[$path])) {
			return $this->provinciaData[$path];
		}
		$this->provinciaData[$path] = json_decode(file_get_contents($path), true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new HttpRequestDataNotFound();
		}
		return $this->provinciaData[$path];
	}

	public function getMunicipioPath($year = '')
	{
		if (!isset($this->municipio) || empty($this->municipio)) {
			return '';
		}
		if (empty($year)) {
			$year = $this->year;
		}
		return $this->json_basehost . $this->type . '/resultados/' . $this->subType . '/' . $year . '/' . $this->ccaa . '/' . $this->provincia . '/p'. $this->municipio .'.json';
	}

	public function getMunicipioData($year = '')
	{
		$path = $this->getMunicipioPath($year);
		if (empty($path)) {
			return [];
		}
		if (!empty($this->municipioData[$path])) {
			return $this->municipioData[$path];
		}
		$this->municipioData[$path] = json_decode(file_get_contents($path), true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new HttpRequestDataNotFound();
		}
		return $this->municipioData[$path];
	}

	public function setPlaceMunicipio()
	{
		$path = $this->getMunicipioPath($this->year);
		if (empty($this->municipioData[$path])) {
			$this->municipioData[$path] = $this->getMunicipioData();
		}
		if (isset($this->municipioData[$path]['name']) && isset($this->municipioData[$path]['slug']) && isset($this->municipioData[$path]['code'])) {
			$this->place['municipio'] = [
				'name' => $this->municipioData[$path]['name'],
				'slug' => $this->municipioData[$path]['slug'],
				'code' => $this->municipioData[$path]['code'],
			];
		}
		return $this;
	}

	public function setPlaceProvincia()
	{
		$path = $this->getProvinciaPath($this->year);
		if (empty($this->provinciaData[$path])) {
			$this->provinciaData[$path] = $this->getProvinciaData();
		}
		if (isset($this->provinciaData[$path]['name']) && isset($this->provinciaData[$path]['slug']) && isset($this->provinciaData[$path]['code'])) {
			$this->place['provincia'] = [
				'name' => $this->provinciaData[$path]['name'],
				'slug' => $this->provinciaData[$path]['slug'],
				'code' => $this->provinciaData[$path]['code'],
			];
		}
		return $this;
	}

	public function setPlaceComunidad()
	{
		$path = $this->getComunidadPath($this->year);
		if (empty($this->comunidadData[$path])) {
			$this->comunidadData[$path] = $this->getComunidadData();
		}
		if (isset($this->comunidadData[$path]['name']) && isset($this->comunidadData[$path]['slug']) && isset($this->comunidadData[$path]['code'])) {
			$this->place['comunidad'] = [
				'name' => $this->comunidadData[$path]['name'],
				'slug' => $this->comunidadData[$path]['slug'],
				'code' => $this->comunidadData[$path]['ccaa_code'],
			];
		}
		return $this;
	}

	public function getPlaceComunidad()
	{
		if (!isset($this->place['comunidad'])) {
			$this->setPlaceComunidad();
		}
		return $this->place['comunidad'];
	}

	public function getPlaceProvincia()
	{
		if (!isset($this->place['provincia'])) {
			$this->setPlaceProvincia();
		}
		return $this->place['provincia'];
	}

	public function getPlaceMunicipio()
	{
		if (!isset($this->place['municipio'])) {
			$this->setPlaceMunicipio();
		}
		if (isset($this->place['municipio'])) {
			return $this->place['municipio'];
		}
		return '';
	}

	public function getPlace()
	{
		$this->getPlaceMunicipio();
		$this->getPlaceProvincia();
		$this->getPlaceComunidad();
		if (isset($this->place['comunidad'])) {
			$this->place['name'] = $this->place['comunidad']['name'];
			$this->place['slug'] = $this->place['comunidad']['slug'];
			$this->place['code'] = $this->place['comunidad']['code'];
		}
		if (isset($this->place['provincia'])) {
			$this->place['name'] = $this->place['provincia']['name'];
			$this->place['slug'] = $this->place['provincia']['slug'];
			$this->place['code'] = $this->place['provincia']['code'];
		}
		if (isset($this->place['municipio'])) {
			$this->place['name'] = $this->place['municipio']['name'];
			$this->place['slug'] = $this->place['municipio']['slug'];
			$this->place['code'] = $this->place['municipio']['code'];
		}
		return $this->place;
	}
}