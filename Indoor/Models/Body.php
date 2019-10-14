<?php

namespace Indoor\Models;

use Indoor\Models\Elements\Dfp;
use Indoor\Traits\Renderizable;

class Body
{
	use Renderizable;
	
	public function __construct($params = [])
	{
		$this->portal 		= isset($params[Descriptor::_PORTAL]) ? $params[Descriptor::_PORTAL] : '';
		$this->place 		= isset($params[Descriptor::_PLACE]) ? $params[Descriptor::_PLACE] : '';
		$this->format 		= isset($params[Descriptor::_FORMAT]) ? $params[Descriptor::_FORMAT] : '';
		$this->metadata 	= isset($params[Descriptor::_METADATA]) ? $params[Descriptor::_METADATA] : '';
		$this->data 		= isset($params[Descriptor::_DATA]) ? $params[Descriptor::_DATA] : '';

		$this->dfp_include  = $this->metadata['dfp_mobile'];
		if ($this->format != 'mobile'){
			$this->dfp_include  = $this->metadata['dfp'];
		}

		$this->float = [['name'=> 'f']];
		$this->adsItems = [['name' => 'mega']];
		if ($this->format != 'mobile') {
			$this->adsItems = [
		    	['name' => 'skyRight'], 
		    	['name' => 'skyLeft'], 
		    	['name' => 'mega']
		    ];
		}

		$this->getElectionData();

		$this->setTemplate(dirname(__DIR__).'/templates/body.html');
	}

	public function getElectionData()
	{
		$device = $this->format;
		$actual = '';
		$past = '';
		$parent = '';
		$total = '';
	}
}