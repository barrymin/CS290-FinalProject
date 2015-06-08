$(document).ready(function () {
  //load the map that would display locations
  map2 = new google.maps.Map(document.getElementById("googleMap2"), mapProp);
  $("#newlocation").hide();
  displayLocations();
  $("#showNew").click(function () {
    $("textarea").text("Great place to..");
    $("#newlocation").show();
    map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    getLocation();
    placeMarker(map.getCenter(), map);
    google.maps.event.addListener(map, 'click', function (event) {
      placeMarker(event.latLng, map);
    });
  });
});
//setting up maps
var map;
var map2;
var marker = new google.maps.Marker();
var mapProp = {
  center: new google.maps.LatLng(0, 0),
  zoom: 1,
  mapTypeId:google.maps.MapTypeId.ROADMAP
};
/*places a marker in the given map at the given location*/
function placeMarker(location, map) {
  marker.setPosition(location);
  marker.setMap(map);
}
/*gets user's current location*/
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}
/*shows the given position on the create a new location map*/
function showPosition(position) {
    map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
    placeMarker(new google.maps.LatLng(position.coords.latitude, position.coords.longitude), map);
    map.setZoom(17);
}
/*to hide the new location panel*/
function cancelSaveLocation() {
  $("#newlocation").hide();
}
/*sends a request to save the user's new location*/
function saveLocation() {
  desc = document.getElementById("location-desc").value;
  if (validateDesc(desc)) {
    var a = marker.getPosition().A;
    var f = marker.getPosition().F;
    var zoom = map.getZoom();
    var share = 0;
    $("#saveLocationButton").attr("value","Saving..");
    if (document.getElementById("location-public").checked) {
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
      function(data,status) {
        //alert("Data: " + data + "\nStatus: " + status);
        document.getElementById("location-desc").value="";
        $("#saveLocationButton").attr("value","Save Location");
        $("#newlocation").hide();
        displayLocations();
      });
  }
}
function validateDesc(desc) {
  if (desc.length !== 0) {
    document.getElementById("warningdesc").innerHTML = "";
    return true;
  } else {
    document.getElementById("warningdesc").innerHTML = "You should enter a description.";
    return false;
  }
}
/*displays user's locations in the my locations tab */
function displayLocations() {
  document.getElementById("displayLocations").innerHTML="<h3>Loading</h3>";
  $.get("validation.php",
    {
      "location-user": 1
    },
    function(data,status) {
      //alert("Data: " + data + "\nStatus: " + status);
      document.getElementById("displayLocations").innerHTML=data;
      $(".panel-footer").hide();
    });
}
/*displays public locations in the public tab */
function displayPublic() {
  document.getElementById("displayLocations").innerHTML="<h3>Loading</h3>";
$.get("validation.php",
  {
    "location-public": 1
  },
  function(data,status) {
    //alert("Data: " + data + "\nStatus: " + status);
    document.getElementById("displayLocations").innerHTML=data;
  });
}
/*clicking on a location panel would call this function to show that panel's location on the map*/
function showInMap(panel) {
  map2.setZoom(parseInt(panel.getAttribute("zoom")));
  map2.panTo(new google.maps.LatLng(parseFloat(panel.getAttribute("a")), parseFloat(panel.getAttribute("f"))));
  placeMarker(new google.maps.LatLng(parseFloat(panel.getAttribute("a")), parseFloat(panel.getAttribute("f"))), map2);
}

function selectLocation(panel) {
  $(".panel-footer").hide();
  showInMap(panel);
  $(panel).children().show();
}

function deleteLocation(panelFooter) {
  $.get("validation.php",
  {
    "delete-location": $(panelFooter).parent().parent().attr("locno")
  },
  function(data,status) {
    //alert("Data: " + data + "\nStatus: " + status);
    displayLocations();
  });
}

function changeLocationPrivacy(panelFooter,share) {
  $.get("validation.php",
  {
    "share-lno": $(panelFooter).parent().parent().attr("locno"),
    "share": share
  },
  function(data,status) {
    //alert("Data: " + data + "\nStatus: " + status);
    displayLocations();
  });
}