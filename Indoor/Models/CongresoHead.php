<?php

namespace Indoor\Models;

class CongresoHead extends Head
{
	public function setTitle($year, $place, $portal)
	{
		if (!isset($place['name'])) {
			$place['name'] = '';
		}
		$this->title = 'Resultados Elecciones Generales en ' . $place['name'] . ' en ' . $year . ' | ' . $portal;
		return $this;
	}

	public function setDescription($year, $place)
	{
		$this->description = 'Consulte qui&eacute;n ha ganado y los resultados completos de las elecciones generales de '. $year .' en ' .$place['name']. ' al detalle.';
		if ($this->type == Metadata::_CONGRESO && $place['code'] != '99') {
			$this->description = 'Consulte al detalle los resultados de las elecciones generales de '. $year .' en ' . $place['name'] . ', ' . $place['comunidad']['name'] . '.';
		}
		if ($this->isLocalidad == true) {
			$this->description = 'Consulte qui&eacute;n ha ganado las Elecciones Generales de '. $year .' en ' . $place['name']. ', ' . $place['comunidad']['name']. '.';
		}
		return $this;
	}

	public function setKeywords($place)
	{
		$this->keywords = 'elecciones ' . $place['name'] . ', elecciones generales';

		if ($this->isLocalidad == true) {
			$this->keywords = 'elecciones ' . $place['name'] . ' '. $place['comunidad']['name']. ', elecciones generales';
		}
		return $this;
	}

	public function setRRSSData($year, $place)
	{
		$this->rrss['image'] = '';
		$this->rrss['name'] = '';
		if (isset($this->metadata['rrss'])) {
			$this->rrss = $this->metadata['rrss'];
		}
		$this->rrss['title'] = 'Resultados Elecciones Generales en '. $place['name'] . ' en ' . $year;
		$this->rrss['description'] = 'Los resultados de las elecciones generales de de 2019 en ' . $place['name']. ', en tiempo real y al detalle.';

		return $this;
	}
}