<?php

namespace Indoor\Models\Elements;

use Indoor\Traits\Renderizable;

class Dfp
{
	protected $items;
	protected $section;

	const _BLOCK 	= 'block';
	const _TYPE 	= 'type';
	const _DFPTYPE 	= 'dfptype';
	const _ARTICLE 	= 'article';
	const _STATIC 	= 'static';

	const _DFPARTICLE = 'n';
	const _DFPOTHER = 'p';

	const _CLASSES = [
		'static' => [
	        'sd' 		=> 'ue-l-common-page__sky ue-l-common-page__sky--right',
	        'si' 		=> 'ue-l-common-page__sky ue-l-common-page__sky--left',
	        'm' 		=> 'ue-l-common-page__row ue-l-common-page__row--no-gutter',
		],
		'article' => [
	        'sd' 		=> 'ue-l-article__sky ue-l-article__sky--right',
	        'si' 		=> 'ue-l-article__sky ue-l-article__sky--left',
	        'm' 		=> 'ue-l-article__mega',
		],
        'label' 	=> 'ue-c-ad--label',
        'sticky' 	=> 'ue-c-ad--sticky',
        'ads' 		=> 'ue-c-ad',
        'adsInner' 	=> 'ue-c-ad__inner'
    ];

	static public function render($items, $section, $params = []) 
	{
	    $output = '';
	    $type = 'static';
	    if (isset($params[self::_TYPE])) {
	    	$type = $params[self::_TYPE];
	    }

	    $dfptype = self::_DFPOTHER;
	    if (isset($params[self::_DFPTYPE])) {
	    	$dfptype = $params[self::_DFPTYPE];
	    }

	    foreach ($items as $key => $item) {
	        switch ($item['name']) {
	            case 'mega':
	                $position = 'm';
	                $class = (isset ($item['class'])) ? $item['class'] : self::_CLASSES[$type]['m'];
	                $needLabel = true;
	                $isSticky = false;
	                break;
	            case 'skyRight':
	                $position = 'sd';
	                $class = (isset ($item['class'])) ? $item['class'] : self::_CLASSES[$type]['sd'];
	                $needLabel = false;
	                $isSticky = false;
	                break;
	            case 'skyLeft':
	                $position = 'si';
	                $class = (isset ($item['class'])) ? $item['class'] : self::_CLASSES[$type]['si'];
	                $needLabel = false;
	                $isSticky = false;
	                break;
	            case 'roba':
	                $position = $item['slot'];
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
	            case 'b300x100':
	                $position = $item['name'];
	                $class = (isset ($item['class'])) ? $item['class'] : '';
	                $needLabel = true;
	                $isSticky = false;
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


	        if (!isset($params[self::_BLOCK]) || $params[self::_BLOCK] == true) {
	        	$output .= "<div class=\"$innerClass\" aria-roledescription=\"Publicidad\" role=\"region\">
	        					<div class=\"".self::_CLASSES['adsInner']."\">";
	        }

	        $output .= "<div id='div-gpt-ad-{$section}_{$dfptype}_$position' class=\"publicidad\">
	                		<script type='text/javascript'>
	                    		googletag.cmd.push(function () { googletag.display('div-gpt-ad-{$section}_{$dfptype}_$position'); });
	                		</script>
	            		</div>";
	        
	        if (!isset($params[self::_BLOCK]) || $params[self::_BLOCK] == true) {
	        	$output .= "</div>
	    				</div>";
	        }   

	        if ($class) {
	            $output .= "</div>";
	        }
	        
	    }

	    return $output;
	}
}