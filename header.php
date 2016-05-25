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
    <script type="text/javascript" src="iframe-resizer/src/iframeResizer.js"></script>
    <style type="text/css">
      iframe {display: none;}
      iframe.visible {display: block; width: 100%; max-height: 100%; min-height: 250px; border: 1px solid #ddd;padding: 0 20px;}
    </style>

    <!-- Latest compiled and minified JavaScript -->
    <script>
    $(document).ready(function() 
      { 
        $("#coursesTable").dataTable({
          "order": [[ 0, "asc" ]],
          "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],
          "dom": '<"top"lif>rt<"bottom"p>'
        }); 
        $("#citationsTable").dataTable({
          "order": [[ 4, "asc" ], [ 0, "asc" ]],
          "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],
          "dom": '<"top"ifl>rt<"bottom"p>'
        }); 
        $('iframe.visible').iFrameResize({"checkOrigin": false});
        $("a.getinfo").click(function(e) {
          e.preventDefault();
          $(this).parents('.iteminfo').children('iframe').attr("src", $(this).attr("href"));
          $(this).parents('.iteminfo').children('iframe').toggleClass("visible");
        })
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
    <div class="container-fluid">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Course Reserves</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="http://biblio.csusm.edu/">Library Home Page</a></li>
            <li><a href="https://na01.alma.exlibrisgroup.com/institution/01CALS_USM">Alma</a></li>
            <li><a href="http://primo-pmtna01.hosted.exlibrisgroup.com/primo_library/libweb/action/search.do?mode=Basic&vid=CALS_USM&tab=cals_usm_cr&">Reserves</a></li>
            <li><a href="https://lib.csusm.edu/helpdesk/">Library Technology Support</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    <div class="container">
      <div class="row">