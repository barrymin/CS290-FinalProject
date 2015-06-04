<?php
//redirect to main page if user is logged in
session_start();
if(isset($_SESSION["username"])){
    header('location: http://web.engr.oregonstate.edu/~barrymin/cs290Final/main.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="login.js"></script>
</head>
<body>

<div class="container">
  <div class="row">
  <div class="col-md-4">
  </div>
  <div class="col-md-4">
    <div class="page-header">
      <h1>Login Page</h1>
	  <p>Please login or 
	    <a href="signup.php">Create a new account</a>
      </p>
    </div>
	<div id="loginspace">
	  <p id="warningmsg" class="alert-warning">
	  </p>
	  <form role="form" onsubmit="return validateLogin()">
		  <div class="form-group">
		    <p id="warninguser" class="alert-warning">
	        </p>
		    <label>Userame: </label>
		    <input class="form-control" id="login-username" type="text" name="user-username" required="required">
		  </div>
		  <div class="form-group">
		    <p id="warningpass" class="alert-warning">
	        </p>
		    <label>Password: </label>
		    <input class="form-control" id="login-password" type="password" name="user-pass" required="required">
		  </div>
          <input id="loginbtn" type="submit" value="login" class="btn btn-default"></input>    
	  </form>
	</div>
    <div class="col-md-4">
    </div>
  </div>

  </div>
</div>
</body>
</html>