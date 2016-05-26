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
echo "<div class=\"col-sm-11 col-sm-offset-1\">\n";
echo "<div class=\"page-header\">\n";
echo "<h1 class=\"page-title\">" . $xml->name . "</h1>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "<div class=\"row\">\n";
echo "<div class=\"col-sm-3 col-sm-offset-1\">\n";
echo "<div class=\"panel panel-default\">\n";
echo "<div class=\"panel-heading\"><h3 class=\"panel-title\">Course Information</h3></div>\n";
echo "<table class=\"table table-bordered\">\n";
echo "<tr>\n<th>Instructor</th>\n<td>\n";
echo $xml->instructors->instructor[0]->first_name . " ";
echo $xml->instructors->instructor[0]->last_name . "\n";
echo "</td>\n<tr>\n";
echo "<tr>\n<th>Department</th>\n<td>\n";
echo $xml->academic_department . "\n";
echo "</td>\n<tr>\n";
echo "<tr>\n<th>Terms</th>\n<td>\n";
if (isset($xml->terms)) {
  foreach ($xml->terms->children() as $term) {
    echo ucwords(strtolower($term)) . " / \n";
  } 
} else {
  echo "N/A";
}
echo "</td>\n<tr>\n";
echo "<tr>\n<th>Course Details</th>\n<td>\n";
echo "<div>Status: " . ucfirst(strtolower($xml->status)) . "</div>\n";
echo "<div>Processing Department: " . $xml->processing_department['desc'] . "</div>\n";
echo "<div>Start Date: " . $xml->start_date . "</div>\n";
echo "<div>End Date: " . $xml->end_date . "</div>\n";
echo "<div>Code: " . $xml->code . "</div>\n";
echo "<div>Alma ID: " . $xml->id . "</div>\n";
echo "</td>\n</tr>\n</table>\n";
echo "</div>\n";
echo "</div>\n";
echo "<div class=\"col-sm-8\">\n";
echo "<div class=\"reading-lists-wrapper\">\n";
foreach ($xml->reading_lists->children() as $reading_list) {
  if ($reading_list->status['desc'] != "Inactive") {
    echo "<div class=\"row\">\n";
    echo "<h3>Reading Lists for this Course</div>\n";
    echo "<div>Name: " . $reading_list->name . "</div>\n";
    echo "<div>Status: " . $reading_list->status['desc'] . "</div>\n";
    echo "<div>Code: " . $reading_list->code . "</div>\n";
    echo "<div>Alma ID: " . $reading_list->id . "</div>\n";
    echo "<table class=\"table table-bordered\" id=\"citationsTable\">\n";
    echo "<thead>\n";
    echo "<tr>\n";
    echo "<th>Order</th>\n";
    echo "<th>Title</th>\n";
    echo "<th>Author</th>\n";
    echo "<th>Call Number</th>\n";
    echo "<th>Pages</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    foreach ($reading_list->citations->citation as $citation) {
      if ($citation->status == "Complete" || $citation->status == "BeingPrepared") {
        echo "<tr>\n";
        if ($citation->type == "BK") {
          $genre = "book";
          $resolver_tab = "getit";
          $itemtitle = $citation->metadata->title;
        } elseif ($citation->type == "CR" || $citation->type == "E_CR") {
          $genre = "article";
          $resolver_tab = "viewit";
          $itemtitle = $citation->metadata->article_title;
        }
        echo "<td>\n";
        if ($citation->public_note == "") {
          $order = "9999";
        } else {
          $order = $citation->public_note ;
        }
        echo $order . "\n";
        echo "</td>\n";
        echo "<td>\n";
        echo "<div class=\"iteminfo\"><div>Title: <a class=\"getinfo\" href=\"https://na01.alma.exlibrisgroup.com/view/uresolver/01CALS_USM/openurl?ctx_enc=info:ofi/enc:UTF-8&url_ctx_fmt=info:ofi/fmt:kev:mtx:ctx&url_ver=Z39.88-2004&ctx_enc=info:ofi/enc:UTF-&response_type=xml&isSerivcesPage=true&rft.btitle=";
          echo urlencode($itemtitle) . "&rft.genre=";
          echo urlencode($genre) . "&rft.mms_id=";
          echo $citation->metadata->mms_id . "&rft.au=";
          echo urlencode($citation->metadata->author) . "&rft.title=";
          echo urlencode($itemtitle) . "&customer=1670&rft_dat=language=eng,view=cals_usm_services_page&svc_dat=";
          echo $resolver_tab . "&svc.profile=";
          echo $resolver_tab . "&env_type=test&req.skin=csusm_uresolver\">\n";
          echo $itemtitle . "</a></div>\n";
        if ($citation->type == "BK") {
          echo "<div>Publisher: " . $citation->metadata->publisher . "</div>\n";
          echo "<div>Publication Date: " . $citation->metadata->publication_date . "</div>\n";
        } 
        echo "<div>Status: " . $citation->status['desc'] . "</div>\n";
        echo "<div>Citation ID: " . $citation->id . "</div>\n";
        echo "<iframe src=\"\"></iframe></div>";
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
        echo "</tr>\n";
      }
    }              
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div>\n";
  }
}
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

include("footer.php");