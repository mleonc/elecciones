<?php

namespace Indoor\Traits;

use Indoor\Models\Elements\Dfp;

trait Renderizable {
	private $template;
	
	public function setTemplate($value = '') {
		$this->template = $value;
		return $this;
	}
	public function getTemplate() {
		return $this->template;
	}
	public function render()
	{
		$content = '';
		if (file_exists($this->getTemplate())) {
			$content = include($this->getTemplate());
		}
		return $content;
	}
}