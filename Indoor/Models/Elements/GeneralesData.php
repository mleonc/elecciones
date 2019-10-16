<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

use Indoor\Traits\Renderizable;

class GeneralesData extends Data
{
	public function getTabs()
	{
		$subtype = '';
		if ($this->subType == 'congreso') {
			$subtype = 'senado';
		}
		if ($this->subType == 'senado') {
			$subtype = 'congreso';
		}
		$url  = $this->metadata['common']['election_url']. $this->type . '/resultados/'.$subtype. '/'.$this->year.'/'.$this->place['comunidad']['code'].'/';
		if ($this->isComunidad()) {
			$url .= 'p99.html';
		}
		if ($this->isProvincia()) {
			$url .= $this->place['provincia']['code'].'/p99.html';
		}
		if ($this->isLocalidad()) {
			$url .= $this->place['provincia']['code'].'/p'.(string)$this->place['municipio']['code'].'.html';
		}

		$path = dirname(dirname(__DIR__)).'/templates/tabs.html';
		if (file_exists(dirname(dirname(__DIR__)).'/templates/'.$this->type. '/'.$this->subType .'/tabs.html')) {
			$path = dirname(dirname(__DIR__)).'/templates/'.$this->type.'/'.$this->subType.'/tabs.html';
		}
		include($path);
	}

	public function getContent()
	{
		return '';
	}
}