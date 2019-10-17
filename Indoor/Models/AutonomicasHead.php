<?php

namespace Indoor\Models;

class AutonomicasHead extends Head
{
	public function setTitle($year, $place, $portal)
	{
		$this->title = 'Resultados de las Elecciones auton&oacute;micas '.$year.' en '.$place['name'];
		if (isset($place['provincia']['name'])) {
    		$this->title = 'Resultados elecciones auton&oacute;micas '.$year.' en '.$place['name'].', '.$place['comunidad']['name'];
		}
		if (isset($place['municipio']['name'])) {
    		$this->title = 'Resultados de '.$place['name'].' en las Elecciones ' . $year . ' al Parlamento de '.$place['comunidad']['name'];
		}
	}

	public function setDescription($year, $place)
	{
		$this->description = 'Consulte qui&eacute;n ha ganado y conozca al detalle los resultados de las elecciones auton&oacute;micas de '. $year . ' en ' .$place['name'] .'.';
		if (isset($place['provincia']['name'])) {
    		$this->description = 'Consulte al detalle los resultados de las elecciones auton&oacute;micas de '. $year.' en la provincia de ' .$place['name'].', '.$place['comunidad']['name'];
		}
		if (isset($place['municipio']['name'])) {
    		$this->description = 'Consulte al detalle los resultados de las elecciones auton&oacute;micas de ' .$year . ' en el municipio de ' .$place['name'] .', '.$place['comunidad']['name'] . '. Sepa cu&aacute;ntos votos ha logrado cada partido.';
		}
		return $this;
	}

	public function setKeywords($year, $place)
	{
		$this->keywords = 'resultados elecciones auton&oacute;micas '. $year .' en ' .$place['name'];
		return $this;
	}

	public function setRRSSData($year, $place, $portal)
	{
		$this->rrss['image'] = '';
		$this->rrss['name'] = '';
		if (isset($this->metadata['rrss'])) {
			$this->rrss = $this->metadata['rrss'];
		}

        $this->rrss['description'] = 'Consulte qui&eacute;n ha ganado y conozca al detalle los resultados de las elecciones auton&oacute;micas de '. $year . ' en ' . $place['name']. ' , en tiempo real y al detalle.';
        $this->rrss['title']= 'Resultados de las Elecciones auton&oacute;micas '.$year.' en ' .$place['name'];
		if (isset($place['provincia']['name'])) {
			$this->rrss['description'] = 'Consulte al detalle los resultados de las elecciones auton&oacute;micas de ' .$year. ' en la provincia de ' . $place['provincia']['name'].', ' .  $place['comunidad']['name'];
        	$this->rrss['title']= 'Resultados Elecciones auton&oacute;micas '. $year .' en la provincia de '. $place['provincia']['name'] . ', ' . $place['comunidad']['name'];
		}
		if (isset($place['municipio']['name'])) {
    		$this->rrss['description'] = 'Consulte al detalle los resultados de las elecciones auton&oacute;micas de ' .$year . ' en el municipio de ' . $place['name'] . ', '.  $place['comunidad']['name'].'. Vea cu&aacute;ntos votos ha logrado cada partido y c&oacute;mo queda compuesta la C&acute;mara.';
        	$this->rrss['title']= 'Resultados de ' . $place['name'] .' en las Elecciones al Parlamento de '. $place['comunidad']['name'] . ' ' . $year;
		}
		return $this;
	}
}