<?php
header('Content-type: text/xml');
$courseslist = new DOMDocument();
$courseslist->loadXML("<coursesdata/>");
$f = $courseslist->createDocumentFragment();
$cid = $_GET['cid'];
$ch = curl_init();
$url = 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/courses/{course_id}';
$templateParamNames = array('{course_id}');
$templateParamValues = array(urlencode($cid));
$url = str_replace($templateParamNames, $templateParamValues, $url);
$queryParams = '?' . urlencode('view') . '=' . urlencode('full') . '&' . urlencode('apikey') . '=' . urlencode('l7xxd792f666780c485697bd3e180e3d2497');
curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);


$responsedata = substr($response, strpos($response, '?'.'>') + 2);
$f->appendXML($responsedata);
$courseslist->documentElement->appendChild($f);
echo $courseslist->saveXML(); 

?>