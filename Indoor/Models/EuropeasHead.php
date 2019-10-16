<?php

namespace Indoor\Models;

class EuropeasHead extends Head
{
	public function setTitle($year, $place, $portal)
	{
		$this->title = 'Resultados Europa elecciones europeas 2019';
		if ($place['code'] != '99') {
	        $this->title = 'Resultados Espa&ntilde;a elecciones europeas ' .$year;
			if ($place['code'] != 'es') {
		        $this->title = 'Resultados ' . $place['name'] . ' elecciones europeas 2019';
			}
		}
		$this->title .= ' | '. $portal;
		return $this;
	}

	public function setDescription($year, $place)
	{
		$this->description = 'Conoce los resultados de todos los pa&iacute;ses en las elecciones europeas de mayo de ' .$year .'.';
	    if ($place['code'] != '99') {
			$this->description = 'Conoce los resultados de ' .$place['name'] . ' en las elecciones europeas de mayo de ' .$year .': n&uacute;mero de votos y eurodiputados.';
	        if ($place['code'] != 'es') {
	            $this->description = 'Conoce los resultados de ' .$place['name'] . ' en las elecciones europeas del 26 de mayo de ' .$year .': n&uacute;mero de votos y porcentaje.';
	        }
	    }
		return $this;
	}

	public function setKeywords($year, $place)
	{
		$this->keywords = 'resultados europa elecciones europeas ' .$year;
		if ($place['code'] != '99') {
	        $this->keywords = 'resultados ' . $place['name'] . ' elecciones europeas ' . $year; 
		}
		return $this;
	}

	public function setRRSSData($year, $place, $portal)
	{
		$this->rrss['image'] = '';
		$this->rrss['name'] = '';
		if (isset($this->metadata['rrss'])) {
			$this->rrss = $this->metadata['rrss'];
		}

        $this->rrss['description'] = 'Conoce los resultados de todos los pa&iacute;ses en las elecciones europeas de mayo de ' .$year .'.';
        $this->rrss['title']= 'Resultados Europa elecciones europeas ' . $year . ' | '.$portal;
		if ($place['code'] != '99') {
           	$this->rrss['description'] = 'Conoce los resultados de ' .$place['name'] . ' en las elecciones europeas de mayo de ' . $year . ': n&uacute;mero de votos y eurodiputados.';
			$this->rrss['title']= 'Resultados '. $place['name'] . ' elecciones europeas ' .$year. ' | '.$portal;
			if ($place['code'] != 'es') {
	            $this->rrss['description'] = 'Conoce los resultados de ' .$place['name'] . ' en las elecciones europeas del 26 de mayo de ' . $year . ': n&uacute;mero de votos y porcentaje.';
			}
		}
		return $this;
	}
}