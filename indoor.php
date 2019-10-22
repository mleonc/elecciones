<?php

require __DIR__.'/vendor/autoload.php';

use Indoor\Http\Exceptions\HttpRequestNoRoute;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

$response = Indoor\Http\Response::response($request = Indoor\Http\Request::capture());

try {
} catch (HttpRequestNoRoute $e) {
    http_response_code($e->getCode());
} catch (HttpRequestDataNotFound $e) {
    http_response_code($e->getCode());
}
die;

function getJsonBaseUrl($basePath, $ccaa, $year, $electionType, $code,  $cirCode) {
    switch ($electionType){
        case 'elecciones-europeas':
            if ($ccaa=='99' && $cirCode=='99'){
                $path = "$basePath/$electionType/resultados/$year/pe$code.html";
            }
            else if ($ccaa=='es') {
                $path = "$basePath/$electionType/resultados/$year/99/p$code.html";
            }
            else if ($cirCode=='99' && $ccaa!='99') {
                $path = "$basePath/$electionType/resultados/$year/$ccaa/p$code.html";
            }
            else {
                $path = "$basePath/$electionType/resultados/$year/$ccaa/$cirCode/p$code.html";
            }
            break;
        case 'elecciones-municipales':
            $path = "$basePath/$electionType/resultados/$year/$ccaa/$cirCode/p$code.html";
            if ($cirCode == '99') {
                $path = "$basePath/$electionType/resultados/$year/$ccaa/p$code.html";
            }
            break;
        default:
            $path = "$basePath/$electionType/resultados/$year/$ccaa/$cirCode/p$code.html";
    }
    return $path;
}    

