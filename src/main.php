<?php
session_start();
//logout user if logout button was clicked
if(isset($_GET["logout"])){
    unset($_SESSION["username"]);
}
//redirect to login page if user is not logged in
if(!isset($_SESSION["username"])){
    header('location: http://web.engr.oregonstate.edu/~barrymin/cs290Final');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Main</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container">
    <div class="page-header">
      <div class="row">
        <div class="col-md-8">
          <h1>Welcome</h1>
          <p></p>
        </div>
		<div class="col-md-4">
          <form method="get">
		  <input type="submit" name="logout" value="logout" class="btn btn-default">
		  </form>
        </div>
	  </div>
    </div>
  </div>
</body>
</html>