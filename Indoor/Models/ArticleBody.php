<?php

namespace Indoor\Models;

use Indoor\Models\Elements\Dfp;
use Indoor\Models\Elements\Omniture;
use Indoor\Traits\Renderizable;

class ArticleBody
{
	use Renderizable;
	
	public function __construct($params = [])
	{
		$this->filer 		= isset($params[Descriptor::_FILER_PATH]) ? $params[Descriptor::_FILER_PATH] : '';
		$this->portal 		= isset($params[Descriptor::_PORTAL]) ? $params[Descriptor::_PORTAL] : '';
		$this->url 			= isset($params[Descriptor::_URL]) ? $params[Descriptor::_URL] : '';
		$this->place 		= isset($params[Descriptor::_PLACE]) ? $params[Descriptor::_PLACE] : '';
		$this->format 		= isset($params[Descriptor::_FORMAT]) ? $params[Descriptor::_FORMAT] : '';
		$this->metadata 	= isset($params[Descriptor::_METADATA]) ? $params[Descriptor::_METADATA] : '';
		$this->data 		= isset($params[Descriptor::_DATA]) ? $params[Descriptor::_DATA] : '';
		$this->type 		= isset($params[Descriptor::_TYPE]) ? $params[Descriptor::_TYPE] : '';
		$this->subtype 		= isset($params[Descriptor::_SUBTYPE]) ? $params[Descriptor::_SUBTYPE] : '';
		$this->title 		= isset($params[Descriptor::_TITLE]) ? $params[Descriptor::_TITLE] : '';
		$this->environment 	= isset($params[Descriptor::_ENVIRONMENT]) ? $params[Descriptor::_ENVIRONMENT] : '';
		$this->year 		= isset($params[Descriptor::_YEAR]) ? $params[Descriptor::_YEAR] : '';

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
		}if (isset($params[Descriptor::_FORMAT])) {
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

		$this->onmiture = new Omniture([
			Descriptor::_FORMAT => $this->format,
			Descriptor::_URLPORTAL => isset($this->metadata[Descriptor::_URLPORTAL]) ? $this->metadata[Descriptor::_URLPORTAL] : '',
			Descriptor::_URL => $this->url,
			Descriptor::_PLACE => $this->place,
			Descriptor::_TYPE => $this->type,
			Descriptor::_SUBTYPE => $this->subtype,
			Descriptor::_TITLE => $this->title,
		]);

		$this->getElectionData();

		$this->setTemplate(dirname(__DIR__).'/templates/article/noticia.html');
	}

	public function getElectionData()
	{
		$device = $this->format;
		$actual = '';
		$past = '';
		$parent = '';
		$total = '';
	}

	public function getMainClass()
	{
		if (isset($this->metadata[Descriptor::_MAINCLASS])) {
			return $this->metadata[Descriptor::_MAINCLASS];
		}
		return '';
	}

	public function getTitle()
	{
		include(dirname(__DIR__).'/templates/article/title.html');
	}

	public function getArticle()
	{
		include(dirname(__DIR__).'/templates/article/article.html');
	}

	public function getKicker()
	{
		include(dirname(__DIR__).'/templates/article/kicker.html');
	}

	public function getHeadline()
	{
		include(dirname(__DIR__).'/templates/article/headline.html');
	}

	public function getByline()
	{
		include(dirname(__DIR__).'/templates/article/byline.html');
	}

	public function getHeadlineText()
	{
		return 'Resultados de las '.strtolower($this->metadata['seo_name']).' '.$this->year.' en '.$this->place['name'];
	}

	public function getHTMLTitle()
	{
		return rawurlencode('Resultados de las '.strtolower($this->metadata['seo_name']).' '.$this->year.' en '.$this->place['name']);
	}

	public function getPublishDate()
	{
		include(dirname(__DIR__).'/templates/article/publishdate.html');
	}

	public function getPublishDateText()
	{
		return $this->metadata['publishedAtText'];
	}

	public function getBarFooter()
	{
		include(dirname(__DIR__).'/templates/article/footer.html');
	}

	public function getFooter()
	{
		if (isset($this->metadata['static_path']) && isset($this->metadata['footer'])) {
			return $this->filer.$this->metadata['static_path'].$this->metadata['footer'];
		}
		return '';
	}

	public function getOmniture()
	{
		$this->onmiture->render();
	}
}