function dfp($adsItems, $dfpSection) {
    $output = '';

    $classes = [
        'sd' => 'ue-l-common-page__sky ue-l-common-page__sky--right',
        'si' => 'ue-l-common-page__sky ue-l-common-page__sky--left',
        'm' => 'ue-l-common-page__row ue-l-common-page__row--no-gutter',
        'label' => 'ue-c-ad--label',
        'sticky' => 'ue-c-ad--sticky',
        'ads' => 'ue-c-ad',
        'adsInner' => 'ue-c-ad__inner'
    ];

    foreach ($adsItems as $item) {
        switch ($item['name']) {
            case 'mega':
                $position = 'm';
                $class = (isset ($item['class'])) ? $item['class'] : $classes['m'];
                $needLabel = true;
                $isSticky = false;
                break;
            case 'skyRight':
                $position = 'sd';
                $class = (isset ($item['class'])) ? $item['class'] : $classes['sd'];
                $needLabel = false;
                $isSticky = false;
                break;
            case 'skyLeft':
                $position = 'si';
                $class = (isset ($item['class'])) ? $item['class'] : $classes['si'];
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


        $innerClass = $classes['ads'];
        if ($needLabel) {
            $innerClass .= ' ' . $classes['label'];
        }
        if ($isSticky) {
            $innerClass .= ' ' . $classes['sticky'];
        }

        if ($class) {
            $output = "<div class=\"$class\">";
        }

        $output .= "
        <div class=\"$innerClass\" aria-roledescription=\"Publicidad\" role=\"region\">
        <div class=\"{$classes['adsInner']}\">
            <div id='div-gpt-ad-{$dfpSection}_p_$position' class=\"publicidad\">
                <script type='text/javascript'>
                    googletag.cmd.push(function () { googletag.display('div-gpt-ad-{$dfpSection}_p_$position'); });
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

function omniture($url, $ccaaSlug, $device='mobile', $cabeceraShort='', $title='', $model='', $name, $provincia){
//    omniture($url, $ccaa['slug'], $format, 'elmundo.es', $headTitle, $electionType);
    $aDevice = 'móvil';
    if ($device == 'desktop') {
        $aDevice = 'web';
    }
    
    if ($model != 'elecciones-municipales' && $model != 'elecciones-europeas') {
        $channel = 'autonomicas';
    }
    else {
        $channel=$model;
        $channel=str_replace('elecciones-','',$channel);
    }
        $prop3 =$ccaaSlug;
        $prop4 = $provincia;
        $prop5='';
        if ($model=='elecciones-municipales'){
            $prop5 = $name;  
        }


    echo <<<OUTPUT
<script language='JavaScript' type='text/javascript'><!--
    var s = {};
    var pageName = '$url'; //URL

    s.pageType='';

    s.pageName='$url';

    s.channel='Elecciones'
    s.prop1='elecciones-$channel';
    s.prop2='resultados';
    s.prop3='$prop3';
    s.prop4='$prop4';
    s.prop5='$prop5';
    s.prop6='';
    s.prop7='$cabeceraShort';
    s.prop9=s.pageName;
    s.prop11='$title ';

    s.hier1=s.prop7 + '|' + s.channel + '|' + s.prop1 + '|' + s.prop2 + '|' + s.prop3 + '|' + s.prop4 + '|' + s.prop5;

    s.prop27='$device';
    s.prop28='';
    s.prop29='elecciones|elecciones-$channel|elecciones-$ccaaSlug';
    s.prop30='';
    s.prop32='otros';
    s.prop33='$model';
    s.prop35='origen';
    s.prop43='';
    s.prop75='';
    /* Conversion Variables */
    s.eVar1=s.channel;
    s.eVar2=s.prop1;
    s.eVar3=s.prop2;
    s.eVar4=s.prop3;
    s.eVar5=s.prop4;
    s.eVar6=s.prop6;
    s.eVar7=s.prop7;
    s.eVar9=s.prop9;
    s.eVar11=s.prop11;
    s.eVar27=s.prop27;
    s.eVar28=s.prop28;
    s.eVar29=s.prop29;
    s.eVar30=s.prop30;
    s.eVar32=s.prop32;
    s.eVar33=s.prop33;
    s.eVar35=s.prop35;
    s.eVar43=s.prop43;
    s.eVar75=s.prop75;
    var s_omniture = s;
    /* DO NOT ALTER ANYTHING BELOW THIS LINE ! **/
    //-->
</script>
OUTPUT;
}


/**
    GET params
        year | int
        month | int
        code | string | default 'p99'
        circode | string | default '99'
        ccaacode | string | default '99'
        type | string | default ''
*/


//Get Data from QueryString path
if (!isset($_GET['year']) || !isset($_GET['month'])) {
    return ;
}

$year = $_GET['year'];
$month = $_GET['month'];

$code = (isset($_GET['code']))? $_GET['code']: 'p99';
if (strpos($code, 'p') !== false){
    $code = substr($code, 1);
}
$circunscripcionCode = (isset($_GET['circode']))? $_GET['circode']:'99';
$ccaaCode = (isset($_GET['ccaacode']))?$_GET['ccaacode']:'99';
$electionType = (isset($_GET['type']))? $_GET['type']: '';
$electionType = "elecciones-". $electionType;

$env='pro';
$path_datos= "/home/miguelangel.leon/projects/elmundo/uedit/web/elecciones-indoor";

if ($_SERVER['HTTP_HOST'] =='www.elmundo.sta.internet.int') {
    $env="sta";
    $path_datos= "/mnt/filer/html/staging/DATOS/portales/es/elmundo/www/includes/elecciones/";

}

if ($env == 'sta') {
    $basePath = 'http://elecciones.sta.internet.int';
} else {
    $basePath = 'https://elecciones.unidadeditorial.es';
}

$ccaaOneProv = [
   '03' => '33',
   '04' => '07',
   '06' => '39',
   '12' => '28',
   '13' => '31',
   '15' => '30',
   '16' => '26',
   '18' => '51',
   '19' => '52',
   ];


$requestURI =  getJsonBaseUrl($basePath,$ccaaCode,$year,$electionType,$code,$circunscripcionCode);
        

$type='autonomicas';

if ($electionType == 'elecciones-municipales') {
    $type = 'municipales';   
}
if ($electionType == 'elecciones-europeas') {
    $type = 'europeas';   
}



$metadataFile = file_get_contents($path_datos."/metadata-".$type."-".$env.".json");

if (!$metadataFile) {
    echo "No se puede acceder a ".$path_datos."/metadata-".$type."-".$env.".json";
    die;
}

$metadata = json_decode(file_get_contents($path_datos."/metadata-".$type."-".$env.".json"), true);




$metadata['json_file_path'] = str_replace(
        [$metadata['html_basehost'], '.html'],
        [$metadata['json_basehost'], '.json'],
        $requestURI);

$metadata['json_path_past'] = str_replace($year, $metadata[$ccaaCode]['last_election_year'], $metadata['json_file_path']);

//$pathData = str_replace($metadata['json_basehost'],$metadata['filer_root_path'],$metadata['json_file_path']);

$rawPlaceData = file_get_contents($metadata['json_file_path']);

if ($rawPlaceData) {
    $placeData = json_decode($rawPlaceData, true);
} else {
    http_response_code(404);
    die;
}

if (isset($placeData['ccaaName'])){
    $placeData['ccaaName'] = iconv("UTF-8", "ISO-8859-1//IGNORE", $placeData['ccaaName']);
}
if (isset($placeData['ccaa_code'])) {
    $placeData['ccaaName'] = iconv("UTF-8", "ISO-8859-1//IGNORE", $datosEstado['ccaa'][$placeData['ccaa_code']]['name']);
}

if (isset($placeData['name'])){
    $placeData['name'] = iconv("UTF-8", "ISO-8859-1//IGNORE", $placeData['name']);
}

if ($type=='autonomicas'){
    if (isset($placeData['id_registro'])){
        $type = 'autonomicas';    // $type = 'elecciones-generales';
    }
    else  {
        $type = 'autonomicas-localidades';
    }
}

// parameters templates
$election_url=$metadata['election_url'];
$election_type=$electionType;
$election_camara='';
$election_year=$year;
$class_list='ue-c-elections-result-detail__breadcrumb';
$class_item='ue-c-elections-result-detail__breadcrumb-item';
//

$name = $placeData['name'];
$electionName = $name; //Por ejemplo: elecciones-comunidad-valenciana
$url = $requestURI;
$assets_style_version = $metadata['assets']['version'];

$json_file_prov = $metadata['json_basehost'] . $electionType  ."/resultados/". $year ."/".$ccaaCode."/".$circunscripcionCode."/p99.json";
$json_file_ccaa = $metadata['json_basehost'] . $electionType  ."/resultados/". $year ."/".$ccaaCode."/99.json";
if (in_array($type, ['europeas', 'municipales'])) {
    $json_file_ccaa = $metadata['json_basehost'] . $electionType  ."/resultados/". $year ."/".$ccaaCode."/p99.json";
}

$prov_code = $circunscripcionCode;
$canUrl = 'https://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];


$static_path = $metadata['filer_path'].$metadata['static_path'];
$circunscripcion=[
    'code' => $circunscripcionData['c_code'],
    'name' => iconv( "UTF-8", "ISO-8859-1//IGNORE", $circunscripcionData['name'])
];
$ccaa=[
    'code' => (isset($placeData['ccaa_code']))? $placeData['ccaa_code']: '',
    'name' => (isset($placeData['ccaaName']))? $placeData['ccaaName']: $placeData['name'],
    'lista_circunscripciones' => $datosEstado['ccaa'][$ccaaCode]['lista_circunscripciones'],
    'slug' => $datosEstado['ccaa'][$ccaaCode]['slug']
];

$info = [
        'year' => $year,
        'election-type' => $type
];

//header("Vary: User-Agent");
//$static_path = $metadata["filer_path"]. "". $metadata["static_path"];
$static_registro_path= $metadata['filer_path'].$metadata['static_registro_path'];
$url_assets = $metadata['url_assets'];

$rrssTitle = "Resultados de las Elecciones auton&oacute;micas $year en " .$ccaa['name'];
$rrssDescription = "Consulte qui&eacute;n ha ganado y conozca al detalle los resultados de las elecciones auton&oacute;micas de ". $year . "en " . $ccaa['name']. " , en tiempo real y al detalle.";
    if (($type == 'autonomicas') && ($circunscripcionCode !='99')) {
       $rrssTitle= "Resultados Elecciones auton&oacute;micas " . $year ." en la provincia de " . $circunscripcion['name'] . ", " . $ccaa['name'];
       $rrssDescription = "Consulte al detalle los resultados de las elecciones auton&oacute;micas de " .$year. " en la provincia de " . $circunscripcion['name'].", " .  $ccaa['name'];  
    }
    if ($type == 'autonomicas-localidades') {
        $rrssTitle= "Resultados de " . $name ." en las Elecciones al Parlamento de ". $ccaa['name'] . " " . $year;
        $rrssDescription = "Consulte al detalle los resultados de las elecciones auton&oacute;micas de " .$year . " en el municipio de " . $name . ", ".  $ccaa['name'].". Vea cu&acute;ntos votos ha logrado cada partido y c&oacute;mo queda compuesta la C&acute;mara.";       
    }
    if ($type == 'municipales') {
        $rrssTitle= "Resultados Elecciones Municipales ". $year ." en ". $name ." | EL MUNDO";
        $rrssDescription = "Consulta qui&eacute;n ha ganado las elecciones municipales del 26 de mayo de 2019 en ". $name .", " . $circunscripcion['name'] .". Utiliza nuestro buscador para ver los resultados al detalle.";
        }
    if ($type == 'europeas' && $ccaaCode=='99') {
        $rrssTitle= "Resultados Europa elecciones europeas 2019 | EL MUNDO";
        $rrssDescription = "Conoce los resultados de todos los pa&iacute;ses de la Uni&oacute;n Europea en las elecciones europeas de mayo de 2019: n&uacute;mero de votos y eurodiputados.";
        }
    if ($type == 'europeas' && $ccaaCode!='99') {
        if (ctype_digit($ccaaCode) ){
            $rrssTitle= "Resultados ". $ccaa['name'] . " elecciones europeas " .$year. " | EL MUNDO";
            $rrssDescription = "Conoce los resultados de " . $ccaa['name'] . " en las elecciones europeas del 26 de mayo de 2019: n&uacute;mero de votos y porcentaje.";  
        }
        else {
            $rrssTitle= "Resultados ". $ccaa['name'] . " elecciones europeas " .$year . " | EL MUNDO";
            $rrssDescription = "Conoce los resultados de " . $ccaa['name'] . " en las elecciones europeas de mayo de 2019: n&uacute;mero de votos y eurodiputados.";          
        }
    }        

$headTitle = "Resultados de las Elecciones auton&oacute;micas $year en $name";
$keywords = "elecciones autonomicas, elecciones autonomicas " . $year . " en " . $ccaa['name'];
// resultados elecciones, resultados elecciones {$ccaa['slug']}, resultados elecciones {$ccaa['slug']} $year"
if (($type == 'autonomicas') && ($circunscripcionCode !='99')) {
    $headTitle = "Resultados elecciones auton&oacute;micas $year en $name, ".$ccaa['name'];
    $keywords = "resultados elecciones autonomicas ". $year ." en " .$name;
}
 if ($type == 'autonomicas-localidades') {
    $headTitle = "Resultados de $name en las Elecciones " . $year . " al Parlamento de ".$ccaa['name'] . " ";
    $keywords = "resultados elecciones auton&oacute;micas ". $year ." en " .$name;
}
if ($type == 'municipales') {
    $headTitle = "Resultados elecciones ".$type . " " .$year ." en ". $name;
    $keywords = "elecciones municipales, elecciones " .$name .", elecciones municipales " . $year;
}
if ($type == 'europeas' && $ccaaCode=='99') {
    $headTitle = "Resultados Europa elecciones europeas 2019";
    $keywords = "resultados europa elecciones europeas " .$year; 
}
if ($type == 'europeas' && $ccaaCode!='99') {
    if ($ccaaCode!='es'){
        $headTitle = "Resultados " . $ccaa['name'] . " elecciones europeas 2019";
        $keywords = "resultados " . $ccaa['name'] . " elecciones europeas " . $year; 
    }
    else {
        $headTitle = "Resultados Espa&ntilde;a elecciones europeas " .$year;
        $keywords = "resultados Espa&ntilde;a elecciones europeas " . $year; 
    }
}


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-15" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"/>
    <title><?php echo "$headTitle | ".$metadata['cabecera_name']; ?></title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0">
    <?php if ($format == 'desktop'): ?>
        <?php include($metadata['styles']['path'].'/'.$metadata['styles']['version'].'/'.$metadata['styles']['widget_include_name']); 
           ?>
           <link rel="stylesheet" type="text/css" href="<?php echo $metadata['cdn'].$metadata['assets']['version'].$metadata['assets']['css_desktop']; ?>">
    <?php else: ?>
        <?php include($metadata['styles']['path'].'/'.$metadata['styles']['version'].'/'.$metadata['styles']['widget_include_name_mobile']);
              
     ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $metadata['cdn'].$metadata['assets']['version'].$metadata['assets']['css_mobile']; ?>">
    <?php endif; ?>
    <?php 
    $metaDescription= "Consulte qui&eacute;n ha ganado y conozca al detalle los resultados de las elecciones auton&oacute;micas de ". $year . " en " .$ccaa['name'] .".";
    if ($type == 'autonomicas' && $circunscripcionCode !='99') {
        $metaDescription = "Consulte al detalle los resultados de las elecciones auton&oacute;micas de $year en la provincia de " .$name.", ".$ccaa['name'];
    }
    if ($type == 'autonomicas-localidades') {
        $metaDescription = "Consulte al detalle los resultados de las elecciones auton&oacute;micas de " .$year . " en el municipio de " .$name .", ".$ccaa['name'] . ". Sepa cu&acute;ntos votos ha logrado cada partido.";
    }
    if ($type == 'municipales') {
        $metaDescription = "Consulta qui&eacute;n ha ganado las elecciones municipales del 26 de mayo de 2019 en ". $name. ", ".$circunscripcion['name'] . ". Utiliza nuestro buscador para ver los resultados al detalle.";
    }
    if ($type == 'europeas' && $ccaaCode=='99') {
        $metaDescription = "Conoce los resultados de todos los pa&iacute;ses en las elecciones europeas de mayo de " .$year .".";
    }
    if ($type == 'europeas' && $ccaaCode!='99') {
        if (ctype_digit($ccaaCode) ){
            $metaDescription = "Conoce los resultados de " .$ccaa['name'] . " en las elecciones europeas del 26 de mayo de 2019: n&uacute;mero de votos y porcentaje.";
        }
        else {
           $metaDescription = "Conoce los resultados de " .$ccaa['name'] . " en las elecciones europeas de mayo de 2019: n&uacute;mero de votos y eurodiputados.";
        }
    }
    ?>
    <?php if($env=='sta'): ?>
        <script src="//assets.adobedtm.com/73515ad8d49a3d35d5aa6bc81b535d3a8761d99c/satelliteLib-e48bb3b61613dd24961235e0a80c02ab5b0cf8b8-staging.js"></script>
    
    <?php endif; ?>

    <meta name="description" content="<?php echo $metaDescription ?>"/>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="news_keywords" content="<?php echo $keywords; ?>"/>
    <meta name="robots" content="index,follow" />
    <meta name="organization" content="Unidad Editorial Informaci&oacute;n General S.L.U." />
    <meta name="theme-color" content="#2e6d9d">
    <meta name="referrer" content="unsafe-url">

    <meta name="date" content="2019-05-26T20:00:00Z"/>
    <meta property="article:modified_time" content="<?php echo $metadata['updatedAt']; ?>"/>
    <meta property="article:published_time" content="2019-05-26T20:00:00Z"/>
    <meta name="DC.date.issued" content="<?php echo $metadata['updatedAt']; ?>">

    <!-- ##IBEXCLU -->
    <link Href="<?php echo $canUrl; ?>" data-ue-c="href" data-ue-u="canonical" rel="canonical" />
    <!-- ##FBEXCLU -->
    <meta name="robots" content="index,follow" />

    <?php  
    $articleSection="elecciones-autonomicas";
    if ($type == 'municipales') {
        $articleSection="elecciones-municipales";
    }
    if ($type == 'europeas') {
        $articleSection="elecciones-europeas";
    }
    ?>
    <meta property="article:section" content="<?php echo $articleSection ?>"/>

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="<?php echo $metadata['twitter']['site']; ?>" />
    <meta data-ue-u="twitter:title" name="twitter:title" content="<?php echo $rrssTitle; ?>" />
    <meta data-ue-u="twitter:description" name="twitter:description" content="<?php echo $rrssDescription; ?>" />
    <meta name="twitter:image" content="<?php echo $metadata['twitter']['icon'] ?>"/>

    <meta data-ue-u="og:title" property="og:title" content="<?php echo $rrssTitle; ?>" />
    <meta data-ue-u="og:description" property="og:description" content="<?php echo $rrssDescription; ?>" />
    <meta property="og:url" content="<?php echo $canUrl; ?>" />
    <meta property="og:type" content="website" />
    <meta data-ue-u="og:image" property="og:image" content="<?php echo $metadata['rrss']['image']; ?>" />
    <meta property="og:site_name" content="<?php echo $metadata['rrss']['name']; ?>" />
    <meta property="fb:app_id" content="<?php echo $metadata['rrss']['app']; ?>" />

    <link href="<?php echo $metadata['cdn']; ?>favicon.ico" type="image/ico" rel="icon"/>
    <link href="<?php echo $metadata['cdn']; ?>favicon.ico" type="image/ico" rel="shortcut icon"/>

    <link rel="apple-touch-icon-precomposed" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-76x76-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-120x120-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $metadata['cdn']; ?>apple-touch-icon-152x152-precomposed.png">

    <?php
    /*$path = $metadata['assets']['css_main_path'].'/main-elections-link-style.html';
    echo file_get_contents($path);*/
    ?>
    <!--INICIO esto se deber&iacute;a cargar din&acute;micamente-->
    <link rel="preload" href="https://e00-elmundo.uecdn.es/fonts/<?php echo $metadata[$ccaaCode]['fonts']; ?>/<?php echo $metadata[$ccaaCode]['fonts']; ?>-bold-webfont.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://e00-elmundo.uecdn.es/fonts/<?php echo $metadata[$ccaaCode]['fonts']; ?>/<?php echo $metadata[$ccaaCode]['fonts']; ?>-regular-webfont.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://e00-elmundo.uecdn.es/fonts/<?php echo $metadata[$ccaaCode]['fonts']; ?>/<?php echo $metadata[$ccaaCode]['fonts']; ?>-bolditalic-webfont.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://e00-elmundo.uecdn.es/fonts/roboto/RobotoCondensed-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://e00-elmundo.uecdn.es/fonts/roboto/RobotoCondensed-Regular.woff2" as="font" type="font/woff2" crossorigin>
    <!--FIN fin de lo que hay que borrar -->

    <script src="<?php echo $metadata['ue_jquery'][$format]; ?>" type="text/javascript" ></script>
    <script src="<?php echo $metadata['ue_utils'][$format]; ?>" type="text/javascript"></script>

    <!--[if lte IE 9]>
    <script type="text/javascript" src="<?php echo $metadata['cdn']; ?>/<?php echo $assets_style_version; ?>/js/jquery.ie8.js"></script>
    <![endif]-->

    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo $url_assets; ?>/js/html5shiv.js"></script>
    <![endif]-->



    <script type="application/ld+json">
        [
            {
                "@context": "http://schema.org",
                "@type":"NewsArticle",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "<?php echo $canUrl; ?>"
                },
                "headline": "<?php echo $headTitle?>",
                "articleSection": "<?php echo $metadata[$ccaaCode]['seo_name']?>",
                "image":[
                    {
                        "@type": "ImageObject",
                        "url": "https://e00-elmundo.uecdn.es/assets/v11/img/destacadas/elmundo__logo-generica.jpg",
                        "height": 500,
                        "width": 700
                    }
                ],
                "datePublished": "<?php echo $metadata['publishedAt']; ?>",
                "dateModified": "<?php echo $metadata['updatedAt']; ?>",
                "author": [
                    {
                        "@type": "Person",
                        "name": "elmundo.es"
                    }
                ],
                "publisher": {
                    "@type": "Organization",
                    "name": "El Mundo",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "https://e00-elmundo.uecdn.es/assets/v11/img/destacadas/elmundo__logo-generica.jpg",
                        "width": 204,
                        "height": 27
                    }
                },
                "publishingPrinciples": {
                    "@type": "CreativeWork",
                    "url": "https://www.elmundo.es/em/codigo-etico.html"
                },
                "description": "<?php echo $rrssDescription?>"
            }
        ]
    </script>



    <script type="text/javascript" language="javascript" src="https://e00-ue.uecdn.es/cookies/js/policy_v3.js"></script>
    <script type="text/javascript" src="https://sdk.privacy-center.org/loader.js" data-key="03f1af55-a479-4c1f-891a-7481345171ce" id="spcloader" async></script>
    <script type="text/javascript" src="https://e00-elmundo.uecdn.es/js/uecomscore_cmp.js"></script>
    <script type="text/javascript">!function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function(){q("f",
)},setDisplayBids:function(){},targetingKeys:function(){return[]},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore(A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js")</script>
    <?php @include($metadata['filer_path'].$metadata['ue_login']); ?>
    <script type="text/javascript" src="<?php echo $metadata['election_js_component']; ?>/ueElections-inside.js?break-cache=2"></script>
</head>

<body class="<?php echo $metadata[$ccaaCode]['bodyClass']; ?>">
<!--A BORRAR EN PRODUCCION-->
<script>var gptadslots=[],googletag=googletag||{};googletag.cmd=googletag.cmd||[]</script>
<script>(function(){var frm=document.createElement('script');frm.async=true;frm.type='text/javascript';var useSSL='https:'==document.location.protocol;frm.src=(useSSL?'https:':'http:')+'//e00-elmundo.uecdn.es/js/1475575201_elmundo.js';var node=document.getElementsByTagName('script')[0];node.parentNode.insertBefore(frm,node);})()</script>
<!--FIN A BORRAR-->


<!-- === CABECERA === -->

<?php if ($format == 'desktop'): ?>


<?php else: ?>

<?php endif; ?>


<!-- === FIN CABECERA === -->

<?php 
if ($format == 'mobile'){
    $adsItems = [['name' => 'mega']];
} else {
    $adsItems = [
    ['name' => 'skyRight'], ['name' => 'skyLeft'], ['name' => 'mega']
    ];
}
$dfp = dfp($adsItems, $metadata['dfp_section']);?>

<div class="skin-ad"></div>

 <div class="ue-l-common-page">
    <div class="ue-l-common-page__inner">
        <?php echo $dfp; ?>
    </div>
</div>
<?php

$dataParent = '';

//$dataTotal = $metadata[$ccaaCode]['json_file'];
if ($prov_code != '99') {
    $dataTotal = $json_file_ccaa;
}

if ($code != '99'){
    $dataParent = $json_file_prov;
    $dataTotal = $json_file_ccaa;
}

$elementCode = (isset($prov_code)) ? $prov_code : $circunscripcion['code'];

?>
<div class="ue-l-common-page">
    <div class="ue-l-common-page__inner">

<div class="ue-l-common-page__box js-ueElecctionsData" data-device="desktop" data-json-actual="<?php echo $metadata['json_file_path']; ?>" data-json-past="<?php echo $metadata['json_path_past']; ?>"
     <?php if ($dataParent): echo ' data-json-parent="'.$dataParent.'"'; endif; ?>
data-json-total="<?php echo $dataTotal; ?>">
<div class="ue-l-common-page__row">
    <div class="ue-l-common-page__column ue-l-common-page--size8of12">
        <div class="ue-c-elections-result-detail">
         <h2 class="ue-c-elections-result-detail__kicker"><?php echo $metadata['seo_name'].' '.$info['year']; ?></h2>
            <?php
                $headline = 'Resultados de las elecciones ';
                if ($type == 'autonomicas-localidades') {
                    $headline .= 'auton&oacute;micas en ' .  $name;
                }
                elseif ($type == 'autonomicas' && $code == '99' && $circunscripcionCode != '99' ) {
                    $headline .=  'auton&oacute;micas en la provincia de ' .  $name;
                }
                elseif ($type == 'autonomicas' && $code == '99' && $circunscripcionCode == '99' ) {
                    $headline .=  'auton&oacute;micas en '. $ccaa['name'];
                }
                elseif ($type == 'europeas' && $ccaaCode=='99'){
                    $headline = "Resultados de Europa en las elecciones europeas " . $year;
                }
                elseif ($type == 'europeas' && $ccaaCode!='99'){
                    if ( $ccaaCode=='es'){
                        $headline = " Resultados de Espa&ntilde;a en las elecciones europeas 2019";
                    }
                    else {
                      $headline = "Resultados de " . $ccaa['name'] ." en las elecciones europeas " . $year; 
                    }
                }
                elseif ($type == 'municipales'){
                    $headline .= $type . " " . $year . ' en ' .  $name;
                }
              
            ?>
            <h1 class="ue-c-elections-result-detail__headline"><?php echo $headline; ?></h1>

            <?php
                if (($type == 'europeas' && preg_match('/[0-9]/', $ccaaCode) && $circunscripcionCode=='99') || $prov_code=='99' && $circunscripcionCode=='99'):
                    $classItem = 'ue-c-elections-result-detail__tags-item';
                    $classList = 'ue-c-elections-result-detail__tags';
                    $class_list='ue-c-elections-result-detail-places';
                    $class_item='';
                    //include ($path_datos.'/index/may19/'.$ccaa['code'] .'/provincias.html');

                    $marks   = ['$class_list', '$class_item', '$election_url', '$election_type', '$election_camara', '$election_year'];
                    $replace = [$classList, $classItem, $election_url, $election_type, $election_camara, $election_year];
                    $output = str_replace($marks, $replace, file_get_contents($path_datos.'/index/may19/'.$ccaa['code'] .'/provincias.html'));
                    echo iconv("UTF-8", "ISO-8859-1//IGNORE", $output);

                elseif ($type == 'europeas' && $ccaaCode == 'es'):
                    $classItem = 'ue-c-elections-result-detail__tags-item';
                    $classList = 'ue-c-elections-result-detail__tags';
                    $class_list='ue-c-elections-result-detail-places';
                    $class_item='';

                    $marks   = ['$class_list', '$class_item', '$election_url', '$election_type', '$election_camara', '$election_year'];
                    $replace = [$classList, $classItem, $election_url, $election_type, $election_camara, $election_year];
                    $output = str_replace($marks, $replace, file_get_contents($path_datos.'/index/may19/ccaa.html'));
                    echo iconv("UTF-8", "ISO-8859-1//IGNORE", $output);
                elseif (in_array($type, ['europeas']) && preg_match('/[0-9]+/', $ccaaCode)):
            ?>
            <ul class="ue-c-elections-result-detail__breadcrumb">
                <?php
                    if (isset($ccaa['name'])):
                        $title = $ccaa['name'];
                        if ($type == 'autonomicas-localidades'
                            || ($type == 'autonomicas' && $code =='99')
                            || (in_array($type, ['municipales', 'europeas']) && preg_match('/[0-9]+/', $ccaaCode) )) {
                            $title = "<a href='{$metadata['election_url']}/elecciones-{$ccaa['slug']}/resultados/{$info['year']}/{$ccaa['code']}/99/p99.html'>{$ccaa['name']}</a>";
                        }
                ?>
                <li class="ue-c-elections-result-detail__breadcrumb-item" id="c<?php echo $ccaa['code']; ?>">
                    <?php echo $title; ?>
                </li>
                <?php endif; ?>

                <?php 
                    if (isset($ccaa['lista_circunscripciones'][$elementCode]['name'])):
                        $title = $ccaa['lista_circunscripciones'][$elementCode]['name'];
                        if ($type == 'autonomicas-localidades'
                            || (in_array($type, ['municipales', 'europeas']) && $code != '99')) {
                            $title = "<a href='{$metadata['election_url']}/elecciones-{$ccaa['slug']}/resultados/{$info['year']}/{$ccaa['code']}/$elementCode/p99.html'>{$ccaa['lista_circunscripciones'][$elementCode]['name']}</a>";
                        }
                            $title = iconv("UTF-8", "ISO-8859-1//IGNORE", $title);
                ?>

                <li class="ue-c-elections-result-detail__breadcrumb-item" id="p<?php echo $elementCode; ?>"><?php echo $title; ?></li>
                <?php endif; ?>

                <?php if (isset($circunscripcion['code']) && $code!=99): ?>
                <li class="ue-c-elections-result-detail__breadcrumb-item"><?php echo $name; ?></li>
                <?php endif; ?>

            </ul>
            <?php endif; 
            $nameBuscador = "elecciones-" . $ccaa['slug'];
            if ($type == 'europeas') {
                $nameBuscador='elecciones-generales';
            }
            if ($type == 'municipales') {
                $nameBuscador = 'elecciones-municipales';
            }

            ?>
            <?php if($type != 'europeas'):?>
            <form id="form" class="ue-c-elections-search-form js-ueElecctionsAutocomplete" " data-type="<?php echo $nameBuscador; ?>" data-year="<?php echo $info['year']; ?>" autocomplete="off" action="">
            <div class="ue-c-elections-search-form__search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" role="img" aria-hidden="true">
                    <path fill="#FFF" fill-rule="nonzero" d="M18.344 17.941l-4.375-4.374a7.643 7.643 0 0 0 1.884-5.033C15.853 4.3 12.408.86 8.177.86 3.94.86.5 4.304.5 8.534s3.445 7.675 7.677 7.675c1.924 0 3.684-.71 5.034-1.884l4.375 4.375c.104.103.243.16.38.16a.54.54 0 0 0 .38-.918zM1.574 8.534a6.605 6.605 0 0 1 6.599-6.597 6.605 6.605 0 0 1 6.598 6.597c0 3.636-2.958 6.602-6.598 6.602-3.637 0-6.6-2.962-6.6-6.602z"></path>
                </svg>
            </div>
            <label class="hidden-content" for="ID_INPUT">Buscar</label>
            <input id="ID_INPUT" placeholder="Busca tu municipio o provincia" title="Busca tu municipio o provincia" class="ue-c-elections-search-form__text-input" type="text" name="">
            <button class="ue-c-elections-search-form__submit-button" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" role="img" aria-hidden="true">
                    <g fill="none" fill-rule="evenodd" stroke="#51506A">
                        <path d="M0 8.6h15.97M8 0l8.433 8.433L8 16.866"></path>
                    </g>
                </svg>
                <span class="hidden-content">Buscar</span>
            </button>
            <div id="js-lista_elecciones" class="ue-c-elections-search-form__autocomplete-items js-container"></div>
            </form>
            <?php else :
                $options = ['pe' => ['name' => 'Europa', ], 'es' => ['name' => 'Espa&ntilde;a', ], 'de' => ['name' => 'Alemania', ], 'at' => ['name' => 'Austria', ], 'be' => ['name' => 'B&eacute;lgica', ], 'bg' => ['name' => 'Bulgaria', ], 'cy' => ['name' => 'Chipre', ], 'hr' => ['name' => 'Croacia', ], 'dk' => ['name' => 'Dinamarca', ], 'sk' => ['name' => 'Eslovaquia', ], 'si' => ['name' => 'Eslovenia', ], 'ee' => ['name' => 'Estonia', ], 'el' => ['name' => 'Grecia', ], 'fi' => ['name' => 'Finlandia', ], 'fr' => ['name' => 'Francia', ], 'hu' => ['name' => 'Hungr&iacute;a', ], 'ie' => ['name' => 'Irlanda', ], 'it' => ['name' => 'Italia', ], 'lv' => ['name' => 'Letonia', ], 'lt' => ['name' => 'Lituania', ], 'lu' => ['name' => 'Luxemburgo', ], 'mt' => ['name' => 'Malta', ], 'nl' => ['name' => 'Pa&iacute;ses Bajos', ], 'pl' => ['name' => 'Polonia', ], 'pt' => ['name' => 'Portugal', ], 'uk' => ['name' => 'Reino Unido', ], 'cz' => ['name' => 'Rep&uacute;blica Checa', ], 'ro' => ['name' => 'Ruman&iacute;a', ], 'se' => ['name' => 'Suecia', ] ];
                if (preg_match('/[a-z]+/', $ccaaCode) && isset($options[$ccaaCode])) {
                    $options[$ccaaCode]['selected'] = true;
                }
                if (preg_match('/[0-9]+/', $ccaaCode)) {
                    $options['es']['selected'] = true;
                }
            ?>
                <select <select class="ue-c-elections-select-form__select" id="selectCountry">
                    <?php 
                        foreach ($options as $key => $option) {
                            $selected = '';
                            if ($option['selected'] === true) {
                                $selected = 'selected';
                            }

                            echo "<option value='$key' $selected>{$option['name']}</option>";
                        }
                    ?>
                </select>
            <?php  endif ?>
                <div class="ue-l-common-page__box js-ueTopBars">
                    <?php if (($type == 'autonomicas-localidades') || ($type == 'municipales')): ?>
                    <div class="ue-l-common-page__row ue-l-common-page__row--no-gutter">
                        <div class="ue-c-elections-simple-widget">
                            <h3 class="ue-c-elections-simple-widget__title">Total <?php echo $name; ?></h3>
                            <div class="ue-c-elections-result-bars ">
                                <div class="ue-c-elections-result-bars__bar">
                                    <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                    <div class="ue-c-elections-result-bars__bar-base">
                                        <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                    </div>
                                    <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($type == 'autonomicas-localidades' || ($type == 'autonomicas' && $code != '99') || ($type == 'municipales')): ?>
                    <div class="ue-l-common-page__row">
                        <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                            <div class="ue-c-elections-simple-widget">
                                <h3 class="ue-c-elections-simple-widget__title">Total Provincia de <?php echo iconv("UTF-8", "ISO-8859-1//IGNORE", $ccaa['lista_circunscripciones'][$elementCode]['name']); ?></h3>
                                <div class="ue-c-elections-result-bars ">
                                    <div class="ue-c-elections-result-bars__bar">
                                        <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                        <div class="ue-c-elections-result-bars__bar-base">
                                            <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                        </div>
                                        <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                            <div class="ue-c-elections-simple-widget">
                                <h3 class="ue-c-elections-simple-widget__title">Total <?php echo $ccaa['name']; ?></h3>
                                <div class="ue-c-elections-result-bars ">
                                    <div class="ue-c-elections-result-bars__bar">
                                        <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                        <div class="ue-c-elections-result-bars__bar-base">
                                            <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0%; background-color: #333333;"></div>
                                        </div>
                                        <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($type == 'autonomicas' && $code == '99'): ?>
                    <div class="ue-l-common-page__row ue-l-common-page__row--no-gutter">
                        <div class="ue-c-elections-simple-widget">
                            <h3 class="ue-c-elections-simple-widget__title">Total <?php echo $ccaa['name']; ?></h3>
                            <div class="ue-c-elections-result-bars ">
                                <div class="ue-c-elections-result-bars__bar">
                                    <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                    <div class="ue-c-elections-result-bars__bar-base">
                                        <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                    </div>
                                    <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (in_array($type, ['autonomicas', 'municipales']) || in_array($type, ['europeas']) && (preg_match('/[a-z]+/', $ccaaCode))): ?>
                <div class="ue-l-common-page__box js-ueSeatsBars">
                    <div class="ue-c-elections-simple-widget">
                        <h2 class="ue-c-elections-simple-widget__title">Esca&ntilde;os</h2>
                        <div class="ue-l-common-page__box">
                            <div class="ue-l-common-page__row">
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                                    <div class="ue-c-elections-result-bars ">
                                        <h3 class="ue-c-elections-result-detail__subtitle"><?php echo $info['year']; ?></h3>
                                        <div class="ue-c-elections-result-bars__bar">
                                            <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                            <div class="ue-c-elections-result-bars__bar-base">
                                                <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                            </div>
                                            <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                                    <div class="ue-c-elections-result-bars ">
                                        <h3 class="ue-c-elections-result-detail__subtitle"><?php echo $metadata['last_election_year']; ?></h3>
                                        <div class="ue-c-elections-result-bars__bar">
                                            <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                            <div class="ue-c-elections-result-bars__bar-base">
                                                <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                            </div>
                                            <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!in_array($type, ['europeas']) || in_array($type, ['europeas']) && (preg_match('/[0-9]+/', $ccaaCode)!= false) || $ccaaCode == 'es') : ?>
                <div class="ue-l-common-page__box js-ueVowsBars">
                    <div class="ue-c-elections-simple-widget">
                        <h2 class="ue-c-elections-simple-widget__title">Votos</h2>
                        <div class="ue-l-common-page__box">
                            <div class="ue-l-common-page__row">
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                                    <div class="ue-c-elections-result-bars ">
                                        <h3 class="ue-c-elections-result-detail__subtitle"><?php echo $info['year']; ?></h3>
                                        <div class="ue-c-elections-result-bars__bar">
                                            <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                            <div class="ue-c-elections-result-bars__bar-base">
                                                <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                            </div>
                                            <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                                    <div class="ue-c-elections-result-bars ">
                                        <h3 class="ue-c-elections-result-detail__subtitle"><?php echo $metadata[$ccaaCode]['last_election_year']; ?></h3>
                                        <div class="ue-c-elections-result-bars__bar">
                                            <div class="ue-c-elections-result-bars__bar-party">ND</div>
                                            <div class="ue-c-elections-result-bars__bar-base">
                                                <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                                            </div>
                                            <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array($type, ['europeas']) || in_array($type, ['europeas']) && (preg_match('/[0-9]+/', $ccaaCode) != false) || $ccaaCode == 'es') : ?>
                <div class="ue-l-common-page__box js-ueResultBars">
                    <div class="ue-c-elections-simple-widget">
                        <h3 class="ue-c-elections-simple-widget__title">Resultados por partido</h3>
                        <div class="ue-l-common-page__box">
                            <div class="ue-l-common-page__row">
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                                </div>
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ue-l-common-page__box js-ueDataBars">
                    <div class="ue-c-elections-simple-widget">
                        <h3 class="ue-c-elections-simple-widget__title">Datos Generales</h3>
                        <div class="ue-l-common-page__box">
                            <div class="ue-l-common-page__row">
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12-from-mobile">
                                    <div class="ue-l-common-page__box">
                                        <h3 class="ue-c-elections-result-detail__subtitle"><?php echo $info['year']; ?></h3>
                                    </div>
                                </div>
                                <div class="ue-l-common-page__column ue-l-common-page--size6of12-from-mobile">
                                    <div class="ue-l-common-page__box">
                                        <h3 class="ue-c-elections-result-detail__subtitle"><?php echo $metadata[$ccaaCode]['last_election_year']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="ue-c-elections-loader ue-c-elections-loader--align-top ue-c-elections-loader--show js-loader">
                <div class="ue-c-elections-loader__inner">
                    <p class="ue-c-elections-loader__text">Esperando resultados</p>
                <div class="ue-c-elections-loader__icon"></div>
            </div>
            </div>
        </div>
    </div>
    <div class="ue-l-common-page__column ue-l-common-page__column--min-300 ue-l-common-page--size4of12">
        <?php $dfp = dfp([['name' => 'roba']], $metadata['dfp_section']); ?>

        <?php echo $dfp; ?>
    </div>
