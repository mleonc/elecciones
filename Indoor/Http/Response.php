<?php

namespace Indoor\Http;

class Response
{
	static public function response(Request $request)
	{
		list($vars, $class) = Route::route($request);

		$controller = new $class($request);

		if ($request->getMethod() === 'GET') {
     		return \call_user_func_array([$controller,'index'], $vars);
		}
	}
}