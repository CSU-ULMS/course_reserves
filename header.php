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
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/yeti/bootstrap.min.css" rel="stylesheet" integrity="sha384-yxFy3Tt84CcGRj9UI7RA25hoUMpUPoFzcdPtK3hBdNgEGnh9FdKgMVM+lbAZTKN2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
     
    <style type="text/css">
      iframe {display: none;}
      iframe.visible {display: block; width: 100%; max-height: 100%; min-height: 250px; border: 1px solid #ddd;padding: 0 20px;}
      .reading-lists-wrapper {margin: 0 7.5% 30px 30px;}
      .header-row .bg-info {margin-top: 10px; padding: 6px 12px;}
      div.dataTables_wrapper div.dataTables_filter {text-align: left;}
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/datatables.min.js"></script>
    <script type="text/javascript" src="iframe-resizer/src/iframeResizer.js"></script>
    <script>
      $(document).ready(function() { 
        $("#coursesTable").dataTable({
          "order": [[ 0, "asc" ]],
          "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],
          "dom": "<'row header-row'<'col-sm-3'f><'col-sm-5'i><'col-sm-2'><'col-sm-2'<'pull-right'B>>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-9'i><'col-sm-3'p>>",
          "buttons": ['excel', 'print']
        }); 
        $("#citationsTable").dataTable({
          "order": [[ 0, "asc" ], [ 1, "asc" ]],
          "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],
          "dom": "<'row header-row'<'col-sm-9'<i>><'col-sm-3'<'pull-right'B>>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-9'i><'col-sm-3'>>",
          "buttons": ['excel', 'print']
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
            <a class="navbar-brand" href="/reserves">Course Reserves</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="http://biblio.csusm.edu/">Library Home Page</a></li>
            <li><a href="/reserves">Reserves</a></li>
            <li><a href="https://lib.csusm.edu/helpdesk/">Library Technology Support</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    <div class="container-fluid">