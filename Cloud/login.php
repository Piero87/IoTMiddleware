<?php
	require_once $_SERVER["DOCUMENT_ROOT"].'/lib/login_functions.php';
	
	if (isLogged())
	{
	header ("Location: index.php");
	exit();
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
    
  </head>

  <body style="background:#F7F7F7;">
    <div class="">

      <div id="wrapper">
        <div id="login" class=" form">
          <section class="login_content">
            <form id="login_form">
	          <i class="fa fa-empire fa-5x" style="margin-bottom: 30px;"></i>
	          
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" id="username" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" id="password" />
              </div>
              <div>
	              <input type="checkbox" name="vehicle" id="remember"> <font class="white"> Remember</font>
              </div>
              <div>
                <button class="btn btn-default" style="margin-top: 10px;" onclick="login()">Login</button>
              </div>
            </form>
          </section>
        </div>
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
    
    <script type="text/javascript">
	    
	    //Evitare che il form faccia il submit in modo da gestirlo manuale da javascript
	    $("#login_form").submit(function(e) {
		    e.preventDefault();
		});

	    function login() {
				
			var username = $('#username').val();
			var password = $('#password').val();
			var remember = $("#remember").is(':checked') ? 1 : 0;
			
			if (!/\S/.test(username) && !/\S/.test(password)) {
				
				new PNotify({
			       title: 'Oh No!',
				   text: 'You have to insert username and password',
				   type: 'error',
				   styling: 'bootstrap3'
				});
				
			} else {
				
				$.ajax({
					type: "POST",
					url: "lib/login.php",
					data: {username:username,password:password,remember:remember},
					cache: false,
					success: function(html){
						if (html == true)
						{
							location.reload();
						} else {
							new PNotify({
						       title: 'Oh No!',
							   text: 'Wrong credentials',
							   type: 'error',
							   styling: 'bootstrap3'
							});
						}
					}
				});

			}
			
			return false;
		}
	</script>
  </body>
</html>