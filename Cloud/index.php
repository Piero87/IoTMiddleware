<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/login_check.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title>IoT Dashboard </title>

    <!-- Bootstrap -->
    <link href="gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- jVectorMap -->
    <link href="css/maps/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-empire"></i> <span>The Dark Side</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/DarthVader083111.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>Darth Vader</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
					<li>
						<a href="index.php"><i class="fa fa-home"></i> Dashboard</a>
					</li>
					<li>
						<a href="items_management.php"><i class="fa fa-cube"></i> Items Management</a>
					</li>
					<li>
						<a href="rules.php"><i class="fa fa-book"></i> Rules</a>
					</li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/DarthVader083111.jpg" alt="">Darth Vader
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="lib/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>

        </div>
        <!-- /top navigation -->


        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 100vh !important;">

          <br />
          <div class="">
            <div class="row top_tiles" id="widget_sensors">
              
            </div>
            <div id="widget_actuators">
              
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="js/custom.js"></script>
    
	<script src="js/socket.io.js"></script>
	
	<script type="text/javascript">
		
		load_widget_sensors();
		load_widget_actuators();
		
		function publish_key(key) {
		    alert(key);
		}
		
		function load_widget_sensors() {
			
			$.ajax({
			  url: "load_widget_sensors.php"
			}).done(function(data) { // data what is sent back by the php page
			  $('#widget_sensors').html(data); // display data
			  update_widget_sensors();
			});
		}
		
		function load_widget_actuators() {
			
			$.ajax({
			  url: "load_widget_actuators.php"
			}).done(function(data) { // data what is sent back by the php page
			  $('#widget_actuators').html(data); // display data
			});
		}
		
		function update_widget_sensors() {
			
			$.ajax({ 
			    type: 'GET', 
			    url: 'update_widget_sensors.php', 
			    dataType: 'json',
			    success: function (data) { 
			        $.each(data, function(index, element) {
				        $('#keyID_'+element.id).html(element.value);
			        });
			        setTimeout(update_widget_sensors, 3000);
			    }
			});
		}
		
		var socket = io.connect(document.location.origin+':5000',{
		    'reconnection': true,
		    'reconnectionDelay': 1000,
		    'reconnectionDelayMax' : 5000,
		    'reconnectionAttempts': 5
		});
		
		socket.on('connect', function () {
			console.log("Connected client");
		});
		
		function publish_key(topic_val,key_val) {
			
			socket.emit('publish_key',{topic:topic_val, key: key_val});
		}
		
		function publish_key_with_value(topic_val,key_val,key_id) {
			
			var key_value = $('#ValuekeyID_'+key_id).val();
			socket.emit('publish_key_with_value',{topic:topic_val, key: key_val, key_val: key_value});
		}
		
		
		
		
  
	</script>
  </body>
</html>