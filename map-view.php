<?php
    include 'config.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>User Locations</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="js/jquery.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN30MJ59z8mueWGFQ1WoGIRE0XorXIw-g"
              type="text/javascript"></script>
      <script type="text/javascript">
  
      var customIcons = {
        restaurant: {
          icon: 'map.png',
          shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
        },
        bar: {
          icon: 'map.png',
          shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
        }
      };
      function load() {
        var map = new google.maps.Map(document.getElementById("map"), {
          center: new google.maps.LatLng(20.2877143, 85.8435046),
          zoom: 11,
          mapTypeId: 'roadmap'
        });


        var infoWindow = new google.maps.InfoWindow;
        // Change this depending on the name of your PHP file
        downloadUrl("phpsqlajax_genxml.php?date=<?=$_GET['date']?>&user=<?=$_GET['user']?>", function(data) {
          var xml = data.responseXML;
          var markers = xml.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            var address = markers[i].getAttribute("address");
            var type = markers[i].getAttribute("type");
             var time = markers[i].getAttribute("time");
            var point = new google.maps.LatLng(
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lng")));
            var html = "<b>Name : " + name + " <br/>Time: " +time+" <br/> Location : " + address + "</b>";

            var icon = customIcons[type] || {};
            var marker = new google.maps.Marker({
              map: map,
              position: point,
              icon: icon.icon,
              shadow: icon.shadow,
             
            });

            marker.addListener('click', function() {
                map.setZoom(15);
                // map.setCenter(marker.getPosition());
              });
            bindInfoWindow(marker, map, infoWindow, html);
          }
        });

      }


      function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
          infoWindow.setContent(html);
          infoWindow.open(map, marker);
        });
      }
      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };
        request.open('GET', url, true);
        request.send(null);
      }
      function doNothing() {}
  
    </script>
    </head>

<body onload="load()">

    <div id="wrapper">

        <!-- Navigation -->
        <?php
            include 'nav.php';
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Location Tracker
                           
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-map-marker"></i> Location Tracker
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                  
                        <div id="map" style="height: 450px; width: 100% " ></div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
   

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
