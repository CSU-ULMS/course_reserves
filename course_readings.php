<?php
require("config.php");
$coursedata = new DOMDocument();
$coursedata->loadXML("<coursesdata/>");
$f = $coursedata->createDocumentFragment();
$ch = curl_init();
$templateParamValues = urlencode($_GET['cid']);
$apiurl .= $templateParamValues;
$queryParams = '?' . urlencode('view') . '=' . urlencode('full') . '&' . urlencode('apikey') . '=' . $apikey;
curl_setopt($ch, CURLOPT_URL, $apiurl . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

//$responsedata = substr($response, strpos($response, '?'.'>') + 2);
//$f->appendXML($responsedata);
//$coursedata->documentElement->appendChild($f);
$xml = new SimpleXMLElement($response);

include("header.php");

echo $xml->name . "<br/>\n";
echo $xml->academic_department . "<br/>\n";
echo $xml->terms->term[0] . "<br/>\n";
echo $xml->instructors->instructor[0]->first_name . "<br/>\n";
echo $xml->instructors->instructor[0]->last_name . "<br/>\n";
foreach ($xml->xpath('//reading_lists/reading_list') as $reading_list) {
  if ($reading_list->status == "Complete") {
    //print_r($reading_list);
    foreach ($reading_list->xpath('//citations/citation') as $citation) {
      if ($citation->status == "Complete") {
        echo "<div class=\"row\">\n";
        echo "<a href=\"" . $citation->open_url . "\">" . $citation->metadata->title ."</a><br/>\n";
        echo $citation->metadata->author ."<br/>\n";
        echo $citation->metadata->call_number ."<br/>\n";
        if ($citation->type == "BK") {
          $genre = "book";
          $resolver_tab = "getit";
        } elseif ($citation->type == "CR") {
          $genre = "book";
          $resolver_tab = "viewit";
        }
        echo "<iframe src=\"https://na01.alma.exlibrisgroup.com/view/uresolver/01CALS_USM/openurl?ctx_enc=info:ofi/enc:UTF-8&url_ctx_fmt=info:ofi/fmt:kev:mtx:ctx&url_ver=Z39.88-2004&ctx_enc=info:ofi/enc:UTF-&response_type=xml&isSerivcesPage=true&rft.btitle=";
        echo urlencode($citation->metadata->title) . "&rft.genre=";
        echo urlencode($genre) . "&rft.mms_id=";
        echo $citation->metadata->mms_id . "&rft.au=";
        echo urlencode($citation->metadata->author) . "&rft.title=";
        echo urlencode($citation->metadata->title) . "&customer=1670&rft_dat=language=eng,view=cals_usm_services_page&svc_dat=";
        echo $resolver_tab . "&svc.profile=";
        echo $resolver_tab . "&env_type=test&req.skin=csusm_uresolver\"></iframe>\n";
        echo "</div>\n";
      }
    }              
  }
}
include("footer.php");