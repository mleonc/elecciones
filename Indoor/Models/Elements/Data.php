<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Models\Elements\Reader;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

use Indoor\Traits\Renderizable;

class Data
{
	use Renderizable;

	protected $ccaa;
	protected $provincia;
	protected $municipio;

	protected $ccaaData;
	protected $provinciaData;
	protected $municipioData;

	protected $json_basehost;
	protected $type;
	protected $subType;

	protected $year;
	protected $previous;

	protected $metadata;
	protected $format;
	protected $data_path;
	protected $datos_estado;

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
		if (isset($params[Descriptor::_FORMAT])) {
			$this->format = $params[Descriptor::_FORMAT];
		}
		if (isset($params[Descriptor::_METADATA])) {
			$this->metadata = $params[Descriptor::_METADATA];
		}
		if (isset($params[Descriptor::_DATAPATH])) {
			$this->data_path = $params[Descriptor::_DATAPATH];
		}
		if (isset($params[Descriptor::_STATEDATA])) {
			$this->datos_estado = $params[Descriptor::_STATEDATA];
		}
		$this->place = [];
		$this->setTemplate(dirname(dirname(__DIR__)).'/templates/data.html');
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

	public function isComunidad()
	{
		return !$this->isLocalidad() && !$this->isProvincia();
	}

	public function isLocalidad()
	{
		if (!empty($this->municipio) && $this->municipio != '99') {
			return true;
		}

		return false;
	}

