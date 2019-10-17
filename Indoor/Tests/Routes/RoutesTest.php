<?php

namespace PHPUnit\TestCase;

use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
	const _CONTROLLERNAMESPACE = 'Indoor\\Controllers\\';

    public function testRoutesEnabled()
    {
        $expected_list = [
			'elecciones-generales/resultados/congreso' => 'CongresoController',
		];

		$this->assertEquals($expected_list, \Indoor\Http\Route::_list());
    }

    public function testControllers()
    {
		$controllers = \Indoor\Http\Route::_list();
		foreach ($controllers as $key => $controller) {
			$this->assertTrue(class_exists(self::_CONTROLLERNAMESPACE.$controller), 'Controlller '. $controller .' not found');
		}
    }

    public function testHttpRequestNoRoute()
    {
		$request = $this->createMock(\Indoor\Http\Request::class);
		$request->method('request')->willReturn('elecciones-parlamento');

		$this->expectException(\Indoor\Http\Exceptions\HttpRequestNoRoute::class);

		\Indoor\Http\Route::route($request);
    }
}