<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/login_check.php';
	
	try
	{
		$db = new PDO("mysql:dbname=iot_tesi;host=localhost;charset=utf8", "piero", "pierino87",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	} catch(PDOException $e) {
		echo 'PDO ERROR: '.$e->getMessage();
	}
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
    <!-- Select2 -->
    <link href="gentelella-master/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
    
    <!-- PNotify -->
    <link href="gentelella-master/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="gentelella-master/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="gentelella-master/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- Magnific Popup -->
    <link href="css/magnific-popup/magnific-popup.css" rel="stylesheet">
    <style>
	    #small-dialog {
			background: white;
			padding: 20px 30px;
			text-align: left;
			max-width: 400px;
			margin: 40px auto;
			position: relative;
			}
			
			.vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
}
	</style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-empire fa-lg"></i> <span>The Dark Side</span></a>
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
			<div class="row">
				<div class="col-sm-12 col-sm-12" align="center">
					
					<div id="choose_management" class="btn-group" data-toggle="buttons">
    
		                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" id="option1">
		                  <input type="radio" name="options" value="1"> Gateway
		                </label>
		                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" id="option2">
		                  <input type="radio" name="options" value="2"> Sensor
		                </label>
		                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" id="option3">
		                  <input type="radio" name="options" value="3"> Actuator
		                </label>
		                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" id="option4">
		                  <input type="radio" name="options" value="4"> Subscription
		                </label>
		                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default" id="option5">
		                  <input type="radio" name="options" value="5"> Publish
		                </label>
	            	</div>
	            	
	            </div>
			</div>
			<br>
			<div class="row" id="add_gateway">
				<div class="form-group" align="center">
			        <div class="col-sm-6 col-sm-offset-3" align="center">
			            <input type="text" class="form-control" id="gateway_name" placeholder="Name" />
			            <button class="btn btn-default" style="margin-top: 10px;" onclick="addGateway()">Add</button>
			        </div>
			    </div>
			</div>
			<div class="row" id="add_sensor_actuator" style="display: none;">
				<div class="form-group" align="center">
			        <div class="col-sm-6 col-sm-offset-3">
			            <input type="text" class="form-control" id="sensor_actuator_name" placeholder="Name"/>
			        </div>
			    </div>
			    <div class="form-group" align="center">
                    <div class="col-sm-4 col-sm-offset-4" style="margin-top: 10px;">
                      <select class="select_gateway form-control" tabindex="-1" style="width: 200px !important;">
                        <option></option>
                      </select>
                    </div>
                </div>
                <div class="form-group" align="center">
			        <div class="col-sm-6 col-sm-offset-3">
			            <button class="btn btn-default" style="margin-top: 10px;" onclick="addSensor_Actuator()">Add</button>
			        </div>
			    </div>
			</div>
			<div class="row" id="add_subscribe_publish_topic" style="display: none;">
				<div class="form-group" align="center">
                    <div class="col-sm-4 col-sm-offset-4" style="margin-bottom: 10px;">
                      <select class="select_sensor_actuator form-control" tabindex="-1" style="width: 300px !important;">
                        <option></option>
                      </select>
                    </div>
                </div>
                <div class="form-group" align="center" id="select_widget_view">
                    <div class="col-sm-4 col-sm-offset-4" style="margin-bottom: 10px;">
                      <select class="select_widget_view form-control" tabindex="-1" style="width: 200px !important;">
                        <option></option>
                        <option value="0">Button View</option>
                        <option value="1">Field View</option>
                      </select>
                    </div>
                </div>
                <br>
				<div class="form-group" align="center">
			        <div class="col-sm-4 col-sm-offset-2">
			            <input type="text" class="form-control" id="topic_name" placeholder="Topic"/>
			        </div>
			        <div class="col-sm-3">
			            <input type="text" class="form-control" name="topic_keys[]" placeholder="Key"/>
			        </div>
			        <div class="col-sm-2">
			            <button type="button" class="btn btn-default addKeyButton"><i class="fa fa-plus"></i></button>
			        </div>
			    </div>
			    
			    <div class="form-group hide" align="center" id="key_template">
			        <div class="col-sm-4 col-sm-offset-2">
			            
			        </div>
			        <div class="col-sm-3">
			            <input type="text" class="form-control" name="topic_keys[]" placeholder="Key"/>
			        </div>
			        <div class="col-sm-2">
			            <button type="button" class="btn btn-default removeKeyButton"><i class="fa fa-minus"></i></button>
			        </div>
			    </div>
			    
			    <div class="form-group" align="center">
			        <div class="col-sm-6 col-sm-offset-3">
			            <button class="btn btn-default" style="margin-top: 10px;" onclick="addPublish_Subscribe_Topic()">Add</button>
			        </div>
			    </div>
        	</div>
        	<br>
        	<hr>
        	<div class="row">
        		<div class="accordion col-sm-12 col-xs-12" id="items_added" role="tablist" aria-multiselectable="true">
	        		
        		</div>
        	</div>
        	<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
				<div id="body_alert_popup">
					<div class="row col-sm-12">
						<h2 align="center" style="margin-bottom: 20px;">Are you sure you wanna delete this?</h2>
					</div>
					<div class="row" id="alert_buttons" align="center">
						<button class="btn btn-danger col-sm-3 col-sm-offset-2" id="yes_delete_btn" onclick="">Yes</button>
						<button class="btn btn-default col-sm-3 col-sm-offset-2" onclick="dismiss_alert()">No</button>	
					</div>
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
    <!-- Select2 -->
    <script src="gentelella-master/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="js/custom.js"></script>
    
	<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
	
	<script src="js/jquery-loading-overlay/loadingoverlay.min.js"></script>
	
	<!-- PNotify -->
    <script src="gentelella-master/vendors/pnotify/dist/pnotify.js"></script>
    <script src="gentelella-master/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="gentelella-master/vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- Magnific Popup -->
    <script src="js/magnific-popup/jquery.magnific-popup.min.js"></script>
    
	<script type="text/javascript">
		
		$(document).ready(function() {
			
			$('.popup-with-move-anim').magnificPopup({
				type: 'inline',
		
				fixedContentPos: false,
				fixedBgPos: true,
		
				overflowY: 'auto',
		
				closeBtnInside: true,
				preloader: false,
				
				midClick: true,
				removalDelay: 300,
				mainClass: 'my-mfp-slide-bottom'
			});
			
			$(".select_gateway").select2({
	          placeholder: "Connect to a gateway",
	          allowClear: true
	        });
	        $(".select_sensor_actuator").select2({
	          placeholder: "Connect to a sensor/actuator",
	          allowClear: true
	        });
			$(".select_widget_view").select2({
	          placeholder: "Select widget view",
	          allowClear: true
	        });
			
			$('#option1').addClass("active").siblings().removeClass("active");
			
			loadItems();
			loadSelectGateways();
			loadSelectSensorsActuators();
		});  
		
		function dismiss_alert () {
			$.magnificPopup.close();
		}
		
		function show_alert(type,id) {
			
			if (type == 'topic') {
				
				$("#yes_delete_btn").attr("onclick","delete_topic("+id+")");
				
			} else if (type == 'sensor_actuator') {
				
				$("#yes_delete_btn").attr("onclick","delete_sensor_actuator("+id+")");
				
			}  else if (type == 'gateway') {
				
				$("#yes_delete_btn").attr("onclick","delete_gateway("+id+")");
			}
			
			$.magnificPopup.open({
		        items: {
		            src: '#small-dialog' 
		        },
		        type: 'inline'
		    });
			
		}
		
		function delete_topic(id_topic) {
			
			dismiss_alert();
			
			$.LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
			var m_data = new FormData();    
            m_data.append( 'request', 'delete_topic');
            m_data.append( 'id_topic', id_topic);
            
		    $.ajax({ 
			    type: 'POST', 
			    url: '/lib/items_management_ajax.php',
			    data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
                dataType:'json',
			    success: function (data) { 
			       $.LoadingOverlay("hide");
			       
			       if (data.success == 1) {
					   	loadItems();
			       } else {
				    	new PNotify({
					       title: 'Oh No!',
						   text: data.error_msg,
						   type: 'error',
						   styling: 'bootstrap3'
						});
			       }
			    }
			});
		}
		
		function delete_sensor_actuator(id_sensor_actuator) {
			
			dismiss_alert();
			
			$.LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
			var m_data = new FormData();    
            m_data.append( 'request', 'delete_sensor_actuator');
            m_data.append( 'id_sensor_actuator', id_sensor_actuator);
            
		    $.ajax({ 
			    type: 'POST', 
			    url: '/lib/items_management_ajax.php',
			    data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
                dataType:'json',
			    success: function (data) { 
			       $.LoadingOverlay("hide");
			       
			       if (data.success == 1) {
					   	loadItems();
			       } else {
				    	new PNotify({
					       title: 'Oh No!',
						   text: data.error_msg,
						   type: 'error',
						   styling: 'bootstrap3'
						});
			       }
			    }
			});
			
		}
		
		function delete_gateway(id_gateway) {
			
			dismiss_alert();
			
			$.LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
			var m_data = new FormData();    
            m_data.append( 'request', 'delete_gateway');
            m_data.append( 'id_gateway', id_gateway);
            
		    $.ajax({ 
			    type: 'POST', 
			    url: '/lib/items_management_ajax.php',
			    data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
                dataType:'json',
			    success: function (data) { 
			       $.LoadingOverlay("hide");
			       
			       if (data.success == 1) {
					   	loadItems();
			       } else {
				    	new PNotify({
					       title: 'Oh No!',
						   text: data.error_msg,
						   type: 'error',
						   styling: 'bootstrap3'
						});
			       }
			    }
			});
			
		}
		
		var selected = 1;
		
		function hasWhiteSpace(s) {
		  return s.indexOf(' ') >= 0;
		}
	        
		$("#choose_management :input").change(function() {
			
		    selected = parseInt($(this).attr('value'));

		    if (selected == 1) {
			    if(!$('#add_gateway').is(':visible')) {
				    $("#add_sensor_actuator").slideUp();
				    $("#add_subscribe_publish_topic").slideUp();
				    $("#add_gateway").delay(400).slideDown();
			    }
			    
		    } else if (selected == 2 || selected == 3) {
			    if(!$('#add_sensor_actuator').is(':visible')) {
				    $("#add_gateway").slideUp();
				    $("#add_subscribe_publish_topic").slideUp();
				     $("#add_sensor_actuator").delay(400).slideDown();
			    }
		    } else if (selected == 4 || selected == 5) {
			    
			    if (selected == 4) {
				    $("#select_widget_view").show();
			    } else if (selected == 5) {
				    $("#select_widget_view").hide();
			    }
			    if(!$('#add_subscribe_publish_topic').is(':visible')) {			    
				    $("#add_gateway").slideUp();
				    $("#add_sensor_actuator").slideUp();
				    $("#add_subscribe_publish_topic").delay(400).slideDown();
			    }
		    }
			
		});

		$('#add_subscribe_publish_topic').on('click', '.addKeyButton', function() {
            var $template = $('#key_template'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template),
                $option   = $clone.find('[name="topic_key[]"]');
        });
        


        $('#add_subscribe_publish_topic').on('click', '.removeKeyButton', function() {
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="topic_key[]"]');

            // Remove element containing the option
            $row.remove();
        });
	    
	    function loadItems() {
		    $.ajax({
			  url: "load_items_management.php"
			}).done(function(data) {
			  $('#items_added').html(data);
			});
	    }
	    
	    function loadSelectGateways() {
		    
		    var m_data = new FormData();    
            m_data.append( 'request', 'update_gateways_select');
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/items_management_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) { 
				    $('.select_gateway').empty();
				    $('.select_gateway').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_gateway').append($('<option>', {
						    value: element.id,
						    text: element.name
						}));
			        });
			    }
			});
	    }
	    
	    function loadSelectSensorsActuators() {
		    
		    var m_data = new FormData();    
            m_data.append( 'request', 'update_sensors_actuators_select');
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/items_management_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) { 
				    $('.select_sensor_actuator').empty();
				    $('.select_sensor_actuator').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_sensor_actuator').append($('<option>', {
						    value: element.id,
						    text: element.name+" ("+element.type+")"
						}));
			        });
			    }
			});
	    }
	    
		function addGateway() {
			
			var gateway_name = $('#gateway_name').val();
			
			if (hasWhiteSpace(gateway_name)) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You cannot use whitespaces in the gateway name',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else if (/\S/.test(gateway_name))
			{
				// string is not empty and not just whitespace
				
				$.LoadingOverlay("show", {
				    image       : "",
				    fontawesome : "fa fa-empire fa-spin"
				});
			
				var m_data = new FormData();    
	            m_data.append( 'request', 'add_gateway');
	            m_data.append( 'name',  gateway_name);
	            
				$.ajax({ 
				    type: 'POST', 
				    url: '/lib/items_management_ajax.php',
				    data: m_data,
				    contentType: false,
	                processData: false,
	                cache: false,
	                dataType:'json',
				    success: function (data) { 
				       $.LoadingOverlay("hide");
				       
				       if (data.success == 1) {
						   	loadItems();
						   	loadSelectGateways();
				       } else {
					    	new PNotify({
						       title: 'Oh No!',
							   text: data.error_msg,
							   type: 'error',
							   styling: 'bootstrap3'
							});
				       }
				    }
				});
			} else {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to insert a name',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			}
			
        }
        
        function addSensor_Actuator() {
			
	        var sensor_actuator_name = $('#sensor_actuator_name').val();
			var id_gateway = $('.select_gateway option:selected').val();
			
			if (!/\S/.test(id_gateway)) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to select a gateway',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else if (/\S/.test(sensor_actuator_name))
			{
				// string is not empty and not just whitespace
				$.LoadingOverlay("show", {
				    image       : "",
				    fontawesome : "fa fa-empire fa-spin"
				});
			
				var m_data = new FormData();    
	            m_data.append( 'name',  sensor_actuator_name);
	            m_data.append( 'id_gateway', id_gateway);
	            
		        if (selected == 2) {
			        //sensor
			        m_data.append( 'request', 'add_sensor');
		        } else {
			        //actuator
			        m_data.append( 'request', 'add_actuator');
		        }
		        
		        $.ajax({ 
				    type: 'POST', 
				    url: '/lib/items_management_ajax.php',
				    data: m_data,
				    contentType: false,
	                processData: false,
	                cache: false,
	                dataType:'json',
				    success: function (data) { 
				       $.LoadingOverlay("hide");
	
				       if (data.success == 1) {
					       //load new element and refresh select content
						   loadItems();
						   loadSelectSensorsActuators();
				       } else {
					    	new PNotify({
						       title: 'Oh No!',
							   text: data.error_msg,
							   type: 'error',
							   styling: 'bootstrap3'
							});
				       }
				    }
				});
			} else {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to insert a name',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			}
	        
        }
        
        function addPublish_Subscribe_Topic() {
			
			var topic_name = $('#topic_name').val();
			var id_sensor_actuator = $('.select_sensor_actuator option:selected').val();
			var keys = new Array();
			var keys = $("input[name='topic_keys[]']").map(function(){return $(this).val();}).get();
			var widget_view = $('.select_widget_view option:selected').val();
			//Togli elementi vuoti
			keys = keys.filter(function(e){return e}); 
			
			if (!/\S/.test(id_sensor_actuator)) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to select a sensor or actuator first',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else if (selected == 4 && !/\S/.test(widget_view)) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to select the widget view first',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else if (!/\S/.test(topic_name)) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'The topic is empty.',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else if (hasWhiteSpace(topic_name)) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You cannot use whitespaces in the topic name',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else if (keys.length == 0) {
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to add at least one key',
				   type: 'error',
				   styling: 'bootstrap3'
				});
			} else {
				
				$.LoadingOverlay("show", {
				    image       : "",
				    fontawesome : "fa fa-empire fa-spin"
				});
			
				var m_data = new FormData();    
	            m_data.append( 'name',  topic_name);
	            m_data.append( 'id_sensor_actuator', id_sensor_actuator);
	            m_data.append( 'keys', keys);
	            
		        if (selected == 4) {
			        //subscribe
			        m_data.append( 'request', 'add_subscribe_topic');
			        m_data.append( 'widget_view', widget_view);
		        } else {
			        //publish
			        m_data.append( 'request', 'add_publish_topic');
		        }
		        
		        $.ajax({ 
				    type: 'POST', 
				    url: '/lib/items_management_ajax.php',
				    data: m_data,
				    contentType: false,
	                processData: false,
	                cache: false,
	                dataType:'json',
				    success: function (data) { 
				       $.LoadingOverlay("hide");
	
				       if (data.success == 1) {
					       //load new element and refresh select content
						   loadItems();
				       } else {
					    	new PNotify({
						       title: 'Oh No!',
							   text: data.error_msg,
							   type: 'error',
							   styling: 'bootstrap3'
							});
				       }
				    }
				});
			}
        }
	</script>
  </body>
</html>