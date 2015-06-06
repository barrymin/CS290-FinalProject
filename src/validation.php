<?php
//connect to server
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barrymin-db", "CHoGMl6m7jbuiGAv", "barrymin-db");
    if ($mysqli->connect_errno) {
        echo "Failed to connect please try again later";
    }
session_start();
//for login
//check if login user and pass exist
if(isset($_POST["login-username"]) && isset($_POST["login-username"])){
    if (!($stmt = $mysqli->prepare("SELECT username FROM Users WHERE username = ? AND BINARY password = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ss", $_POST["login-username"], $_POST["login-pass"])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $user=null;
    if (!$stmt->bind_result($user)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!$stmt->fetch()) {
        echo "You entered a wrong combination of username and password";
    }else{ 
        //log user in
        //check if sessions are disabled
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION["username"] = $_POST["login-username"];
        }
    }
    $stmt->close();
}
//for signup
if(isset($_POST["signup-username"]) && isset($_POST["signup-pass"]) && isset($_POST["signup-name"])
    && isset($_POST["signup-email"])){

    //check if username exists
    if (!($stmt = $mysqli->prepare("SELECT username FROM Users WHERE username = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("s", $_POST["signup-username"])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $user=null;
    if (!$stmt->bind_result($user)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if($stmt->fetch()) {
        echo "Username already exists";
    } else {
        $stmt->close();
        //check if email exist
        if (!($stmt = $mysqli->prepare("SELECT username FROM Users WHERE email = ?"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("s", $_POST["signup-email"])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $user=null;
        if (!$stmt->bind_result($user)) {
            echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if($stmt->fetch()) {
            echo "The email you entered has been already registered with another username";
        } else {
            $stmt->close();
            //create user and login
            if (!($stmt = $mysqli->prepare("INSERT INTO Users (username, password, name, email) VALUES (?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            if (!$stmt->bind_param("ssss", $_POST["signup-username"], $_POST["signup-pass"], $_POST["signup-name"], $_POST["signup-email"])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }else{
                //log user in
                
                //check if sessions are disabled
                if (session_status() == PHP_SESSION_ACTIVE) {
                    $_SESSION["username"] = $_POST["signup-username"];
                }
            }
        }
    }
    $stmt->close();
}

//for saving location
if(isset($_POST["location-desc"]) && isset($_POST["location-a"]) && isset($_POST["location-f"]) &&
    isset($_POST["location-zoom"]) && isset($_POST["location-share"]) && isset($_SESSION["username"])){
    //insert location
	if (!($stmt = $mysqli->prepare("INSERT INTO Location (A, F, zoom) VALUES (?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ssi", $_POST["location-a"], $_POST["location-f"], $_POST["location-zoom"])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed1: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
    //get location primary key
     if (!($stmt = $mysqli->prepare("SELECT lno FROM Location WHERE a = ? AND f = ? AND zoom = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ssi", $_POST["location-a"], $_POST["location-f"], $_POST["location-zoom"])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    if (!$stmt->execute()) {
        echo "Execute failed2: (" . $stmt->errno . ") " . $stmt->error;
    }
    $lno=null;
    if (!$stmt->bind_result($lno)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if($stmt->fetch()) {
        echo "$lno  ".$_POST['location-a']."  ".$_POST['location-f'];
    }
    $stmt->close();
    //insert in saved
    if (!($stmt = $mysqli->prepare("INSERT INTO Saved (username, lno, description, share) VALUES (?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("sisi", $_SESSION["username"], $lno, $_POST["location-desc"],$_POST["location-share"])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed3: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}

//displaying user locations
if(isset($_GET["location-user"]) && isset($_SESSION["username"])){
    if (!($stmt = $mysqli->prepare("
        SELECT l.lno, l.a, l.f, l.zoom, s.username, s.description, s.share
        FROM Location l, Saved s
        WHERE l.lno = s.lno AND s.username = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("s", $_SESSION["username"])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $locNo=null;
    $user=null;
    $a=null;
    $f=null;
    $zoom=null;
    $desc=null;
    $share=null;
    if (!$stmt->bind_result($locNo,$a,$f,$zoom,$user,$desc,$share)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $exist=0;
    while($stmt->fetch()) {
        $exist= true;
        echo "<div class='panel panel-default'>
         <div class='panel-body' style='cursor:pointer;' locNo='$locNo' share'$share' a='$a' f='$f' zoom='$zoom' onClick='selectLocation(this)'>$user: $desc";
        if($share){
            echo "<div class='panel-footer'>
                <input type='button' class='btn btn-default' value='delete' onclick='deleteLocation(this)'>
                <input type='button' class='btn btn-default' value='Make Private' onclick='changeLocationPrivacy(this,0)'></div></div></div>";
        } else {
            echo "<div class='panel-footer'>
                <input type='button' class='btn btn-default' value='delete' onclick='deleteLocation(this)'>
                <input type='button' class='btn btn-default' value='share' onclick='changeLocationPrivacy(this,1)'></div></div></div>";
        }
    }
    if(!$exist){
        echo "<div class='panel panel-default'>
         <div class='panel-body'>You don't have any locations, click on the new location button to make one!</div>
         </div>";
    }
    $stmt->close();
}
//displaying public locations
if(isset($_GET["location-public"]) && isset($_SESSION["username"])){
    if (!($stmt = $mysqli->prepare("
        SELECT l.lno,l.a, l.f, l.zoom, s.username, s.description, s.share
        FROM Location l, Saved s
        WHERE l.lno = s.lno AND s.username <> ? AND s.share = 1"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("s", $_SESSION["username"])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $locNo=null;
    $user=null;
    $a=null;
    $f=null;
    $zoom=null;
    $desc=null;
    $share=null;
    if (!$stmt->bind_result($locNo,$a,$f,$zoom,$user,$desc,$share)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $exist=0;
    while($stmt->fetch()) {
        $exist= true;
        echo "<div class='panel panel-default'>
         <div class='panel-body' style='cursor:pointer;' locNo='$locNo' a='$a' f='$f' zoom='$zoom' onClick='showInMap(this)'>$user: $desc</div>
         </div>";
    }
    if(!$exist){
        echo "<div class='panel panel-default'>
         <div class='panel-body'>There are no public places!</div>
         </div>";
    }
    $stmt->close();
}

//delete location
if(isset($_SESSION["username"]) && isset($_GET["delete-location"])){
    if (!($stmt = $mysqli->prepare("DELETE FROM Saved WHERE username = ? AND lno =?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("si", $_SESSION["username"],$_GET["delete-location"])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
    
    //delete from locations table if no other user saved the same location
    if (!($stmt = $mysqli->prepare("SELECT COUNT(lno) FROM Saved WHERE lno =?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("i",$_GET["delete-location"])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $count=null;
    if (!$stmt->bind_result($count)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->fetch();
    echo "count is $count";
    $stmt->close();
    if($count == 0){ 
        if (!($stmt = $mysqli->prepare("DELETE FROM Location WHERE lno =?"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("i",$_GET["delete-location"])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

//change location privacy
if(isset($_SESSION["username"]) && isset($_GET["share"]) && isset($_GET["share-lno"])){
    if (!($stmt = $mysqli->prepare("UPDATE Saved SET share = ? WHERE username = ? AND lno = ?"))) {
        echo "Prepare failed11: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("isi", $_GET["share"],$_SESSION["username"],$_GET["share-lno"])) {
        echo "Binding parameters failed11: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->close();
}
?>