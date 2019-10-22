<?php

namespace Indoor\Http;

use Indoor\Http\Exceptions\HttpRequestNoRoute;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

class Response
{
	static public function response(Request $request)
	{
		list($vars, $class) = Route::route($request);
		$controller = new $class($request);
        if (method_exists($controller, 'validate')) {
        	if (!\call_user_func_array([$controller,'validate'], $vars)) {
        		throw new HttpRequestNoRoute();
        	}
        }
		if ($request->getMethod() === 'GET') {
     		return \call_user_func_array([$controller,'index'], $vars);
		}
	}
}