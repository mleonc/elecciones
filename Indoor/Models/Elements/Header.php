<?php

namespace Indoor\Models\Elements;

use Indoor\Models\Descriptor;

class Header
{
	protected $template;

	public function getTemplate($format = 'mobile')
	{
		$template = dirname(dirname(__DIR__)).'/templates/header_mobile.html';
		if ($format == 'desktop') {
			$template = dirname(dirname(__DIR__)).'/templates/header_desktop.html';
		}

		return $template;
	}

	public function getAssets($params = [])
	{
		$assets = '';
		if (isset($params[Descriptor::_ASSETS]['general'])) {
			if (file_exists($params[Descriptor::_STATIC_PATH].$params[Descriptor::_ASSETS]['general'])) {
				$assets = $params[Descriptor::_STATIC_PATH].$params[Descriptor::_ASSETS]['general'];
			}
		}
		return $assets;
	}

	public function getPortal($params = [])
	{
		$portal = '';
		if (isset($params[Descriptor::_PORTAL])) {
			$portal = $params[Descriptor::_PORTAL];
		}
		return $portal;
	}

	public function getHeader($params = [], $format = 'mobile')
	{
		$header = '';
		if (isset($params[Descriptor::_HEADER][$format])) {
			if (file_exists($params[Descriptor::_STATIC_PATH].$params[Descriptor::_HEADER][$format])) {
				$header = $params[Descriptor::_STATIC_PATH].$params[Descriptor::_HEADER][$format];
			}
		}
		return $header;
	}

	public function getFiler($params = [])
	{
		$filer = '';
        if (isset($params[Descriptor::_FILER_PATH])) {
        	$filer = $params[Descriptor::_FILER_PATH];
        }
        return $filer;
	}

	public function getBreadcrumb($params = [], $format = 'mobile')
	{
		$breadcrumb = '';
		$breadcrumbChildren = '';
		$filer = self::getFiler($params);
        if (!isset($params[Descriptor::_BREADCRUMB]) || !isset($params[Descriptor::_BREADCRUMB][$format])) {
        	return ['', ''];
        }
        if (file_exists($filer.$params[Descriptor::_BREADCRUMB][$format])) {
    		$breadcrumb = $filer.$params[Descriptor::_BREADCRUMB][$format];
    	}
    	if (isset($params[Descriptor::_BREADCRUMB]['hijos']) && file_exists($filer.$params[Descriptor::_BREADCRUMB]['hijos'])) {
    		$breadcrumbChildren = $filer.$params[Descriptor::_BREADCRUMB]['hijos'];
    	}
        return [$breadcrumb, $breadcrumbChildren];
	}

	public function getSupermenu($params = [], $format = 'mobile')
	{
		$superMenu = '';
		if ($format == 'mobile' && file_exists($params[Descriptor::_STATIC_PATH].'/new-header/mobile/supermenu.php.inc')) {
			$superMenu = $params[Descriptor::_STATIC_PATH].'/new-header/mobile/supermenu.php.inc';
		}
		return $superMenu;
	}

	public function getYear($params = [])
	{
		$year = '';
		if (isset($params[Descriptor::_YEAR])) {
        	$year = $params[Descriptor::_YEAR];
        }
        return $year;
	}

	public function getTitle($params = [])
	{
		$year = self::getYear($params);
		return 'Resultados de las elecciones en ' . $year;
	}

	public function getNavigation($params = [])
	{
		return 'navegacion-principal-portada.php.inc';
	}

	static public function render($params = [], $format = 'mobile')
	{
		$template = self::getTemplate($format);
		$assets = self::getAssets($params);
		$portal = self::getPortal($params);
		$header = self::getHeader($params, $format);
		list($breadcrumb, $breadcrumbChildren) = self::getBreadcrumb($params, $format);
		$superMenu = self::getSupermenu($params, $format);
		$title = self::getTitle($params);
		$navigation = self::getNavigation($params);

		include($template);
	}
}