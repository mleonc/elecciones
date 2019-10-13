<?php

namespace Indoor\Http;

use Indoor\Http\Exceptions\HttpRequestNoRoute;

class Route
{
	const _CONTROLLERNAMESPACE = 'Indoor\\Controllers\\';
	const _ROUTES = [
		'elecciones-generales/resultados/congreso' => 'CongresoController',
	];

	static function route(Request $request)
	{
		foreach (self::_ROUTES as $route => $controller) {
			if (preg_match('|^'.$route.'|', $request->request()) != false ) {
				$vars = explode('/', str_replace($route.'/', '', $request->request()));
				$vars = array_merge([$request], $vars);
				return [$vars, self::_CONTROLLERNAMESPACE . $controller];
			}
		}

		throw new HttpRequestNoRoute();
	}
}