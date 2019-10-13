<?php

namespace Indoor\Controllers;

use Indoor\Controllers\Middleware\ValidateRequest;
use Indoor\Http\Request;
use Indoor\Models\Body;
use Indoor\Models\CongresoHead;
use Indoor\Models\Descriptor;
use Indoor\Models\Elements\Data;
use Indoor\Models\Metadata;

class CongresoController extends Controller
{
	use ValidateRequest;

	public function index(Request $request, $year, $ccaaCode, $provCode, $munCode = '') 
	{
		$electionType = 'elecciones-generales';
		$electionSubType = 'congreso';

		$metadata = new Metadata(
			$request->getHost(),
			$request->getUri(), 
			$request->get('path_datos'),
			$request->get('filer_path'), 
			$request->get('environment'),
			$year, 
			$electionType,
			$electionSubType);
		$metadata = $metadata->render();

		$format = isset($metadata[Descriptor::_FORMAT])?$metadata[Descriptor::_FORMAT]:'mobile';
		$data = new Data([
			Descriptor::_JSONBASEHOST => $this->request->get(Descriptor::_JSONBASEHOST),
			Descriptor::_TYPE => $electionType,
			Descriptor::_SUBTYPE => $electionSubType,
			Descriptor::_YEAR => $year,
			Descriptor::_PREVIOUSYEAR => isset($metadata[Descriptor::_PREVIOUSYEAR]) ? $metadata[Descriptor::_PREVIOUSYEAR]: '',
		]);
		$data->setComunidad($ccaaCode)->setProvincia($provCode)->setMunicipio($munCode);

		$place = $data->getPlace();
	
		$head = new CongresoHead([
		    'portal'    => $this->request->get('portal'),
		    'year'      => $year,
		    'metadata'  => $metadata,
		    'place'     => $place,
		    'isLocalidad'=> $data->isLocalidad(),
		]);
		$head->render();

		$body = new Body([
			'portal'    => $this->request->get('portal'),
		    'format'    => $format,
		    'year'      => $year,
		    'metadata'  => $metadata,
		    'place'     => $place
		]);
		$body->render();

	}
}