<?php

namespace Indoor\Http;

use Indoor\Http\Exceptions\HttpRequestNoRoute;

class Route
{
	const _CONTROLLERNAMESPACE = 'Indoor\\Controllers\\';
	const _ROUTES = [
		'elecciones-generales' 		=> 'GeneralesController',
		'elecciones-europeas' 		=> 'EuropeasController',
		'elecciones-municipales' 	=> 'MunicipalesController',
		'elecciones-(.*)' 			=> 'AutonomicasController',
		'article-elecciones-generales' 	=> 'ArticleGeneralesController',
	];

	static function route(Request $request)
	{
		$rRequest = explode('/', $request->request());
		if (isset($rRequest[0])) {
			foreach (self::_ROUTES as $route => $controller) {
				if (preg_match('|^'.$route.'|', $rRequest[0]) != false ) {
					$route = preg_replace('|'.$route.'/(.*)$|', '$1', $rRequest[0]);
					$vars = explode('/', str_replace($route.'/resultados/', '', $request->request()));
					$vars = array_merge([$request, $route], $vars);
					return [$vars, self::_CONTROLLERNAMESPACE . $controller];
				}
			}
		}

		throw new HttpRequestNoRoute();
	}

	static function _list()
	{
		return self::_ROUTES;
	}
}