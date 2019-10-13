<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Traits\Renderizable;

class Jsonld 
{
	use Renderizable;

	protected $title;
	protected $place;
	protected $description;
	protected $metadata;

	public function __construct($params = [])
	{
		$this->metadata 	= isset($params[Descriptor::_METADATA]) ? $params[Descriptor::_METADATA] : '';
		$this->title 		= isset($params[Descriptor::_TITLE]) ? $params[Descriptor::_TITLE] : '';
		$this->place 		= isset($params[Descriptor::_PLACE]) ? $params[Descriptor::_PLACE] : '';
		$this->description 	= isset($params[Descriptor::_DESCRIPTION]) ? $params[Descriptor::_DESCRIPTION] : '';
		$this->setSEOData();
		$this->setTemplate(dirname(__DIR__).'/templates/jsonld.html');
	}

	public function setSEOData()
	{
		$this->seo['data'] = [
			'name' => $this->place['comunidad']['name'],
		];
		return $this;
	}

	public function render()
	{
		$html = '';
		if (file_exists($this->getTemplate())) {
			$html = include($this->getTemplate());
		}
		return $html;
	}
}