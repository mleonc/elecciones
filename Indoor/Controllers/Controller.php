<?php

namespace Indoor\Controllers;

use Indoor\Http\Request;
use Indoor\Http\Exceptions\HttpRequestInvalid;

abstract class Controller
{
	protected $request;
	protected $datosEstado;

	const _CIRCUNSCRIPCIONES = 'circunscripciones.json';
	const _ESTADO = 'datos_estado.json';

	public function __construct(Request $request)
    {
    	$validation = true;
        if (method_exists($this, 'validate')) {
        	if (!$this->validate($request)) {
        		throw new HttpRequestInvalid("Error Processing Request", 1);
        	}
        }
        $this->request = $request;
        $path_datos = $this->request->get('path_datos');
        $this->datosEstado = json_decode(file_get_contents($path_datos.self::_ESTADO), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpRequestInvalid(self::_ESTADO . ' invalid json file', 1);
        }
        //$this->inicializate();
    }

    protected function inicializate()
    {
    	$path_datos = $this->request->get('path_datos');
        if (!file_exists($path_datos.self::_CIRCUNSCRIPCIONES)) {
        	throw new HttpRequestInvalid(self::_CIRCUNSCRIPCIONES . ' not found', 1);
        }
        if (!file_exists($path_datos.self::_ESTADO)) {
        	throw new HttpRequestInvalid(self::_ESTADO . ' not found', 1);
        }
    	$this->place = [];
    	$ccaaCode = $this->request->get('ccaacode');
    	$circunscripcionCode = $this->request->get('circode');
		$cData = json_decode(file_get_contents($path_datos.self::_CIRCUNSCRIPCIONES), true);
		if (json_last_error() !== JSON_ERROR_NONE) {
        	throw new HttpRequestInvalid(self::_CIRCUNSCRIPCIONES . ' invalid json file', 1);
        }
		if ($ccaaCode != '99' && isset($cData[$ccaaCode])) {
		    if ($circunscripcionCode != '99' && isset($cData[$ccaaCode]['circunscripciones'][$circunscripcionCode])) {
		        $this->place['prov'] = $cData[$ccaaCode]['circunscripciones'][$circunscripcionCode];
		        if (isset($this->place['prov']['name'])) {
		        	$this->place['prov']['name'] = iconv( "UTF-8", "ISO-8859-1//IGNORE", $this->place['prov']['name']);
		        }
		    }
		    $this->place['ccaa'] = $cData[$ccaaCode];
		    if (isset($this->place['ccaa']['name'])) {
		        	$this->place['ccaa']['name'] = iconv( "UTF-8", "ISO-8859-1//IGNORE", $this->place['ccaa']['name']);
		        }
		}
		if (empty($this->place)) {
			throw new HttpRequestInvalid('Place not found', 1);
		}
		$this->datosEstado = json_decode(file_get_contents($path_datos.self::_ESTADO), true);

		if (json_last_error() !== JSON_ERROR_NONE) {
        	throw new HttpRequestInvalid(self::_ESTADO . ' invalid json file', 1);
        }
    }

    protected function getEstadoData()
    {
    	return $this->datosEstado;
    }
}