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
	    #small-dialog, #dialog_delete_rule {
	background: white;
	padding: 20px 30px;
	text-align: left;
	max-width: 400px;
	margin: 40px auto;
	position: relative;
}

#body_popup{
  /* Overflow Scroll */
  overflow-y: scroll;
max-height: 80vh;
padding: 20px 30px;
}
	</style>
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
				<div class="row">
					<div class="col-sm-2">
						<h1>Rules</h1>
					</div>
			  		<a class="popup-with-move-anim" href="#small-dialog">
				  		<div class="col-sm-1" align="left">
			            	<button class="btn btn-default" style="margin-top: 10px;" onclick="load_1();">Add Rule</button>
			        	</div>
			        </a>
			        <br>
				</div>
				
				<div id="rules_added">
				</div>
				
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
					<div id="body_popup">
					<div class="row">
						<h1 align="center">Add Rule</h1>
					</div>
					<div class="row" id="loader_rule" style="align-content: center; width:50px; height:50px;">
						
					</div>
					<div class="row" style="display: none;" id="sensor_actuator_container">
						<div class="col-sm-12" align="center">
	                      <select class="select_sensor_actuator" tabindex="-1">
	                        <option></option>
	                      </select>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="topic_container">
						<div class="col-sm-12" align="center">
	                      <select class="select_topic" tabindex="-1">
	                        <option></option>
	                      </select>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="key_container">
						<div class="col-sm-12" align="center">
	                      <select class="select_key" tabindex="-1">
	                        <option></option>
	                      </select>
						</div>
                    </div>
                    
                    <div class="row" style="display: none; margin-top: 20px;" id="condition_container">
	                    <label>Condition:</label>
						<div class="col-sm-12" align="center">
	                      <select class="select_condition_type" tabindex="-1">
	                        <option></option>
	                        <option value="none">No value needed</option>
	                        <option value="<">&lt;</option>
	                        <option value=">">&gt;</option>
	                        <option value="=">=</option>
	                      </select>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="value_container">
	                    <label>Value:</label>
						<div class="col-sm-12" align="center" style="">
							<input type="text" id="condition_value" class="form-control" placeholder="value" style="width: 100%;"/>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="gps_container">
	                    <input type="checkbox" name="gps_check" id="enable_gps" style="margin-bottom: 5px;"> <font class="white"> Use GPS Coordinate:</font>
						<div class="col-sm-10" style="">
							<input type="text" id="gps_coordinate" class="form-control" placeholder="27,0000; 30,0000" style="width: 100%;" value="" disabled/>
						</div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-primary" style="width: 40px; float: right;" id="gps_btn" onclick="getLocation();" disabled><i class="fa fa-map-marker"></i></button>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="hold_value_timer_container">
	                    <label>Run the rule if this condition is hold for:</label>
						<div class="col-sm-10" align="center" style="">
							<input type="text" id="hold_value_timer" class="form-control" placeholder="left empty or zero equal immediatly" style="width: 100%;"/>
						</div>
						<div class="col-sm-2" align="left" style="">
							<label>seconds</label>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="result_subscribe_topic_container">
	                    <hr>
	                    <label>Select the subscribe topic as a result of the rule:</label>
						<div class="col-sm-12" align="center">
	                      <select class="select_result_subscribe_topic" tabindex="-1">
	                        <option></option>
	                      </select>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="key_result_container">
						<div class="col-sm-12" align="center">
	                      <select class="select_key_result" tabindex="-1">
	                        <option></option>
	                      </select>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="key_result_type">
	                    <label>Key Type:</label>
						<div class="col-sm-12" align="center">
	                      <select class="select_key_result_type" tabindex="-1">
	                        <option></option>
	                        <option value="none">No value needed</option>
	                        <option value="value">Type Value</option>
	                      </select>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="key_value_result_container">
	                    <label>Key value to send:</label>
						<div class="col-sm-12" align="center" style="">
							<input type="text" id="key_value_result" class="form-control" placeholder="value" style="width: 100%;"/>
						</div>
                    </div>
                    <div class="row" style="display: none; margin-top: 20px;" id="send_rule_container">
	                    <hr>
						<div class="col-sm-12" align="center" style="">
							<button class="btn btn-danger" style="margin-top: 10px;" onclick="add_rule();">Add Rule</button>
						</div>
                    </div>
					</div>
                </div>
                <div id="dialog_delete_rule" class="zoom-anim-dialog mfp-hide">
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
		
		$(document).ready(function(){
			
			$(".select_sensor_actuator").select2({
	          placeholder: "Select Sensor or Actuator",
	          allowClear: true,
	          width: '100%'
	        });
	        
	        $(".select_topic").select2({
	          placeholder: "Select a topic",
	          allowClear: true,
	          width: '100%'
	        });
	        
	        $(".select_key").select2({
	          placeholder: "Select a key",
	          allowClear: true,
	          width: '100%'
	        });
	        
	        $(".select_condition_type").select2({
	          placeholder: "Select a condition",
	          allowClear: true,
	          width: '100%'
	        });
	        
	        $(".select_result_subscribe_topic").select2({
	          placeholder: "Select a topic",
	          allowClear: true,
	          width: '100%'
	        });
	        
	        	        
	        $(".select_key_result").select2({
	          placeholder: "Select a result key",
	          allowClear: true,
	          width: '100%'
	        });
	        
	        $(".select_key_result_type").select2({
	          placeholder: "Select a result key",
	          allowClear: true,
	          width: '100%'
	        });
	        
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
			
			loadRules();
		});
		
		function dismiss_alert () {
			$.magnificPopup.close();
		}
		
		function show_alert(type,id) {
			
			if (type == 'rule') {
				
				$("#yes_delete_btn").attr("onclick","delete_rule("+id+")");
				
			}
			
			$.magnificPopup.open({
		        items: {
		            src: '#dialog_delete_rule' 
		        },
		        type: 'inline'
		    });
			
		}
		
		function delete_rule(id_rule) {
			
			dismiss_alert();
			
			$.LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
			var m_data = new FormData();    
            m_data.append( 'request', 'delete_rule');
            m_data.append( 'id_rule', id_rule);
            
		    $.ajax({ 
			    type: 'POST', 
			    url: '/lib/add_rule_ajax.php',
			    data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
                dataType:'json',
			    success: function (data) { 
			       $.LoadingOverlay("hide");
			       
			       if (data.success == 1) {
					   	loadRules();
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
		
		function loadRules() {
			$.ajax({
				  url: "load_rules.php"
			}).done(function(data) {
				  $('#rules_added').html(data);
			});
		}
		
		function load_1() {
			
			$("#loader_rule").LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
		    
		    var m_data = new FormData();    
            m_data.append( 'request', 'get_sensor_actuators');
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/add_rule_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) {
				    $("#loader_rule").LoadingOverlay("hide", true);
				    $('.select_sensor_actuator').empty();
				    $('.select_sensor_actuator').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_sensor_actuator').append($('<option>', {
						    value: element.id,
						    text: element.name+" ("+element.type+")"
						}));
			        });
			        $("#sensor_actuator_container").slideDown();
			    }
			});
	    }
	    
	    $('.select_sensor_actuator').change(function(){ 
		    var option = $(this).val();
		    
		    if (option != '') {
				load_2(option);
			}
		});
		
		function load_2(option) {
		    
		    $("#loader_rule").LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
		    var m_data = new FormData();    
            m_data.append( 'request', 'get_topics_with_id');
            m_data.append( 'id_sensor_actuator', option);
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/add_rule_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) {
				    $("#loader_rule").LoadingOverlay("hide", true);
				    $('.select_topic').empty();
				    $('.select_topic').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_topic').append($('<option>', {
						    value: element.id,
						    text: element.name+" ("+element.type+")"
						}));
			        });
			        $("#topic_container").slideDown();
			    }
			});
	    }
	    
	    $('.select_topic').change(function(){ 
		    var option = $(this).val();
		    
		    if (option != '') {
				load_3(option);
			}
		});
		
		function load_3(option) {
		    
		    $("#loader_rule").LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
		    var m_data = new FormData();    
            m_data.append( 'request', 'get_key_with_topic_id');
            m_data.append( 'id_topic', option);
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/add_rule_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) {
				    $("#loader_rule").LoadingOverlay("hide", true);
				    $('.select_key').empty();
				    $('.select_key').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_key').append($('<option>', {
						    value: element.id,
						    text: element.name
						}));
			        });
			        $("#key_container").slideDown();
			    }
			});
	    }
	    
	    $('.select_key').change(function(){ 
		    var option = $(this).val();
		    
		    if (option != '') {
				load_4(option);
			}
		});
		
		function load_4() {
			
			$("#condition_container").slideDown();
		}
		
		$('.select_condition_type').change(function(){ 
		    var option = $(this).val();
		    
		    if (option == 'none') {
			    
				$("#value_container").slideUp();
				$("#gps_container").slideUp();
				$("#hold_value_timer_container").slideUp();
				load_6();
				
			} else if (option != '') {
				load_5(option);
				load_6();
			}
		});
		
		document.getElementById('enable_gps').onchange = function() {
		    document.getElementById('gps_coordinate').disabled = !this.checked;
		    document.getElementById('gps_btn').disabled = !this.checked;
		};
		
		function getLocation() {
		    if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(showPosition);
		    } else {
		        alert("Geolocation is not supported by this browser.");
		    }
		}
		
		function showPosition(position) {
			$('#gps_coordinate').val( position.coords.latitude+";"+position.coords.longitude)
		}

		function load_5() {
			$("#value_container").slideDown();
			$("#gps_container").slideDown();
			$("#hold_value_timer_container").slideDown();
		}
		
		function load_6() {
			$("#loader_rule").LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
		    var m_data = new FormData();    
            m_data.append( 'request', 'get_subscribe_topics');
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/add_rule_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) {
				    $("#loader_rule").LoadingOverlay("hide", true);
				    $('.select_result_subscribe_topic').empty();
				    $('.select_result_subscribe_topic').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_result_subscribe_topic').append($('<option>', {
						    value: element.id,
						    text: element.name+" ("+element.sensor_actuator+")"
						}));
			        });
			        $("#result_subscribe_topic_container").slideDown();
			    }
			});
		}
		
		$('.select_result_subscribe_topic').change(function(){ 
		    var option = $(this).val();
		    
		    if (option != '') {
			    load_7(option);
			}
		});
		
		function load_7(option) {
		    
		    $("#loader_rule").LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
		    var m_data = new FormData();    
            m_data.append( 'request', 'get_key_with_topic_id');
            m_data.append( 'id_topic', option);
            
		    $.ajax({ 
			    type: 'POST',
			    url: '/lib/add_rule_ajax.php', 
				data: m_data,
			    contentType: false,
                processData: false,
                cache: false,
			    dataType: 'json',
			    success: function (data) {
				    $("#loader_rule").LoadingOverlay("hide", true);
				    $('.select_key_result').empty();
				    $('.select_key_result').html('<option></option>');
			        $.each(data, function(index, element) {
				        $('.select_key_result').append($('<option>', {
						    value: element.id,
						    text: element.name
						}));
			        });
			        $("#key_result_container").slideDown();
			    }
			});
	    }
	    
	    $('.select_key_result').change(function(){ 
		    var option = $(this).val();
		    
		    if (option != '') {
			    $("#key_result_type").slideDown();
		    } else {
			    $("#key_result_type").slideUp();
		    }
		});
		
		$('.select_key_result_type').change(function(){ 
		    var option = $(this).val();
		    
			if (option == 'none') {
			    
			    $("#key_value_result_container").slideUp();
				$("#send_rule_container").slideDown();
				scroll_down();
			} else if (option == 'value') {
				$("#key_value_result_container").slideDown();
				$("#send_rule_container").slideDown();
				scroll_down();
			} else {
				$("#key_value_result_container").slideUp();
				$("#send_rule_container").slideUp();
			}
		});
		
		function scroll_down() {
			$('#body_popup').animate({
        		scrollTop: $('#body_popup')[0].scrollHeight}, 2000);
		}
		
		function add_rule() {
			
			$.magnificPopup.close();
			
			$.LoadingOverlay("show", {
			    image       : "",
			    fontawesome : "fa fa-empire fa-spin"
			});
			
			var id_topic = $('.select_topic option:selected').val();
			var id_key = $('.select_key option:selected').val();
			var condition_type = $('.select_condition_type option:selected').val();
			var condition_value = $('#condition_value').val();
			var hold_timer = $('#hold_value_timer').val() == '' ? 0 : $('#hold_value_timer').val();
			var id_topic_result = $('.select_result_subscribe_topic option:selected').val();
			var id_key_result = $('.select_key_result option:selected').val();
			var key_result_type = $('.select_key_result_type option:selected').val();
			var key_result_value = $('#key_value_result').val();
			var gps_checked = $("#enable_gps").is(':checked') ? 1 : 0;
			var gps_value = $('#gps_coordinate').val().replace(/ /g,'');
			
			if (condition_type != 'none' && !/\S/.test(condition_value)) {
				
				new PNotify({
			       title: 'Oh No!',
				   text: 'If you have a condition, you have to insert a value',
				   type: 'error',
				   styling: 'bootstrap3'
				});
				
			} else if (gps_checked == 1 && !/\S/.test(gps_value)) {
				
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have checked the GPS, so you have to insert a GPS coordinate in this format: lat;long',
				   type: 'error',
				   styling: 'bootstrap3'
				});
				
			} else {
			
				var m_data = new FormData();    
				m_data.append( 'request', 'add_rule');
	            m_data.append( 'id_topic', id_topic);
	            m_data.append( 'id_key', id_key);
	            m_data.append( 'condition_type', condition_type);
	            m_data.append( 'condition_value', condition_value);
	            m_data.append( 'hold_timer', hold_timer);
	            m_data.append( 'id_topic_result', id_topic_result);
	            m_data.append( 'id_key_result', id_key_result);
	            m_data.append( 'key_type_result', key_result_type);
	            m_data.append( 'key_value_result', key_result_value);
	            m_data.append( 'gps_checked', gps_checked);
	            m_data.append( 'gps_value', gps_value);
	            
	            $.ajax({ 
				    type: 'POST',
				    url: '/lib/add_rule_ajax.php', 
					data: m_data,
				    contentType: false,
	                processData: false,
	                cache: false,
				    dataType: 'json',
				    success: function (data) {
					    
					    $.LoadingOverlay("hide");
					    
					    if (data.success == 1) {
						    
						    loadRules();
						    
						} else {
							
							$.magnificPopup.open({
						        items: {
						            src: '#small-dialog' 
						        },
						        type: 'inline'
						    });
							
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