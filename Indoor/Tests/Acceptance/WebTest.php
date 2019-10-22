<?php

namespace PHPUnit\TestCase;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class WebTest extends TestCase
{
	const _CONTROLLERNAMESPACE = 'Indoor\\Controllers\\';

    public function testNoRouteExists()
    {
        $client = new Client();
        try {
        	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-parlamento/resultados/2019/12/28/p99.html');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
        	$this->assertEquals($e->getCode(), 404);
        }
    	$this->assertTrue(true);
    }

    public function testRouteGenerales()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-generales/resultados/congreso/2019/01/23/p050.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-generales/resultados/congreso/2019/01/23/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-generales/resultados/congreso/2019/01/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-generales/resultados/senado/2019/01/23/p050.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-generales/resultados/senado/2019/01/23/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-generales/resultados/senado/2019/01/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    }

    public function testRouteEuropeas()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-europeas/resultados/2019/01/23/p050.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-europeas/resultados/2019/01/23/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-europeas/resultados/2019/01/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-europeas/resultados/2019/99/99/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-europeas/resultados/2019/es/99/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    	$response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-europeas/resultados/2019/de/99/p99.html');
    	$this->assertEquals($response->getStatusCode(), 200);
    }

    public function testRouteMunicipales()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-municipales/resultados/2019/01/23/p050.html');
        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function testRouteAutonomicas()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-asturias/resultados/2019/03/33/p001.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-asturias/resultados/2019/03/33/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-asturias/resultados/2019/03/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-cantabria/resultados/2019/06/39/p001.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-cantabria/resultados/2019/06/39/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-cantabria/resultados/2019/06/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);


        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/28/p079.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/28/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
    }
}