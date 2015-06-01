function notEmpty(str) {
   if (str.length !== 0){
      document.getElementById("warningmsg").innerHTML = "";
      return true;
   }else{
      document.getElementById("warningmsg").innerHTML = "Please fill in the empty fields";
      return false;
   }
}
function validateLogin() {
   var username = document.getElementById("login-username").value;
   var password = document.getElementById("login-password").value;
   //validate username
   if (notEmpty(username) && notEmpty(password)){
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
                  location.reload();
               }
            }
         }
      };
      httpRequest.open('POST',"http://web.engr.oregonstate.edu/~barrymin/cs290Final/validation.php", true);
      httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      httpRequest.send("login-username="+encodeURIComponent(username)+"&login-pass="+encodeURIComponent(password));
   }
   return false;
}
function postRequest(params){
  var httpRequest;
  if (window.XMLHttpRequest) {
    httpRequest = new XMLHttpRequest();
  }
  if (!httpRequest) {
    alert('Cannot create XMLHTTP');
    return;
  }
  httpRequest.onreadystatechange = function () {
    if (httpRequest.readyState === 4) {
      if (httpRequest.status === 200) {
        handleResponse(this.response);
      }
    }
  };
  httpRequest.open('POST',"http://web.engr.oregonstate.edu/~barrymin/cs290Final/validation.php", true);
  httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  httpRequest.send(params);
}

function handleResponse(response){
   if(response.length === 0){
        document.getElementById("warningmsg").innerHTML = "";
      }else{
          document.getElementById("warningmsg").innerHTML = response;
      }
}