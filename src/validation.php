<?php
//connect to server
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barrymin-db", "CHoGMl6m7jbuiGAv", "barrymin-db");
    if ($mysqli->connect_errno) {
    echo "Failed to connect please try again later";
    }

//for login
//check if login user and pass exist
if(isset($_POST["login-username"]) && isset($_POST["login-username"])){
    if (!($stmt = $mysqli->prepare("SELECT username FROM Users WHERE username = ? AND password = ?"))) {
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
        session_start();
        //check if sessions are disabled
        if (session_status() == PHP_SESSION_ACTIVE) {
            //log in if user wasn't already logged in
            $_SESSION["username"] = $_POST["login-username"];
        }
    }
    $stmt->close();
}
?>