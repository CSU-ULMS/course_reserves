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

function bibLookup($mmsID) {
  $ch = curl_init();
  $url = 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/bibs/{mms_id}';
  $templateParamNames = array('{mms_id}');
  $templateParamValues = array($mmsID);
  $url = str_replace($templateParamNames, $templateParamValues, $url);
  $queryParams = '?' . urlencode('view') . '=' . urlencode('brief') . '&' . urlencode('expand') . '=' . urlencode('p_avail') . '&' . urlencode('apikey') . '=' . urlencode('l7xx43a08472cc9349ddb652140de10b9279');
  curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  $response = curl_exec($ch);
  curl_close($ch);

  return($response);
}
//$responsedata = substr($response, strpos($response, '?'.'>') + 2);
//$f->appendXML($responsedata);
//$coursedata->documentElement->appendChild($f);
$xml = new SimpleXMLElement($response);

include("header.php");
echo "<div class=\"row\">\n";
  echo "<div class=\"col-sm-12\">\n";
    echo "<div class=\"page-header\">\n";
      echo "<h1 class=\"page-title\">" . $xml->name . "</h1>\n";
    echo "</div>\n";
  echo "</div>\n";
echo "</div>\n";
echo "<div class=\"row\">\n";
  echo "<div class=\"col-sm-12\">\n";
    echo "<p>\n";
      echo $xml->instructors->instructor[0]->first_name . " ";
      echo $xml->instructors->instructor[0]->last_name;
    echo "</p>\n";
    echo "<div class=\"reading-lists-wrapper\">\n";
      foreach ($xml->reading_lists->children() as $reading_list) {
        if ($reading_list->status['desc'] != "Inactive") {
          echo "<div class=\"row\">\n";
          echo "<h3>Reading Lists for this Course</div>\n";
          //echo "<h4>Reading List Name: " . $reading_list->name . "</h4>\n";
          echo "<table class=\"table\" id=\"citationsTable\">\n";
          echo "<thead>\n";
          echo "<tr>\n";
          echo "<th class='reading-order-col'>Reading Order</th>\n";
          echo "<th class='item-title-col'>Title</th>\n";
          echo "<th class='author-col'>Author</th>\n";
          echo "</tr>\n";
          echo "</thead>\n";
          echo "<tbody>\n";
          foreach ($reading_list->citations->citation as $citation) {
            if ($citation->status == "Complete" || $citation->status == "BeingPrepared") {
              echo "<tr>\n";
              if ($citation->type == "BK") {
                if ($citation->metadata->title != "") {
                  $itemtitle = $citation->metadata->title;
                } else {
                  $bibData = bibLookup($citation->metadata->mms_id);
                  $bibxml = new SimpleXMLElement($bibData);
                  $itemtitle = $bibxml->title;
                  $bookAuthor = $bibxml->author;
                }
                //print_r($bibxml);
                $genre = "book";
                $resolver_tab = "getit";
              } elseif ($citation->type == "CR" || $citation->type == "E_CR") {
                $genre = "article";
                $resolver_tab = "viewit";
                $itemtitle = $citation->metadata->article_title;
              }
              echo "<td>\n";
              if ($citation->public_note == "") {
                $order = "<span class=\"hidden\">9999</span>";
              } else {
                $order = $citation->public_note ;
              }
              echo $order . "\n";
              echo "</td>\n";
              echo "<td>\n";
              echo "<div class=\"iteminfo\"><div><a class=\"getinfo\" href=\"https://na01.alma.exlibrisgroup.com/view/uresolver/01CALS_USM/openurl?ctx_enc=info:ofi/enc:UTF-8&url_ctx_fmt=info:ofi/fmt:kev:mtx:ctx&url_ver=Z39.88-2004&ctx_enc=info:ofi/enc:UTF-&response_type=xml&isSerivcesPage=true&rft.btitle=";
                echo urlencode($itemtitle) . "&rft.genre=";
                echo urlencode($genre) . "&rft.mms_id=";
                echo $citation->metadata->mms_id . "&rft.au=";
                echo urlencode($citation->metadata->author) . "&rft.title=";
                echo urlencode($itemtitle) . "&customer=1670&rft_dat=language=eng,view=cals_usm_services_page&svc_dat=";
                echo $resolver_tab . "&svc.profile=";
                echo $resolver_tab . "&env_type=test&req.skin=csusm_uresolver\">\n";
                echo $itemtitle . "</a></div>\n";
              //if ($citation->type == "BK") {
                //echo "<div>Publisher: " . $citation->metadata->publisher . "</div>\n";
                //echo "<div>Publication Date: " . $citation->metadata->publication_date . "</div>\n";
              //} 
              echo "<div class=\"hidden\">Status: " . $citation->status['desc'] . "</div>\n";
              echo "<div class=\"hidden\">Citation ID: " . $citation->id . "</div>\n";
              echo "<iframe src=\"\"></iframe></div>";
              echo "</td>\n";
              echo "<td>\n";
              if ($citation->type == "BK") {
                echo $bookAuthor . "\n";
              } else {
                echo $citation->metadata->author . "\n";
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
      echo "<div class=\"hidden\">Course Status: " . ucfirst(strtolower($xml->status)) . "</div>\n";
      echo "<div class=\"hidden\">Course Processing Department: " . $xml->processing_department['desc'] . "</div>\n";
      echo "<div class=\"hidden\">Course Start Date: " . $xml->start_date . "</div>\n";
      echo "<div class=\"hidden\">Course End Date: " . $xml->end_date . "</div>\n";
      echo "<div class=\"hidden\">Course Code: " . $xml->code . "</div>\n";
      echo "<div class=\"hidden\">Course Alma ID: " . $xml->id . "</div>\n";
      echo "<div class=\"hidden\">Reading List Status: " . $reading_list->status['desc'] . "</div>\n";
      echo "<div class=\"hidden\">Reading List Code: " . $reading_list->code . "</div>\n";
      echo "<div class=\"hidden\">Reading List Alma ID: " . $reading_list->id . "</div>\n";
    echo "</div>\n";
  echo "</div>\n";
echo "</div>\n";
include("footer.php");