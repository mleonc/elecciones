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

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-navarra/resultados/2019/13/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-navarra/resultados/2019/13/31/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-navarra/resultados/2019/13/31/p036.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/28/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/28/p001.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-castilla-y-leon/resultados/2019/08/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-castilla-y-leon/resultados/2019/08/09/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-castilla-y-leon/resultados/2019/08/09/p078.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-la-rioja/resultados/2019/16/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-la-rioja/resultados/2019/16/26/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-la-rioja/resultados/2019/16/26/p016.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-aragon/resultados/2019/02/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-aragon/resultados/2019/02/22/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-aragon/resultados/2019/02/22/p028.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-extremadura/resultados/2019/10/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-extremadura/resultados/2019/10/06/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-extremadura/resultados/2019/10/06/p001.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-castilla-la-mancha/resultados/2019/07/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-castilla-la-mancha/resultados/2019/07/13/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-castilla-la-mancha/resultados/2019/07/13/p001.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-murcia/resultados/2019/15/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-murcia/resultados/2019/15/30/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-murcia/resultados/2019/15/30/p001.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-baleares/resultados/2019/04/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-baleares/resultados/2019/04/07/p035.html');
        $this->assertEquals($response->getStatusCode(), 200);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-canarias/resultados/2019/05/99/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-canarias/resultados/2019/05/35/p99.html');
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-canarias/resultados/2019/05/35/p017.html');
        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function assertComunidad($body)
    {
        $this->assertProvincia($body);
    }

    public function assertProvincia($body)
    {
        $this->assertMunicipio($body);
        $this->assertTrue(strpos($body, 'js-ueSeatsBars') != false);
    }

    public function assertMunicipio($body)
    {
        $this->assertTrue(strpos($body, 'ue-c-elections-result-detail__kicker') != false);
        $this->assertTrue(strpos($body, 'ue-c-elections-result-detail__headline') != false);
        $this->assertTrue(strpos($body, 'js-ueElecctionsAutocomplete') != false);
        $this->assertTrue(strpos($body, 'js-ueTopBars') != false);
        $this->assertTrue(strpos($body, 'js-ueVowsBars') != false);
        $this->assertTrue(strpos($body, 'js-ueResultBars') != false);
        $this->assertTrue(strpos($body, 'js-ueDataBars') != false);
        $this->assertTrue(strpos($body, 'ue-c-elections-simple-widget__title') != false);
    }

    public function testAcceptanceAutonomicasComunidadMadrid()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/99/p99.html');
        $body = $response->getBody()->getContents();
        $this->assertComunidad($body);
        $this->assertTrue(strpos($body, 'ue-c-elections-result-detail-places') != false);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/28/p99.html');
        $body = $response->getBody()->getContents();
        $this->assertProvincia($body);
        $this->assertTrue(strpos($body, 'ue-c-elections-result-detail-places') != false);

        $response = $client->request('GET', 'http://miguelangel.leon.elmundo.dev.internet.int/elecciones-indoor/indoor.php?q=elecciones-madrid/resultados/2019/12/28/p001.html');
        $body = $response->getBody()->getContents();
        $this->assertMunicipio($body);
        $this->assertTrue(strpos($body, 'ue-c-elections-result-detail-places') != false);
    }
}