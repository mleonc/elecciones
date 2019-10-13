<?php

namespace Indoor\Models\Elements;

use Indoor\Traits\Renderizable;

class Dfp
{
	protected $items;
	protected $section;

	const _CLASSES = [
        'sd' 		=> 'ue-l-common-page__sky ue-l-common-page__sky--right',
        'si' 		=> 'ue-l-common-page__sky ue-l-common-page__sky--left',
        'm' 		=> 'ue-l-common-page__row ue-l-common-page__row--no-gutter',
        'label' 	=> 'ue-c-ad--label',
        'sticky' 	=> 'ue-c-ad--sticky',
        'ads' 		=> 'ue-c-ad',
        'adsInner' 	=> 'ue-c-ad__inner'
    ];

	static public function render($items, $section) 
	{
	    $output = '';

	    foreach ($items as $key => $item) {
	        switch ($item['name']) {
	            case 'mega':
	                $position = 'm';
	                $class = (isset ($item['class'])) ? $item['class'] : self::_CLASSES['m'];
	                $needLabel = true;
	                $isSticky = false;
	                break;
	            case 'skyRight':
	                $position = 'sd';
	                $class = (isset ($item['class'])) ? $item['class'] : self::_CLASSES['sd'];
	                $needLabel = false;
	                $isSticky = false;
	                break;
	            case 'skyLeft':
	                $position = 'si';
	                $class = (isset ($item['class'])) ? $item['class'] : self::_CLASSES['si'];
	                $needLabel = false;
	                $isSticky = false;
	                break;
	            case 'roba':
	                $position = 'r';
	                $class = (isset ($item['class'])) ? $item['class'] : '';
	                $needLabel = true;
	                $isSticky = true;
	                break;
	            case 'f':
	                $position = 'f';
	                $class = (isset ($item['class'])) ? $item['class'] : '';
	                $needLabel = false;
	                $isSticky = false;
	                $onlyDfp = true;
	                break;
	            case 'float':
	                $position = $item['slot'];
	                $class = (isset ($item['class'])) ? $item['class'] : '';
	                $needLabel = false;
	                $isSticky = false;
	                break;
	            case 'html5':
	                $position = 'html5';
	                $class = (isset ($item['class'])) ? $item['class'] : '';
	                $needLabel = false;
	                $isSticky = false;
	                $onlyDfp = true;
	                break;
	            case 'native':
	                $position = $item['slot'];
	                $class = (isset ($item['class'])) ? $item['class'] : '';
	                $needLabel = false;
	                $isSticky = false;
	                $onlyDfp = true;
	                break;

	        }


	        $innerClass = self::_CLASSES['ads'];
	        if ($needLabel) {
	            $innerClass .= ' ' . self::_CLASSES['label'];
	        }
	        if ($isSticky) {
	            $innerClass .= ' ' . self::_CLASSES['sticky'];
	        }

	        if ($class) {
	            $output .= "<div class=\"$class\">";
	        }

	        $output .= "<div class=\"$innerClass\" aria-roledescription=\"Publicidad\" role=\"region\">
	        				<div class=\"".self::_CLASSES['adsInner']."\">
	            				<div id='div-gpt-ad-{$section}_p_$position' class=\"publicidad\">
	                				<script type='text/javascript'>
	                    				googletag.cmd.push(function () { googletag.display('div-gpt-ad-{$section}_p_$position'); });
	                				</script>
	            				</div>
	        				</div>
	    				</div>";

	        if ($class) {
	            $output .= "</div>";
	        }
	        
	    }

	    return $output;
	}
}