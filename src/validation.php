<?php
//connect to server
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barrymin-db", "CHoGMl6m7jbuiGAv", "barrymin-db");
    if ($mysqli->connect_errno) {
        echo "Failed to connect please try again later";
    }
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
        session_start();
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
                session_start();
                //check if sessions are disabled
                if (session_status() == PHP_SESSION_ACTIVE) {
                    $_SESSION["username"] = $_POST["signup-username"];
                }
            }
        }
    }
    $stmt->close();
}

?>