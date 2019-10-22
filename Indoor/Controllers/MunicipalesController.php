<?php

namespace Indoor\Controllers;

use Indoor\Controllers\Middleware\ValidateRequest;
use Indoor\Http\Request;
use Indoor\Models\Body;
use Indoor\Models\MunicipalesHead;
use Indoor\Models\Descriptor;
use Indoor\Models\Elements\MunicipalesData;
use Indoor\Models\Metadata;

use Indoor\Http\Exceptions\HttpRequestNoRoute;

class MunicipalesController extends Controller
{
	public function index(Request $request, $electionType, $year, $ccaaCode, $provCode, $munCode = '') 
	{
		if (!isset($munCode) || empty($munCode) || strstr($munCode, '99') != false) {
			throw new HttpRequestNoRoute();
		}
		$metadata = new Metadata(
			$request->getHost(),
			$request->getUri(), 
			$request->get('path_datos'),
			$request->get('filer_path'),
			$request->get('environment'),
			$year, 
			$electionType);
		$metadata = $metadata->render();

		$format = isset($metadata[Descriptor::_FORMAT])?$metadata[Descriptor::_FORMAT]:'mobile';
		$data = new MunicipalesData([
			Descriptor::_DATAPATH 		=> $request->get('path_datos'),
			Descriptor::_JSONBASEHOST 	=> $this->request->get(Descriptor::_JSONBASEHOST),
			Descriptor::_TYPE 			=> $electionType,
			Descriptor::_YEAR 			=> $year,
			Descriptor::_FORMAT 		=> $format,
			Descriptor::_PREVIOUSYEAR 	=> isset($metadata[Descriptor::_PREVIOUSYEAR]) ? $metadata[Descriptor::_PREVIOUSYEAR]: '',
			Descriptor::_METADATA 		=> $metadata,
			Descriptor::_STATEDATA 		=> $this->datosEstado,
		]);
		$data->setComunidad($ccaaCode)->setProvincia($provCode)->setMunicipio($munCode);

		$place = $data->getPlace();

		$head = new MunicipalesHead([
		    Descriptor::_PORTAL    	=> $request->get('portal'),
		    Descriptor::_YEAR      	=> $year,
		    Descriptor::_METADATA  	=> $metadata,
		    Descriptor::_PLACE    	=> $place,
		    Descriptor::_ISLOCALIDAD=> $data->isLocalidad(),
		]);
		$head->render();

		$body = new Body([
			Descriptor::_FILER_PATH => $request->get('filer_path'),
			Descriptor::_TYPE 		=> $electionType,
			Descriptor::_TITLE 		=> $head->getTitle(),
			Descriptor::_PORTAL		=> $request->get('portal'),
			Descriptor::_URL		=> $request->getHost().$request->getUri(),
			Descriptor::_ENVIRONMENT=> $request->get('environment'),
		    Descriptor::_FORMAT		=> $format,
		    Descriptor::_YEAR		=> $year,
		    Descriptor::_METADATA	=> $metadata,
		    Descriptor::_PLACE		=> $place,
		    Descriptor::_DATA		=> $data,
		]);
		$body->render();

	}
}