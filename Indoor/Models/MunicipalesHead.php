<?php

namespace Indoor\Models;

class MunicipalesHead extends Head
{
	public function setTitle($year, $place, $portal)
	{
		$this->title = 'Resultados elecciones municipales ' .$year .' en '. $place['name'];
	}

	public function setDescription($year, $place)
	{
		$this->description = 'Consulta qui&eacute;n ha ganado las elecciones municipales del 26 de mayo de '. $year .' en '. $place['name']. ", ".$place['comunidad']['name'] . '. Utiliza nuestro buscador para ver los resultados al detalle.';
		return $this;
	}

	public function setKeywords($year, $place)
	{
		$this->keywords = 'elecciones municipales, elecciones ' .$place['name'] .', elecciones municipales ' . $year;
		return $this;
	}

	public function setRRSSData($year, $place, $portal)
	{
		$this->rrss['image'] = '';
		$this->rrss['name'] = '';
		if (isset($this->metadata['rrss'])) {
			$this->rrss = $this->metadata['rrss'];
		}

		$this->rrss['title'] = 'Resultados Elecciones Municipales '. $year .' en '. $place['name'] .' | '.$portal;
        $this->rrss['description'] = 'Consulta qui&eacute;n ha ganado las elecciones municipales del 26 de mayo de '. $year .' en '. $place['name'] .', ' . $place['name'] .'. Utiliza nuestro buscador para ver los resultados al detalle.';
		return $this;
	}
}