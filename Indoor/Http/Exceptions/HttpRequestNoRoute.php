<?php

namespace Indoor\Http\Exceptions;

class HttpRequestNoRoute extends \Exception
{
	public function __construct()
    {
    	parent::__construct('', 404);
    }
}