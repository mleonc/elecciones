<?php

namespace Indoor\Models;

use Indoor\Traits\Renderizable;

class Metadata
{
	use Renderizable;
	
	const _FILENAME 	= 'metadata.json';
	const _AUTONOMICAS 	= 'autonomicas';
	const _MUNICIPALES 	= 'municipales';
	const _EUROPEAS 	= 'europeas';
	const _CONGRESO 	= 'congreso';
	const _SENADO	 	= 'senado';
	const _GENERALES 	= 'generales';

	private $type;
	private $dataPath;
	private $filer;

	public function __construct($host, $uri, $filepath, $filer, $environment, $year, $electionType, $subtype = '')
	{
		$this->type = $this->getType($electionType, $subtype);
		$this->dataPath = $filepath.'/metadata/'.$this->type.'/'.$year.'/'.self::_FILENAME.(in_array($environment, ['sta', 'dev'])? '.'.$environment: '');
		$this->host = $host;
		$this->uri = $uri;
		$this->filer = $filer;
		$this->year = $year;
	}

	public function getType($electionType = '', $subtype = '')
	{
		if (empty($electionType)) {
			return $this->type;
		}
		$type = self::_AUTONOMICAS;
		if ($electionType == 'elecciones-municipales') {
		    $type = self::_MUNICIPALES;   
		}
		if ($electionType == 'elecciones-europeas') {
		    $type = self::_EUROPEAS;
		}
		if ($electionType == 'elecciones-generales') {
			if ($subtype == self::_CONGRESO) {
				$type = self::_CONGRESO;
			}
			if ($subtype == self::_SENADO) {
				$type = self::_SENADO;
			}
		}
		return $type;
	}

	public function setDataPath($value = '')
	{
		$this->dataPath = $value;
		return $this;
	}

	public function getDataPath()
	{
		return $this->dataPath;
	}

	public function getFiler()
	{
		return $this->filer;
	}

	public function render()
	{
		$metadata = [];
		if (isset($this->dataPath) && !empty($this->dataPath) && is_file($this->dataPath)) {
			$content = file_get_contents($this->dataPath);
			$metadata = json_decode($content, true);
			if (json_last_error() != JSON_ERROR_NONE) {
				return [];
			}
		}
		if (!empty($this->host) && !empty($this->uri)) {
			$metadata['canUrl'] = 'https://'.$this->host . $this->uri;
		}
		$metadata[Descriptor::_FORMAT] = 'mobile';
        if (file_exists($this->filer.$metadata[Descriptor::_STATIC_PATH].$metadata['idusr']) && file_exists($this->filer.$metadata[Descriptor::_STATIC_PATH].$metadata['prefs'])) {
	        include_once ($this->filer.$metadata[Descriptor::_STATIC_PATH].$metadata['idusr']);
			include_once ($this->filer.$metadata[Descriptor::_STATIC_PATH].$metadata['prefs']);
			if (isset($deviceUE) && $deviceUE != 'm') {
			    $metadata[Descriptor::_FORMAT] = 'desktop';
			}
        }
        $metadata[Descriptor::_FILER_PATH] = $this->filer;
        $metadata[Descriptor::_YEAR] = $this->year;
		return $metadata;
	}
}