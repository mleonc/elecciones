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
	const _NOTICIA	 	= 'article';

	private $type;
	private $dataPath;
	private $filer;

	public function __construct($host, $uri, $filepath, $filer, $environment, $year, $electionType, $subtype = '')
	{
		$this->type = self::getType($electionType, $subtype);
		$this->dataPath = $filepath.'/metadata/';
		$this->host = $host;
		$this->uri = $uri;
		$this->filer = $filer;
		$this->year = $year;
		$this->environment = $environment;
	}

	static public function getType($electionType = '', $subtype = '')
	{
		if (empty($electionType)) {
			return '';
		}
		$type = $electionType;
		switch ($electionType) {
			case 'elecciones-municipales':
		    	$type = self::_MUNICIPALES;
				break;
			case 'elecciones-europeas':
		    	$type = self::_EUROPEAS;
		    	break;
		    case 'elecciones-generales':
				if ($subtype == self::_CONGRESO) {
					$type = self::_CONGRESO;
				}
				if ($subtype == self::_SENADO) {
					$type = self::_SENADO;
				}
				break;
			case 'article-elecciones-generales':
				$type = self::_NOTICIA;
				break;
			default: 
				$type = str_replace('elecciones-', '', $type);
				break;
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

	public function render($isArticle = false)
	{
		$metadata = [];
		if (isset($this->dataPath) && !empty($this->dataPath) && file_exists($this->dataPath.self::_FILENAME.(in_array($this->environment, ['sta', 'dev'])? '.'.$this->environment: ''))) {
			$content = file_get_contents($this->dataPath.self::_FILENAME.(in_array($this->environment, ['sta', 'dev'])? '.'.$this->environment: ''));
			$metadata = json_decode($content, true);
			if (json_last_error() != JSON_ERROR_NONE) {
				return [];
			}
		}
		$path = $this->dataPath.$this->type.'/'.$this->year.'/'.self::_FILENAME.(in_array($this->environment, ['sta', 'dev'])? '.'.$this->environment: '');

		if (file_exists($path)) {
			$content = file_get_contents($path);
			$aMetadata = json_decode($content, true);
			if (json_last_error() != JSON_ERROR_NONE) {
				return [];
			}
			$metadata = array_merge($metadata, $aMetadata);
		}

		if ($isArticle === true) {
			$path = $this->dataPath.$this->type.'/'.$this->year.'/'.'article-'.self::_FILENAME.(in_array($this->environment, ['sta', 'dev'])? '.'.$this->environment: '');

			if (file_exists($path)) {
				$content = file_get_contents($path);
				$aMetadata = json_decode($content, true);
				if (json_last_error() != JSON_ERROR_NONE) {
					return [];
				}
				$metadata = array_merge($metadata, $aMetadata);
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