</div>
</div>

    </div>
</div>

<div class="ue-l-common-page">
    <div class="ue-l-common-page__inner">
        <?php if ($prov_code || isset($circunscripcion['code'])): ?>
            <div class="ue-l-common-page__box">
                <div class="ue-l-common-page__row ue-l-common-page__row--no-gutter">
                    <div class="ue-c-elections-simple-widget">

                        <?php 
                         if (
                             (isset($ccaa['lista_circunscripciones'][$elementCode]['name']) && $circunscripcionCode!= '99')
                         ||
                             (in_array($type, ['autonomicas', 'municipales']) && isset($ccaaOneProv[$ccaa['code']]))
                         ):

                            if (in_array($type, ['autonomicas', 'municipales']) && isset($ccaaOneProv[$ccaa['code']])):
                                $listCitiesHeadline = '
                                <h3 class="ue-c-elections-simple-widget__title">Municipios de la comunidad autónoma de ' .$ccaa['name'] .'</h3>';
                                $indexCode = $ccaaOneProv[$ccaa['code']];
                            else:
                                $listCitiesHeadline = '
                                <h3 class="ue-c-elections-simple-widget__title">Municipios de la provincia de ' .$ccaa['lista_circunscripciones'][$elementCode]['name'] .'</h3>';
                                $indexCode = $elementCode;
                            endif;

                            $listCitiesHeadline = iconv("UTF-8", "ISO-8859-1//IGNORE", $listCitiesHeadline);
                            echo $listCitiesHeadline;
                            ?>

                        <?php endif; ?>
                        <?php
                            $class_list='ue-c-elections-result-detail-places';
                            $class_item='';
                            $marks   = ['$class_list', '$class_item', '$election_url', '$election_type', '$election_camara', '$election_year'];
                            $replace = [$class_list, $class_item, $election_url, $election_type, $election_camara, $election_year];
                            $output = str_replace($marks, $replace, file_get_contents($path_datos.'/index/may19/'. $ccaa['code'] .'/indice_'. $indexCode .'.html'));
                            echo iconv("UTF-8", "ISO-8859-1//IGNORE", $output);
                            //include ($path_datos.'/index/may19/'. $ccaa['code'] .'/indice_'. $elementCode .'.html');
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php @include ($metadata['filer_path'].$metadata['static_path'].$metadata['footer']); ?>
<?php
    omniture($url, $ccaa['slug'], $format, 'elmundo.es', $headTitle, $electionType,$name, iconv("UFT-8", "ISO-8859-1//IGNORE",$ccaa['lista_circunscripciones'][$elementCode]['name']));

    /*if ($info['election-type'] == 'autonomicas-localidades'){
        omniture($url, $ccaa['slug'], $ccaa['name'], $name, $info['year'], $slug, $circunscripcion['slug'], $format, 'elmundo.es', $headTitle, $electionName);
    } else {
        if ($code == '99'){
            omniture($url, $ccaa['slug'], $ccaa['name'], $ccaa['name'], $info['year'], '', '', $format, 'elmundo.es', $headTitle, $electionName);
        } else {
            omniture($url, $ccaa['slug'], $ccaa['name'], $name, $info['year'], $slug, '', $format, 'elmundo.es', $headTitle, $electionName);
        }
    }*/
?>
    <?php if($env=='sta'): ?>
        <script type="text/javascript">_satellite.pageBottom();</script>
    
    <?php endif; ?>
</body>

<script>
    $(function(){
      $('#selectCountry').on('change', function () {
         value= $(this).val();
         if (value=='pe'){ //global europa

         }
         <?php if ($env=='sta'): ?>
          url = 'http://www.elmundo.sta.internet.int/elecciones/elecciones-europeas/resultados/2019/'+value+'/99/p99.html';
         <?php else: ?>
          url = 'https://www.elmundo.es/elecciones/elecciones-europeas/resultados/2019/'+value+'/99/p99.html';
         <?php endif; ?>
         
       
         window.location = url; // redirect

      });
    });

    /*var urlParams = new URLSearchParams(window.location.search);
    valor=urlParams.get('ccaacode');
    alert(valor);
    $("#selectCountry option[value="+ valor +"]").attr("selected",true);*/
</script>
</html>
