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
  <title>Signup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="signup.js"></script>
</head>
<body>

<div class="container">
  <div class="row">
  <div class="col-md-4">
  </div>
  <div class="col-md-4">
    <div class="page-header">
      <h1>Sign Up Page</h1>
	  <p>Please signup or
	    <a href="index.php">log in</a>
	  </p>
    </div>
	<div id="signupspace">
	  <p id="warningmsg" class="alert-warning">
	  </p>
	  <form role="form" onsubmit="return validateSignup()" method="get">
		  <div class="form-group">
		    <p id="warninguser" class="alert-warning">
	        </p>
		    <label>Username: </label>
		    <input class="form-control" id="signup-username" type="text" onchange="validateUsername(this.value)" name="user-username" required="required">
		  </div>
		  <div class="form-group">
		    <p id="warningpass" class="alert-warning">
	        </p>
		    <label>Password: </label>
		    <input class="form-control" id="signup-password" type="password" onchange="validatePassword(this.value)" name="user-pass" required="required">
		  </div>
		  <div class="form-group">
		    <p id="warningpass2" class="alert-warning">
	        </p>
		    <label>Confirm Password: </label>
		    <input class="form-control" id="signup-password2" type="password" onchange="confirmPassword()" name="user-pass2" required="required">
		  </div>
		  <div class="form-group">
		    <p id="warningname" class="alert-warning">
	        </p>
		    <label>Name: </label>
		    <input class="form-control" id="signup-name" type="text" onchange="validateName(this.value)" name="user-name" required="required">
		  </div>
		  <div class="form-group">
		    <p id="warningemail" class="alert-warning">
	        </p>
		    <label>Email: </label>
		    <input class="form-control" id="signup-email" type="email" onchange="validateEmail(this.value)" name="user-email" required="required">
		  </div>
          <input id="signupbtn" type="submit" value="signup" class="btn btn-default"></input>    
	  </form>
	</div>
    <div class="col-md-4">
    </div>
  </div>

  </div>
</div>
</body>
</html>