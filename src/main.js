$(document).ready(function(){
  map2=new google.maps.Map(document.getElementById("googleMap2"),mapProp);
  $("#newlocation").hide();
  displayLocations();
  $("#showNew").click(function(){
    $("#newlocation").toggle();
    map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
    getLocation();
  });
});
//creating map
var map;
var map2;
  var mapProp = {
    center:new google.maps.LatLng(0,0),
    zoom:1,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
//getting current location
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}
function showPosition(position) {
    map.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude)); 
    map.setZoom(17);
}

function saveLocation(){
  desc = document.getElementById("location-desc").value;
  if(validateDesc(desc)){
    var a = map.getCenter().A;
    var f = map.getCenter().F;
    var zoom = map.getZoom();
    var share = 0;
    $("#saveLocationButton").attr("value","Saving..");
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
        //alert("Data: " + data + "\nStatus: " + status);
        document.getElementById("location-desc").value="";
        $("#saveLocationButton").attr("value","Save Location");
        $("#newlocation").hide();
        displayLocations();
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
  document.getElementById("displayLocations").innerHTML="<h3>Loading</h3>";
  $.get("validation.php",
    {
      "location-user": 1
    },
    function(data,status){
      //alert("Data: " + data + "\nStatus: " + status);
      document.getElementById("displayLocations").innerHTML=data;
    });
}

function displayPublic(){
  document.getElementById("displayLocations").innerHTML="<h3>Loading</h3>";
$.get("validation.php",
  {
    "location-public": 1
  },
  function(data,status){
    //alert("Data: " + data + "\nStatus: " + status);
    document.getElementById("displayLocations").innerHTML=data;
  });
}

function showInMap(panel){
  map2.setZoom(parseInt(panel.getAttribute("zoom")));
  map2.panTo(new google.maps.LatLng(parseFloat(panel.getAttribute("a")),parseFloat(panel.getAttribute("f"))));
}
