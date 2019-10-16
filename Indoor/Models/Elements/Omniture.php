<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;
use Indoor\Traits\Renderizable;

class Omniture
{
	use Renderizable;
	//$url, $ccaaSlug, $device='mobile', $cabeceraShort='', $title='', $model='', $name, $provincia

	public function __construct($params = [])
	{
		if (isset($params[Descriptor::_FORMAT])) {
			$this->format = $params[Descriptor::_FORMAT];
		}
		if (isset($params[Descriptor::_URLPORTAL])) {
			$this->url_portal = $params[Descriptor::_URLPORTAL];
		}
		if (isset($params[Descriptor::_URL])) {
			$this->url = $params[Descriptor::_URL];
		}
		if (isset($params[Descriptor::_PLACE])) {
			$this->place = $params[Descriptor::_PLACE];
		}
		if (isset($params[Descriptor::_TYPE])) {
			$this->type = $params[Descriptor::_TYPE];
		}
		if (isset($params[Descriptor::_TITLE])) {
			$this->title = $params[Descriptor::_TITLE];
		}
		$this->setTemplate(dirname(dirname(__DIR__)).'/templates/omniture.html');
	}
}