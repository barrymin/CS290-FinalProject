/*
* notEmpty(str)
* checks if str is an empty string and displays a msg to the user
* if str wasnt empty it returns true
*/
function notEmpty(str) {
   if (str.length !== 0){
      document.getElementById("warningmsg").innerHTML = "";
      return true;
   }else{
      document.getElementById("warningmsg").innerHTML = "Please fill in the empty fields";
      return false;
   }
}
/*
*validateLogin()
*makes sure username and pass are not empty then sends a request to check 
*if the username exits and if the password was correct. if the username 
*and password were correct the user will be logged in through the request
*/
function validateLogin() {
   var username = document.getElementById("login-username").value;
   var password = document.getElementById("login-password").value;
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
                  //user is logged in
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