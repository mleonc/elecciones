<?php

namespace PHPUnit\TestCase;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class RequestTest extends TestCase
{
	public function testRequest()
    {
		$client = new Client([
			'base_uri' => 'http://localhost.indoor/'
		]);

		$response = $client->request('GET', 'indoor.php?q=elecciones-generales/resultados/congreso/2019/01/23/p050.html');
    }
}