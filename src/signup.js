/*validates given user name*/
function validateUsername(username){
  if(username.length > 3 && username.length <= 20){
    if(username.search(" ")=== -1){
      document.getElementById("warninguser").innerHTML = "";
      return true;
    }else{
      document.getElementById("warninguser").innerHTML = "username cannot include spaces";
      return false;
    }
  }else{
    document.getElementById("warninguser").innerHTML = "username must be between 3 and 20 characters";
    return false;
  }
}
/*validates given password*/
function validatePassword(pass){
  if(pass.length !== 0){
    if(pass.length >= 6 && pass.length <= 16){
      document.getElementById("warningpass").innerHTML = "";
      return true;
    }else{
      document.getElementById("warningpass").innerHTML = "password must be between 6 and 16 character";
      return false;
    }
  }else{
    document.getElementById("warningpass").innerHTML = "password cannot be empty";
    return false;
  }
}
/*validates that password and confirm password are the same*/
function confirmPassword() {
  pass = document.getElementById("signup-password").value;
  pass2 = document.getElementById("signup-password2").value;
  if (pass === pass2) {
    document.getElementById("warningpass2").innerHTML = "";
    return true;
  } else {
    document.getElementById("warningpass2").innerHTML = "Passwords Don't match";
    return false;
  }
}
/*validates the given name*/
function validateName(name){
  if(name.length !== 0 && name.charAt(0) !== " "){
    document.getElementById("warningname").innerHTML = "";
    return true;  
  }else{
    document.getElementById("warningname").innerHTML = "Name cannot be empty";
    return false;
  }
}
/*validates the given email*/
function validateEmail(email){
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){  
    document.getElementById("warningemail").innerHTML = "";
    return true;
  }else {
    document.getElementById("warningemail").innerHTML = "Invalid email";
    return false;
  }
}

/*
*validateSignup()
*makes sure username, pass, name and email are valid then sends a request to check 
*if the username exits and creates a user.
*/
function validateSignup() {
  var username = document.getElementById("signup-username").value;
  var password = document.getElementById("signup-password").value;
  var name = document.getElementById("signup-name").value;
  var email = document.getElementById("signup-email").value;
  if (validateUsername(username) && validatePassword(password)
    && confirmPassword() && validateName(name) && validateEmail(email)){
    if (window.XMLHttpRequest) {
      httpRequest = new XMLHttpRequest();
    }
    if (!httpRequest) {
      alert('Cannot create XMLHTTP');
      return false;
    }
    httpRequest.onreadystatechange = function () {
      if (httpRequest.readyState === 4) {
        if (httpRequest.status === 200) {
          handleResponse(this.response);
          if(this.response.length === 0){
            //user is created and logged in
            location.reload();
          }
        }
      }
    };
    httpRequest.open('POST',"http://web.engr.oregonstate.edu/~barrymin/cs290Final/validation.php", true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send("signup-username="+encodeURIComponent(username)+"&signup-pass="+encodeURIComponent(password)
      +"&signup-name="+encodeURIComponent(name)+"&signup-email="+encodeURIComponent(email));
  }
  return false;
}
/*
*handleResponse(response)
*displays the response to the user if it was not empty
*/
function handleResponse(response){
  if(response.length === 0){
    document.getElementById("warningmsg").innerHTML = "";
  }else{
    document.getElementById("warningmsg").innerHTML = response;
  }
}