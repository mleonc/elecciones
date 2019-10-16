<?php

namespace Indoor\Models;

use Indoor\Models\Elements\Jsonld;
use Indoor\Traits\Renderizable;

abstract class Head 
{
	use Renderizable;

	protected $title;
	protected $portal;
	protected $format;
	protected $theme;
	protected $year;
	protected $month;
	protected $place;
	protected $type;
	protected $environment;
	protected $metadata;
	protected $request;
	protected $description;
	protected $jsonLD;

	public function __construct($params = [])
	{
		$this->portal 		= isset($params[Descriptor::_PORTAL]) ? $params[Descriptor::_PORTAL] : '';
		$this->theme 		= isset($params[Descriptor::_THEME]) ? $params[Descriptor::_THEME] : '';
		$this->year 		= isset($params[Descriptor::_YEAR]) ? $params[Descriptor::_YEAR] : '';
		$this->month 		= isset($params[Descriptor::_MONTH]) ? $params[Descriptor::_MONTH] : '';
		$this->place 		= isset($params[Descriptor::_PLACE]) ? $params[Descriptor::_PLACE] : '';
		$this->type 		= isset($params[Descriptor::_TYPE]) ? $params[Descriptor::_TYPE] : '';
		$this->environment 	= isset($params[Descriptor::_ENVIRONMENT]) ? $params[Descriptor::_ENVIRONMENT] : '';
		$this->metadata 	= isset($params[Descriptor::_METADATA]) ? $params[Descriptor::_METADATA] : '';
		$this->request 		= isset($params[Descriptor::_REQUEST]) ? $params[Descriptor::_REQUEST] : '';
		$this->isLocalidad 	= isset($params[Descriptor::_ISLOCALIDAD]) ? $params[Descriptor::_ISLOCALIDAD] : '';
		$this->format 		= isset($this->metadata[Descriptor::_FORMAT]) ? $this->metadata[Descriptor::_FORMAT] : 'mobile';
		$this->setTemplate(dirname(__DIR__).'/templates/head.html');

		$this->setTitle($this->year, $this->place, $this->portal);
		$this->setDescription($this->year, $this->place);
		$this->setKeywords($this->year, $this->place);
		$this->setRRSSData($this->year, $this->place, $this->portal);
		$this->jsonLD = new Jsonld([
			Descriptor::_METADATA => $this->metadata, 
			Descriptor::_TITLE => $this->title, 
			Descriptor::_PLACE => $this->place, 
			Descriptor::_DESCRIPTION => $this->description,
		]);
	}

	abstract public function setTitle($year, $place, $portal);
	abstract public function setDescription($year, $place);
	abstract public function setKeywords($year, $place);
	abstract public function setRRSSData($year, $place, $portal);

	public function getTitle()
	{
		return $this->title;
	}
}