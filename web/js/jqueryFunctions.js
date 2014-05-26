  $(document).ready(function(){

    //Recoge pais por ip y hace la busqueda al cargar la pagina
    if ($('#selCountries').length){
      $.getJSON('http://api.wipmania.com/jsonp?callback=?', function (data) {
        $('#selCountries > option[value="'+data.address.country_code+'"]').attr('selected', 'selected');
      
        //Cargar resultados listado
        if ($('#results').length){
          //alert($("#selCountries").val());
          //Funcion ajax        
          $.ajax({
            url: '/whyb/web/ajax/ajax.php',
            type: 'POST',
            data: {
              func: 'result',
              pais: data.address.country_code
            },                
            dataType: 'json',
            success: function(resultado) {
              $('#results').html(resultado[0]);
              //Paginate
              $("#paginacion").paginate({
                count: resultado[1],
                start: 1,
                display: resultado[2],
                border: true,
                border_color: '#fff',
                text_color: '#fff',
                background_color: 'black',  
                border_hover_color: '#ccc',
                text_hover_color: '#000',
                background_hover_color: '#fff', 
                images: false,
                mouse: 'press',
                onChange: function(page){
                  $('._current','#results').removeClass('_current').hide();
                  $('#p'+page).addClass('_current').show();
                }
              });
            },
            beforeSend: function() {
              $('#results').html('<img src="/whyb/web/img/load.gif" />');
            }
          });
        }
        //Cargar resultados mapa
        if ($('#map').length){
          clearOverlays();
          //Funcion ajax        
          $.ajax({
            url: '/whyb/web/ajax/ajax.php',
            type: 'POST',
            data: {
              func: 'map',
              pais: data.address.country_code
            },                
            dataType: 'json',
            success: function(resultado) {
              $.each(resultado, function(){
                //Nuevo marcador
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(this.lat, this.lng),
                  icon: this.icon,
                  map: map,
                  title: this.title
                });
                //Para pasar parametro al onclick
                var img = this.img;
                //Meter marker en array de marcadores
                markersArray.push(marker);
                //nuevo infowindow
                infoWindow = new google.maps.InfoWindow();
                //Onclick
                google.maps.event.addListener(marker, 'click', function() {
                  map.setZoom(5);
                  map.setCenter(marker.getPosition());
                  infoWindow.open(map, marker);
                  openInfoWindow(marker, this.title, img);
                });
              });
              map.setCenter(markersArray[markersArray.length-1].getPosition());
              map.setZoom(4);
            },
          });
        }
      });
    };
    //Actualizar por ajax sitios Unesco
    $('#updateListBtn').click(function(){
      //Seleccionar categoria
      var category = getCategory();
      //Seleccionar continente
      var continent = getContinent();
      //Seleccionar pais
      var country = getCountry();

      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'result',
          categoria: category,
          continente: continent,
          pais: country
        },                
        dataType: 'json',
        success: function(resultado) {
          $('#results').html(resultado[0]);
          //Paginate
          $("#paginacion").paginate({
            count: resultado[1],
            start: 1,
            display: resultado[2],
            border: true,
            border_color: '#fff',
            text_color: '#fff',
            background_color: 'black',  
            border_hover_color: '#ccc',
            text_hover_color: '#000',
            background_hover_color: '#fff', 
            images: false,
            mouse: 'press',
            onChange: function(page){
              $('._current','#results').removeClass('_current').hide();
              $('#p'+page).addClass('_current').show();
            }
          });
        },
        beforeSend: function() {
          $('#results').html('Cargando...');
        }
      });
    });

    //Actualizar por ajax mapa Unesco
      $('#updateListBtnMap').click(function(){
      clearOverlays();

      //Seleccionar categoria
      var category = getCategory();
      //Seleccionar continente
      var continent = getContinent();
      //Seleccionar pais
      var country = getCountry();

      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'map',
          categoria: category,
          continente: continent,
          pais: country
        },                
        dataType: 'json',
        success: function(resultado) {
          $.each(resultado, function(){
            //Nuevo marcador
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(this.lat, this.lng),
              icon: this.icon,
              map: map,
              title: this.title
            });
            //Para pasar parametro al onclick
            var img = this.img;
            //Meter marker en array de marcadores
            markersArray.push(marker);
            //nuevo infowindow
            infoWindow = new google.maps.InfoWindow();
            //Onclick
            google.maps.event.addListener(marker, 'click', function() {
              //map.setZoom(5);
              map.setCenter(marker.getPosition());
              infoWindow.open(map, marker);
              openInfoWindow(marker, this.title, img);
            });
          });
          map.setCenter(markersArray[markersArray.length-1].getPosition());
          map.setZoom(4);
        },
      });
    });
  });

  function getCategory(){
      var category = [];
      if ($('#checkCat1').is(":checked")) {
        category.push($("#checkCat1").val());
      }
      if ($('#checkCat2').is(":checked")) {
        category.push($("#checkCat2").val());
      }
      if ($('#checkCat3').is(":checked")) {
        category.push($("#checkCat3").val());
      }
    return category;
  }

  function getContinent(){
    var continent = [];
    if ($('#placesContinent').css('display') != 'none') {
      if ($('#checkCont1').is(":checked")) {
        continent.push($("#checkCont1").val());
      }
      if ($('#checkCont2').is(":checked")) {
        continent.push($("#checkCont2").val());
      }
      if ($('#checkCont3').is(":checked")) {
        continent.push($("#checkCont3").val());
      }
      if ($('#checkCont4').is(":checked")) {
        continent.push($("#checkCont4").val());
      }
      if ($('#checkCont5').is(":checked")) {
        continent.push($("#checkCont5").val());
      }
      if ($('#checkCont6').is(":checked")) {
        continent.push($("#checkCont6").val());
      }
      if ($('#checkCont7').is(":checked")) {
        continent.push($("#checkCont7").val());
      }
    }
    return continent;
  }

  function getCountry(){
    if ($('#placesCountry').css('display') != 'none' && $("#selCountries").val()!= 'noCountry')
        return $("#selCountries").val();
  }