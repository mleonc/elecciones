<?php

namespace Indoor\Controllers;

use Indoor\Controllers\Middleware\ValidateRequest;
use Indoor\Http\Request;
use Indoor\Models\Body;
use Indoor\Models\CongresoHead;
use Indoor\Models\Descriptor;
use Indoor\Models\Elements\GeneralesData;
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
		$data = new GeneralesData([
			Descriptor::_DATAPATH => $request->get('path_datos'),
			Descriptor::_JSONBASEHOST => $this->request->get(Descriptor::_JSONBASEHOST),
			Descriptor::_TYPE => $electionType,
			Descriptor::_SUBTYPE => $electionSubType,
			Descriptor::_YEAR => $year,
			Descriptor::_FORMAT => $format,
			Descriptor::_PREVIOUSYEAR => isset($metadata[Descriptor::_PREVIOUSYEAR]) ? $metadata[Descriptor::_PREVIOUSYEAR]: '',
			Descriptor::_METADATA => $metadata,
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
		    'place'     => $place,
		    'data'		=> $data,
		]);
		$body->render();

	}
}