$(document).ready(function(){
   $("#newlocation").hide();
   $("#showNew").click(function(){
       $("#newlocation").toggle();
       initialize();
   });
});
//creating map
var map;
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(0,0),
    zoom:1,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}

function saveLocation(){
   desc = document.getElementById("location-desc").value;
   if(validateDesc(desc)){
      var a = map.getCenter().A;
      var f = map.getCenter().F;
	  var zoom = map.getZoom();
      var share = 0;
      if(document.getElementById("location-public").checked){
         share = 1;
        
      }
      $.post("validation.php",
        {
            "location-desc": desc,
            "location-a": a,
            "location-f": f,
            "location-zoom": zoom,
            "location-share": share
        },
        function(data,status){
        //TODO: 
			alert("Data: " + data + "\nStatus: " + status);
			document.getElementById("location-desc").value="";
			$("#newlocation").hide();
        });
   }
}
function validateDesc(desc){
   if(desc.length !== 0){
     document.getElementById("warningdesc").innerHTML = "";
     return true;
   } else {
     document.getElementById("warningdesc").innerHTML = "You should enter a description.";
     return false;
   }
}

function displayLocations(){
$.get("validation.php",
        {
            "location-user": 1
        },
        function(data,status){
        //TODO: 
			alert("Data: " + data + "\nStatus: " + status);
			document.getElementById("displayLocations").innerHTML=data;
        });
}
