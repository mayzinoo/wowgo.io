<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo base_url(); ?>">
    <link rel="shortcut icon" href="../images/favicon.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>WoWgo Admin Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link rel="stylesheet" type="text/css" href="css/mystyle.css">    
    
    <!-- Custom styles for this template -->
  
    <link href="css/style-responsive.css" rel="stylesheet">

    <script src="js/chart-master/Chart.js"></script>

    <style>
    	body{
		  background: #ccc !important;    
		  width: 100% !important;
		  margin: 0 !important;
		  background-size: cover !important;
		  background-attachment: fixed !important;
		  background-repeat: no-repeat !important;
    	}
 </style>

  </head>

  <body>

  
  <section id="main-content">
    <section class="wrapper">
		<div class="container large_top_padding">
		    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		        <div class="col-md-offset-3 col-md-6">
		             <form action="Admin/admin_login" method="POST">
		                <div class="login-wrap">
		                    <h3>Admin Login Form</h3>

		                    <label>User Name <span style="color:#CD232C;">*</span></label>
		                    <!--<i class="fa fa-envelope"></i>-->
		                    <input type="text" name="username" class="form-control" placeholder="Email" required>

		                    <label>Password <span style="color:#CD232C;">*</span></label>
		                    <!--<i class="fa fa-lock"></i>-->
		                    <input type="password" name="password" class="form-control" placeholder="Password" required>
		                    <br/>
		                    <button class="btn button-login" name="register">Log In</button>
		                </div>
		                    
		             </form>
		        </div>
		    </div>
		</div>
	</section>

<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
<script>
    $.backstretch("../images/login-bg.jpg", {speed: 500});
</script>
</body>
</html>
