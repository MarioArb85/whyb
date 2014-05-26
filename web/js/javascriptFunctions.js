  //Variables globales para markers
  var map = null;
  var markersArray = new Array();
  var infoWindow = null; 

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

  function ocultar(id,img){
    var div = document.getElementById(id);
    var img = document.getElementById(img);

    if (id == 'placesCategory'){
      if (div.style.display == null || div.style.display == 'none'){
        div.style.display = 'block';
        img.src = '/whyb/web/img/flecha_abajo.png';
      }
      else{
        div.style.display = 'none';
        img.src = '/whyb/web/img/flecha_derecha.png';
      }
    }

    if (id == 'placesCountry' || id == 'placesContinent'){
      var paises = document.getElementById('placesCountry');
      var imgCountry = document.getElementById('imgCountry');
      var continentes = document.getElementById('placesContinent');
      var imgCont = document.getElementById('imgContinent');

      if (paises.style.display == null || paises.style.display == 'none'){
        continentes.style.display = 'none';
        imgCont.src = '/whyb/web/img/flecha_derecha.png';
        paises.style.display = 'block';
        imgCountry.src = '/whyb/web/img/flecha_abajo.png';
      }
      else {
        paises.style.display = 'none';
        imgCountry.src = '/whyb/web/img/flecha_derecha.png';
        continentes.style.display = 'block';
        imgCont.src = '/whyb/web/img/flecha_abajo.png';
      }
    }
  }