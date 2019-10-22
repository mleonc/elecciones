<?php

namespace Indoor\Http\Exceptions;

class HttpRequestDataNotFound extends \Exception
{
	public function __construct()
    {
    	parent::__construct('', 404);
    }
}