<?php
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
    <title>Course Reserves</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
    <style type="text/css">
      iframe {width: 100%; max-width: 900px;min-height: 170px;border: 1px solid #ddd;padding: 0 20px;}
    </style>

    <!-- Latest compiled and minified JavaScript -->
    <script>
    $(document).ready(function() 
      { 
        $("#coursesTable").dataTable({
          "order": [[ 0, "asc" ]],
          "lengthMenu": [[-1, 25, 50], ["All", 25, 50]]
        }); 
        $("#citationsTable").dataTable({
          "order": [[ 4, "asc" ], [ 0, "asc" ]],
          "lengthMenu": [[-1, 25, 50], ["All", 25, 50]]
        }); 
      }); 
    </script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
        <h3 class="text-muted">Course Reserves</h3>
      </div>
      <div class="row">