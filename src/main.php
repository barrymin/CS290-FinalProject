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
  <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCoI9VpfNMAYMMGOlC5vb415Ilhv69GL0A"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
  <script src="main.js"></script>
</head>
<body>

  <div class="container">
    <div class="page-header">
      <div class="row">
        <div class="col-md-8">
          <h1>Welcome</h1>
          <p></p>
		  <input id="showNew" type="button" name="new" value="New Location" class="btn btn-default">
        </div>
        <div class="col-md-4">
          <form method="get">
            <input type="submit" name="logout" value="logout" class="btn btn-default">
          </form>
        </div>
      </div>
    </div>
    <div class="row" id="newlocation">
      <div class="col-md-5">
	    <h3>1. Zoom into place:</h3>
        <div id="googleMap" style="width:100%;height:380px;"></div>
      </div>
      <div class="col-md-6">
	    <h3>2. write a description for the place and save!</h3>
        <form role="form">
		  <div class="form-group">
		    <p id="warningdesc" class="alert-warning">
	        </p>
		    <label>Great place to: </label>
		    <textarea class="form-control" id="location-desc" onchange="validateDesc(this.value)"></textarea>
          </div>
		  <div class="form-group">
			<input type="checkbox" id="location-public">Make it public</input>
		  </div>
		 <div class="form-group">
			<input class="btn btn-default" type="button" value="Save Place" onclick="saveLocation()">
		  </div>
		</form>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div id="main">
          <ul class="nav nav-tabs">
            <li onclick="displayLocations()"><a href="#">My Locations</a></li>
            <li><a href="#">Followed</a></li>
            <li><a href="#">Public</a></li>
          </ul>
		  <div id="displayLocations">
		  </div>
        </div>
      </div>
      <div class="col-md-6">
      </div>
    </div>
  </div>
</body>
</html>