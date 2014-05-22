  //Variables globales para markers
  var map = null;
  var markersArray = new Array();
  var infoWindow = null; 

  function ocultar(){
    var continentes = document.getElementById('placesContinent');
    var paises = document.getElementById('placesCountry');
      
    if (paises.style.display == null || paises.style.display == 'none'){
      paises.style.display = 'block';
      continentes.style.display = 'none';
    }
    else {
      paises.style.display = 'none';
      continentes.style.display = 'block';
    }
  }

  function initialize() {
    if (document.getElementById("map")){
      var mapOptions = {
        center: new google.maps.LatLng(20, 10),
        zoom: 2,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(document.getElementById("map"), mapOptions);
      google.maps.event.addListener(map, 'click', function(){
        closeInfoWindow();
      });
    }
  }

  function clearOverlays() {
    for (var i = 0; i < markersArray.length; i++ ) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;
  }

  function closeInfoWindow() {
    infoWindow.close();
  }
 
  function openInfoWindow(marker,title,image) {
    var markerLatLng = marker.getPosition();
    infoWindow.setContent(['<h3>'+title+'</h3><img src="'+image+'"/>'].join(''));
    infoWindow.open(map, marker);
  }