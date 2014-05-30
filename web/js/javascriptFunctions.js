  //Variables globales para markers
  var map = null;
  var mapMio = null;
  var markersArray = new Array();
  var infoWindow = null; 
  //var marker = null;

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

    if (document.getElementById("mapPlaces")){
      var mapOptions = {
        center: new google.maps.LatLng(50, 30),
        zoom: 4,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      mapMio = new google.maps.Map(document.getElementById("mapPlaces"), mapOptions);

      var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(40.416742, -3.703719),
                  draggable: true,
                  map: mapMio,
                  title: ''
                });
      google.maps.event.addListener(marker, 'dragstart', function(evt){
        $('#placesCountry').val('Esperando lugar...');
        $('#placesCity').val('Esperando lugar...');
        $('#placesSituation').val('Esperando lugar...');
        if ($('#placesComentarios').val() == 'Arrastra la marca del mapa para obtener la localización!')
          $('#placesComentarios').val('');
      });
      google.maps.event.addListener(marker, 'dragend', function(evt){
        $.ajax({
          type: "GET",
          url: 'http://maps.googleapis.com/maps/api/geocode/xml?latlng='+evt.latLng.lat().toFixed(5)+','+evt.latLng.lng().toFixed(5)+'&sensor=false',
          dataType: "xml",
          success: function(xml){
            $('#placesLat').val(evt.latLng.lat().toFixed(5));
            $('#placeslong').val(evt.latLng.lng().toFixed(5));

            $(xml).find('address_component').each(function(){

              if ($(this).find('type').text() == "administrative_area_level_2political")
                $('#placesCity').val($(this).find('long_name').text());
              else if ($(this).find('type').text() == "administrative_area_level_1political"){
                if ($('#placesCity').val() == 'Esperando lugar...')
                  $('#placesCity').val($(this).find('long_name').text());
              }

              if ($(this).find('type').text() == "route")
                $('#placesSituation').val($(this).find('long_name').text()); 
              
              if ($(this).find('type').text() == "countrypolitical"){
                $('#placesCountry').val($(this).find('long_name').text()); 
                $('#placesCountryId').val($(this).find('short_name').text());
                return false;
              }
            });
            if($('#placesCity').val() == 'Esperando lugar...')
              $('#placesCity').val('Error al localizar!');
            if($('#placesSituation').val() == 'Esperando lugar...')
              $('#placesSituation').val('Error al localizar!');
            if($('#placesCountry').val() == 'Esperando lugar...')
              $('#placesCountry').val('Error al localizar!');
          },
          error: function() {
            alert("An error occurred while processing XML file.");
          }
        });     
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