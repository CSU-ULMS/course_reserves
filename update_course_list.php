<?php
require("config.php");
$coursesheader = new DOMDocument();
$coursesheader->loadXML("<coursesheaderdata/>");
$chrxml = $coursesheader->createDocumentFragment();
$queryParamSpecs = '?' . urlencode('limit') . '=' . urlencode('limitNum') . '&' . urlencode('offset') . '=' . urlencode('offSetNum') . '&' . urlencode('order_by') . '=' . urlencode('name') . '&' . urlencode('direction') . '=' . urlencode('ASC') . '&';

$chrresponse = apiconnect(0, "", $queryParamSpecs, $apiurl, $apikey, 1);

$chrfragment = substr($chrresponse, strpos($chrresponse, '?'.'>') + 2);
$chrxml = "<?xml version=\"1.0\"?><coursedata>". $chrfragment . "</coursedata>";
$chrxml2 = new SimpleXMLElement($chrxml);
$totcount = $chrxml2->courses[0]['total_record_count'];

$topnum = intval($totcount/100);
$x = 0; 

$file = "courses_body.php";
$handle = fopen($file, 'w') or die("can't open file");
fwrite($handle, "");
fclose($handle);

while($x <= $topnum) {
	$offset = $x*100;
  getcoursedata($file, $offset, $queryParamSpecs, $apiurl, $apikey);
  $x++;
} 
$handle = fopen($file, 'a') or die("can't open file");
fwrite($handle, "</tbody></table>");
fwrite($handle, "<div>" . date("Y-m-d H:i:s") . "</div>");
fclose($handle);

date_default_timezone_set('America/Los_Angeles');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Update Complete!</title>

    <!-- Bootstrap core CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/yeti/bootstrap.min.css" rel="stylesheet" integrity="sha256-gJ9rCvTS5xodBImuaUYf1WfbdDKq54HCPz9wk8spvGs= sha512-weqt+X3kGDDAW9V32W7bWc6aSNCMGNQsdOpfJJz/qD/Yhp+kNeR+YyvvWojJ+afETB31L0C4eO0pcygxfTgjgw==" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="http://biblio.csusm.edu/">Library Home Page</a></li>
            <li role="presentation"><a href="https://na01.alma.exlibrisgroup.com/institution/01CALS_USM">Alma</a></li>
            <li role="presentation"><a href="http://primo-pmtna01.hosted.exlibrisgroup.com/primo_library/libweb/action/search.do?mode=Basic&vid=CALS_USM&tab=cals_usm_cr&">Reserves</a></li>
            <li role="presentation"><a href="https://lib.csusm.edu/helpdesk/">Library Technology Support</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Updater for Reserves Course Entries</h3>
      </div>
      <div class="jumbotron">
        <h1>Update Complete!</h1>
        	<h2>Need Help?</h2>
        	<p class="lead">
        		<a href="https://lib.csusm.edu/helpdesk/" target="_blank">Library Technology Support</a>
        	</p>
      </div>
      <footer class="footer">
        <p></p>
      </footer>
    </div> <!-- /container -->
  </body>
</html>
<?php

function getcoursedata($file, $offset, $queryParamSpecs, $apiurl, $apikey){
	$apiSpec = "";
	$xmlString = apiconnect($offset, $apiSpec, $queryParamSpecs, $apiurl, $apikey);
  $xml = simplexml_load_string($xmlString);
  $courseListTableEntries = "";

	$handle = fopen($file, 'a') or die("can't open file");

	foreach($xml->course as $course)
	{
		if (strtolower($course->status) == "active"){
      $queryParamSpecs = $course->id . "/reading-lists/?";
      $rlist_data = apiconnect($offset, $apiSpec, $queryParamSpecs, $apiurl, $apikey);
      $readinglistxml = simplexml_load_string($rlist_data);
      foreach($readinglistxml->reading_list as $reading_list) {
        if ($reading_list->status == "Complete") {
          $courseListTableEntries .= "<tr>\n<td>\n";
          $courseListTableEntries .=  "<a href=\"course_readings.php?cid=" . $course->id . "\">";
          $courseListTableEntries .=  $course->name;
          $courseListTableEntries .=  "</a></td>\n<td>";
          if ($course->instructors[0]->instructor->last_name != ""){
            $courseListTableEntries .= $course->instructors[0]->instructor->last_name . ", " . $course->instructors[0]->instructor->first_name;
          }
          $courseListTableEntries .= "</td></tr>\n";
          break;    
        }
      }
		}
	}

	fwrite($handle, $courseListTableEntries);
	fclose($handle);

}

function apiconnect($offset, $apiSpec = "", $queryParamSpecs = "", $apiurl, $apikey, $queryLimit = 100){
  $ch = curl_init();

  if ($queryParamSpecs != ""){
  	$queryParamSpecs = str_replace("offSetNum", $offset, $queryParamSpecs);
	  $queryParamSpecs = str_replace("limitNum", $queryLimit, $queryParamSpecs);
  }

	$apiurl = $apiurl . $apiSpec;
	$queryParams = $queryParamSpecs . urlencode('apikey') . '=' . $apikey;
	curl_setopt($ch, CURLOPT_URL, $apiurl . $queryParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$xmlresponse = curl_exec($ch);
	curl_close($ch);
  return $xmlresponse;
}
?>