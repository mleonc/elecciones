<?php

namespace Indoor\Http;

use Indoor\Http\Exceptions\HttpRequestAttributeNotFound;
use Indoor\Http\Exceptions\HttpRequestInvalid;

class Request
{
	private $request;
	private $server;

	static public function capture()
	{
		if (!isset($_REQUEST['q']) || empty($_REQUEST['q'])) {
			throw new HttpRequestInvalid();
		}
		if (file_exists(dirname(dirname(__DIR__)).'/config.inc.php')) {
        	include dirname(dirname(__DIR__)).'/config.inc.php';
        }

        $vars = get_defined_vars();
		$request = new Request();
		foreach ($vars as $key => $value) {
			$request->$key = $value;
		}
        $request->request = $_REQUEST;
        $request->server = $_SERVER;

		return $request;
	}

	public function request()
	{
		return $this->request['q'];
	}

	public function all()
	{
		return $this->request;
	}

	public function get($value, $default = null)
	{
		if (isset($this->request[$value])) {
			return $this->request[$value];
		}

		if (isset($this->$value)) {
			return $this->$value;
		}

		if (null === $default) {
			throw new HttpRequestAttributeNotFound();
		}

		return $default;
	}

	public function getHost()
	{
		return $this->server['HTTP_HOST'];
	}

	public function getMethod()
	{
		return $this->server['REQUEST_METHOD'];
	}

	public function getUri()
	{
		return $this->server['REQUEST_URI'];
	}
}