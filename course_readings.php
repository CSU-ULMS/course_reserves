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

echo "<table class=\"table table-bordered\">\n";
echo "<tr>\n<th>Course</th>\n<td>\n";
echo $xml->name . "\n";
echo "</td>\n<tr>\n";
echo "<tr>\n<th>Department</th>\n<td>\n";
echo $xml->academic_department . "\n";
echo "<tr>\n<th>Term</th>\n<td>\n";
echo $xml->terms->term[0] . "\n";
echo "<tr>\n<th>Instructor</th>\n<td>\n";
echo $xml->instructors->instructor[0]->first_name . " ";
echo $xml->instructors->instructor[0]->last_name . "\n";
echo "</td>\n<tr>\n</table>\n";

echo "<div class=\"row\">\n";
echo "<table class=\"table table-bordered\" id=\"citationsTable\">\n";
echo "<thead>\n";
echo "<tr>\n";
echo "<th>Title</th>\n";
echo "<th>Author</th>\n";
echo "<th>Call Number</th>\n";
echo "<th>Pages</th>\n";
echo "<th>Public Note</th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
foreach ($xml->reading_lists->children() as $reading_list) {
  if ($reading_list->status['desc'] != "Inactive") {
    foreach ($reading_list->citations->citation as $citation) {
      if ($citation->status == "Complete" || $citation->status == "BeingPrepared") {
        echo "<tr>\n";
        if ($citation->type == "BK") {
          $genre = "book";
          $resolver_tab = "getit";
        } elseif ($citation->type == "CR" || $citation->type == "E_CR") {
          $genre = "article";
          $resolver_tab = "viewit";
        }
        echo "<td>\n";
        echo "<a href=\"" . $citation->open_url . "\">";
        if ($citation->type == "BK") {
          echo $citation->metadata->title;
        } elseif ($citation->type == "CR" || $citation->type == "E_CR") {
          echo $citation->metadata->article_title . "\n";
        }
        echo "</a>\n";
        echo "<iframe src=\"https://na01.alma.exlibrisgroup.com/view/uresolver/01CALS_USM/openurl?ctx_enc=info:ofi/enc:UTF-8&url_ctx_fmt=info:ofi/fmt:kev:mtx:ctx&url_ver=Z39.88-2004&ctx_enc=info:ofi/enc:UTF-&response_type=xml&isSerivcesPage=true&rft.btitle=";
        echo urlencode($citation->metadata->title) . "&rft.genre=";
        echo urlencode($genre) . "&rft.mms_id=";
        echo $citation->metadata->mms_id . "&rft.au=";
        echo urlencode($citation->metadata->author) . "&rft.title=";
        echo urlencode($citation->metadata->title) . "&customer=1670&rft_dat=language=eng,view=cals_usm_services_page&svc_dat=";
        echo $resolver_tab . "&svc.profile=";
        echo $resolver_tab . "&env_type=test&req.skin=csusm_uresolver\"></iframe>\n";
        echo "</td>\n";
        echo "<td>\n";
        echo $citation->metadata->author . "\n";
        echo "</td>\n";
        echo "<td>\n";
        if ($citation->type == "BK") {
          echo $citation->metadata->call_number ."\n";
        }
        echo "</td>\n";
        echo "<td>\n";
        if ($citation->type == "CR" || $citation->type == "E_CR") {
          echo $citation->metadata->pages . "\n";
        }
        echo "</td>\n";
        echo "<td>\n";
        if ($citation->public_note == "") {
          $order = "9999";
        } else {
          $order = $citation->public_note ;
        }
        echo $order . "\n";
        echo "</td>\n";
        echo "</tr>\n";
      }
    }              
  }
}
echo "</tbody>\n";
echo "</table>\n";
echo "</div>\n";
include("footer.php");