	public function isProvincia()
	{
		if (!empty($this->municipio) && $this->municipio == '99') {
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
		return $this->json_basehost . $this->type . '/resultados/' . $this->subType . '/' . $year . '/' . $this->ccaa . '/p99.json';
	}

	public function getComunidadData($year = '')
	{
		$path = $this->getComunidadPath($year);
		if (!empty($this->ccaaData[$path])) {
			return $this->ccaaData[$path];
		}
		$this->ccaaData[$path] = Reader::read($path, $this->type);
		
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
		$this->provinciaData[$path] = Reader::read($path, $this->type);
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
		$this->municipioData[$path] = Reader::read($path, $this->type);
		return $this->municipioData[$path];
	}

	public function setPlaceMunicipio()
	{
		$path = $this->getMunicipioPath($this->year);
		if (!isset($this->municipioData[$path]) || empty($this->municipioData[$path])) {
			$this->municipioData[$path] = $this->getMunicipioData();
		}
		if (isset($this->municipioData[$path]['name']) && isset($this->municipioData[$path]['slug']) && isset($this->municipioData[$path]['code'])) {
			$this->place['municipio'] = [
				'name' => $this->municipioData[$path]['name'],
				'slug' => $this->municipioData[$path]['slug'],
				'code' => sprintf('%03d', $this->municipioData[$path]['code']),
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
				'code' => sprintf('%02d', $this->provinciaData[$path]['code']),
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
		if (isset($this->comunidadData[$path]['name']) && isset($this->comunidadData[$path]['slug']) && isset($this->comunidadData[$path]['ccaa_code'])) {
			$this->place['comunidad'] = [
				'name' => $this->comunidadData[$path]['name'],
				'slug' => $this->comunidadData[$path]['slug'],
				'code' => sprintf('%02d', $this->comunidadData[$path]['ccaa_code']),
			];
		}
		return $this;
	}

	public function getPlaceComunidad()
	{
		if (!isset($this->place['comunidad'])) {
			$this->setPlaceComunidad();
		}
		return $this->place;
	}

	public function getPlaceProvincia()
	{
		if (!isset($this->place['provincia'])) {
			$this->setPlaceProvincia();
		}
		return $this->place;
	}

	public function getPlaceMunicipio()
	{
		if (!isset($this->place['municipio'])) {
			$this->setPlaceMunicipio();
		}
		return $this->place;
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

	public function getData($year = '')
	{
		$path = $this->getComunidadPath($year);
		if ($this->isLocalidad()) {
			$path = $this->getMunicipioPath($year);
		}
		if ($this->isProvincia()) {
			$path = $this->getProvinciaPath($year);
		}
		return $path;
	}

	public function getParentData()
	{
		$path = $this->getComunidadPath();
		if ($this->isLocalidad()) {
			$path = $this->getProvinciaPath();
		}
		return $path;
	}

	public function getActualData()
	{
		return $this->getData();
	}

	public function getPastData()
	{
		return $this->getData($this->previous);
	}

	public function getDataAttributes()
	{
		$attributes = [
			'actual' 	=> 'data-json-actual="'.$this->getActualData().'"',
			'past' 		=> 'data-json-past="'.$this->getPastData().'"',
			'total'		=> 'data-json-total="'.$this->getComunidadPath().'"',
		];
		if ($this->isLocalidad() || $this->isProvincia()) {
			$attributes['parent'] = 'data-json-parent="'.$this->getParentData().'"';
		}
		return implode(' ', $attributes);
	}

	public function getKicker()
	{
		$kicker = $this->year;
		if (isset($this->metadata['seo_name'])) {
			$kicker = $this->metadata['seo_name'].' '.$kicker;
		}
		return $kicker;
	}

	public function getHeadLine($year = '')
	{
		$headline = '';
		if (isset($this->place['name'])) {
			$headline = 'Resultados de las elecciones en ';
			if ($this->isProvincia()) {
				$headline = 'Resultados de las elecciones en la provincia de ';
			}
			$headline .= $this->place['name'];
		}
		return $headline;
	}

	public function getComunidadesBreadcrumb()
	{
		$provincias = $this->data_path.'index/'.$this->place['comunidad']['code']. '/provincias.html';
		$classItem = 'ue-c-elections-result-detail__tags-item';
        $classList = 'ue-c-elections-result-detail__tags';
		$search = ['$path', '$class_list', '$class_item'];
		if (file_exists($provincias)) {
			$path  = $this->metadata['common']['election_url']. $this->type . '/resultados/'.$this->subType. '/'.$this->year;
			$replace = [$path, $classList, $classItem];
			$content = str_replace($search, $replace, iconv("UTF-8", "ISO-8859-1//IGNORE", file_get_contents($provincias)));
			return $content;
		}
		return '';
	}

	public function getBreadcrumb()
	{
		if ($this->isComunidad()) {
			return $this->getComunidadesBreadcrumb();
		}

		include (dirname(dirname(__DIR__)).'/templates/breadcrumb.html');
	}

	public function getFinder()
	{
		$path = dirname(dirname(__DIR__)).'/templates/finder.html';
		if (file_exists(dirname(dirname(__DIR__)).'/templates/'.$this->type.'/finder.html')) {
			$path = dirname(dirname(__DIR__)).'/templates/'.$this->type.'/finder.html';
		}
		include($path);
	}

	public function getTabs()
	{
		return '';
	}

	public function getContent()
	{
		$path = dirname(dirname(__DIR__)).'/templates/content.html';
		if (file_exists(dirname(dirname(__DIR__)).'/templates/'.$this->type.'/content.html')) {
			$path = dirname(dirname(__DIR__)).'/templates/'.$this->type.'/content.html';
		}
		include($path);
	}

	public function getActualLabel()
	{
		if (isset($this->metadata['actual_data_slug'])) {
			return $this->metadata['actual_data_slug'];
		}
		return $this->year;
	}

	public function getPastLabel()
	{
		if (isset($this->metadata['past_data_slug'])) {
			return $this->metadata['past_data_slug'];
		}
		return $this->previous;
	}

	public function getPublicidad()
	{
		return [
			['name' => 'roba'],
		];
	}

	public function showIndex()
	{
		$result = (isset($this->datos_estado['ccaa'][$this->place['comunidad']['code']]['circunscripciones']) && sizeof($this->datos_estado['ccaa'][$this->place['comunidad']['code']]['circunscripciones']) == 1 && $this->isComunidad()) || (!$this->isComunidad());
		return $result;
	}

	public function getIndex()
	{
		$template = dirname(dirname(__DIR__)).'/templates/index.html';

		$content = '';
		$classItem = '';
        $classList = 'ue-c-elections-result-detail-places';
		$index = $this->data_path.'index/'.$this->place['comunidad']['code']. '/indice_'.$this->place['provincia']['code'].'.html';
		$search = ['$path', '$class_list', '$class_item'];
		$title = '';
		if (file_exists($index)) {
			$title = 'Municipios de la comunidad aut&oacute;noma de ' .$this->place['comunidad']['name'];
			if (isset($this->datos_estado['ccaa'][$this->place['comunidad']['code']]['circunscripciones']) && sizeof($this->datos_estado['ccaa'][$this->place['comunidad']['code']]['circunscripciones']) > 1 && $this->isComunidad()) {
				$title = 'Municipios de la provincia de ' .$this->place['provincia']['name'];
			}
			$path  = $this->metadata['common']['election_url']. $this->type . '/resultados/'.$this->subType. '/'.$this->year;
			$replace = [$path, $classList, $classItem];
			$content = str_replace($search, $replace, iconv("UTF-8", "ISO-8859-1//IGNORE", file_get_contents($index)));
		}
		include($template);
	}
}