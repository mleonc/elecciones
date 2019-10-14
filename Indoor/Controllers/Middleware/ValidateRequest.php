<?php

namespace Indoor\Controllers\Middleware;

use Indoor\Http\Request;

trait ValidateRequest
{
	public function validate(Request $request, $keys = [])
	{
		return true;
	}
}