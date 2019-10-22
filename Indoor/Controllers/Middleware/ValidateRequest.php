<?php

namespace Indoor\Controllers\Middleware;

use Indoor\Http\Request;

trait ValidateRequest
{
	abstract public function validate();
}