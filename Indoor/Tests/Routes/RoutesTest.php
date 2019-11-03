<?php

namespace PHPUnit\TestCase;

use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
	const _CONTROLLERNAMESPACE = 'Indoor\\Controllers\\';

    public function testRoutesEnabled()
    {
        $expected_list = [
			'elecciones-generales' 		=> 'GeneralesController',
			'elecciones-europeas' 		=> 'EuropeasController',
			'elecciones-municipales' 	=> 'MunicipalesController',
			'elecciones-(.*)' 			=> 'AutonomicasController',
			'article-elecciones-generales' 	=> 'ArticleGeneralesController',
		];

		$this->assertEquals($expected_list, \Indoor\Http\Route::_list());
    }

    public function testControllers()
    {
		$controllers = \Indoor\Http\Route::_list();
		foreach ($controllers as $key => $controller) {
			$this->assertTrue(class_exists(self::_CONTROLLERNAMESPACE.$controller), 'Controlller '. $controller .' not found');
			$this->assertTrue(method_exists(self::_CONTROLLERNAMESPACE.$controller, 'index'));
		}
    }

    public function testHttpRequestNoRoute()
    {
		$request = $this->createMock(\Indoor\Http\Request::class);
		$request->method('request')->willReturn('elecciones-parlamento/resultados/2019/12/28/p99.html');
		$this->expectException(\Indoor\Http\Exceptions\HttpRequestNoRoute::class);
		\Indoor\Http\Response::response($request);
    }

    public function testHttpRequestNoRouteGenerales()
    {
		$request = $this->createMock(\Indoor\Http\Request::class);

		$request->method('request')->willReturn('elecciones-generales/resultados/2019/12/28/p99.html');
		$this->expectException(\Indoor\Http\Exceptions\HttpRequestNoRoute::class);
		\Indoor\Http\Response::response($request);
    }
}