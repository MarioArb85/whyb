  $(document).ready(function(){
    //Recoge pais por ip y hace la busqueda al cargar la pagina
    if ($('#selCountries').length){
      $.getJSON('http://api.wipmania.com/jsonp?callback=?', function (data) {
        $('#selCountries > option[value="'+data.address.country_code+'"]').attr('selected', 'selected');
      
        //Cargar resultados listado
        if ($('#results').length){
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

              $.each(resultado, function(){
                if($('#'+this.placeId+'').length){
                  if (this.visited == 0)
                    $('#'+this.placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisit('+this.placeId+')">Ya no quiero visitarlo!</a>');
                  else if (this.visited == 1)
                    $('#'+this.placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="notVisited('+this.placeId+')">No lo he visitado!</a>');
                }
              });

              //Paginate
              $("#paginacion").paginate({
                count: resultado[1],
                start: 1,
                display: resultado[2],
                border: true,
                border_color: '#fff',
                text_color: 'white',
                background_color: '#34629b',  
                border_hover_color: '#ccc',
                text_hover_color: '#34629b',
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
              $('#divCargando').css("display","block");
            },
            complete: function() {
              $('#divCargando').css("display","none");
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
              infoArray = resultado;
              $.each(resultado[0], function(){
                //Nuevo marcador
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(this.lat, this.lng),
                  icon: this.icon,
                  map: map,
                  title: this.title
                });
                //Meter marker en array de marcadores
                //markersArray.push(marker);
                markersArray[this.placeId] = marker;
                //Variable para datos para infowindow
                var contentString = '\
                  <div class="placeresult" style="border:none;">\
                  <img src="'+this.img+'" style="position: relative; float:left; height: 80px; width: 80px;"/>\
                  <h3 class="titleresult">'+this.title+'</h3>\
                  <div class="textresult">\
                  <span><b>Categoría: </b>'+this.category+'</span>\
                  <br/>\
                  <span><b>País: </b>'+this.country+'</span>\
                  <br/>\
                  <span><b>Continente: </b>'+this.continent+'</span>\
                  <br/>\
                  <span><b>Web: </b><a href="'+this.web+'" class="linkResult" target="_blank">'+this.web+'</a></span>\
                  </div>\
                  '+this.enlaces;
                //Onclick
                google.maps.event.addListener(marker, 'click', function() {
                  if (infoWindow != null)
                    closeInfoWindow();

                  map.setZoom(5);
                  map.setCenter(marker.getPosition());
                  //nuevo infowindow
                  infoWindow = new google.maps.InfoWindow({
                    content: contentString
                  });
                  infoWindow.open(map, marker);
                });
              });
              map.setCenter(markersArray[markersArray.length-1].getPosition());
              map.setZoom(4);
            },
            beforeSend: function() {
              $('#divCargandoMap').css("display","block");
            },
            complete: function() {
              $('#divCargandoMap').css("display","none");
            }
          });
        }
      });
    };

    //Actualizar por ajax sitios Unesco
    $('#updateListBtn').click(function(){
      //Seleccionar categoria
      var category = getCategory('placesCategory', 'checkCat');
      //Seleccionar continente
      var continent = getContinent();
      //Seleccionar pais
      var country = getCountry('placesCountry', 'selCountries');

      //Comprobar si están todos los campos vacíos antes de enviar la consulta
      if(country == undefined && category == '' && continent == ''){
        alert('Tienes que elegir algún parámetro!')
        return false;
      }
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
          if (resultado[3] != 'false'){
            $('#results').html(resultado[0]);

            $.each(resultado, function(){
              if($('#'+this.placeId+'').length){
                if (this.visited == 0)
                  $('#'+this.placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisit('+this.placeId+')">Ya no quiero visitarlo!</a>');
                else if (this.visited == 1)
                  $('#'+this.placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="notVisited('+this.placeId+')">No lo he visitado!</a>');
              }
            });

            //Paginate
            $("#paginacion").paginate({
              count: resultado[1],
              start: 1,
              display: resultado[2],
              border: true,
              border_color: '#fff',
              text_color: 'white',
              background_color: '#34629b',  
              border_hover_color: '#ccc',
              text_hover_color: '#34629b',
              background_hover_color: '#fff', 
              images: false,
              mouse: 'press',
              onChange: function(page){
                $('._current','#results').removeClass('_current').hide();
                $('#p'+page).addClass('_current').show();
              }
            });
          }
          else
            alert('No se ha encontrado ningún resultado');
        },
        beforeSend: function() {
          $('#divCargando').css("display","block");
        },
        complete: function() {
          $('#divCargando').css("display","none");
        }
      });
    });

    //Actualizar por ajax mapa Unesco
      $('#updateListBtnMap').click(function(){
      clearOverlays();

      //Seleccionar categoria
      var category = getCategory('placesCategory', 'checkCat');
      //Seleccionar continente
      var continent = getContinent();
      //Seleccionar pais
      var country = getCountry('placesCountry', 'selCountries');

      //Comprobar si están todos los campos vacíos antes de enviar la consulta
      if(country == undefined && category == '' && continent == ''){
        alert('Tienes que elegir algún parámetro!')
        return false;
      }
      
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
          if (resultado[0] != ''){
            infoArray = resultado;
            $.each(resultado[0], function(){
              //Nuevo marcador
              var marker = new google.maps.Marker({
                position: new google.maps.LatLng(this.lat, this.lng),
                icon: this.icon,
                map: map,
                title: this.title
              });
              //Meter marker en array de marcadores
              //markersArray.push(marker);
              markersArray[this.placeId] = marker;
              //Variable para datos para infowindow
              var contentString = '\
                <div class="placeresult" style="border:none;">\
                <img src="'+this.img+'" style="position: relative; float:left; height: 80px; width: 80px;"/>\
                <h3 class="titleresult">'+this.title+'</h3>\
                <div class="textresult">\
                <span><b>Categoría: </b>'+this.category+'</span>\
                <br/>\
                <span><b>País: </b>'+this.country+'</span>\
                <br/>\
                <span><b>Continente: </b>'+this.continent+'</span>\
                <br/>\
                <span><b>Web: </b><a href="'+this.web+'" class="linkResult" target="_blank">'+this.web+'</a></span>\
                </div>\
                '+this.enlaces;
              //Onclick
              google.maps.event.addListener(marker, 'click', function() {
                if (infoWindow != null)
                  closeInfoWindow();

                map.setZoom(5);
                map.setCenter(marker.getPosition());
                //nuevo infowindow
                infoWindow = new google.maps.InfoWindow({
                  content: contentString
                });
                infoWindow.open(map, marker);
              });
            });
            map.setCenter(markersArray[markersArray.length-1].getPosition());
            map.setZoom(4);
          }
          else
            alert('No se ha encontrado ningún resultado');
        },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
      });
    });

    //Modificar sitio Unesco
    $('#formularioUnescoBtn').click(function(){
      //id
      var unescoId = $("#txtUnescoId").val();
      //Nombre
      var nombre = $("#txtUnescoName").val();
      //Latitud
      var lat = $("#txtUnescoLong").val();
      //Longitud
      var longit = $("#txtUnescoLat").val();
      //Imagen
      var img = $("#txtUnescoImage").val();
      //Web
      var webpage = $("#txtUnescoWeb").val();
      //Categoria
      var categoriaUnesco = $("#privateCategories").val();
      //Pais
      var pais = $("#selPrivateData").val();
      //Continente
      var continente = $("#privateContinents").val();

      console.log(categoriaUnesco);
      console.log(pais);
      console.log(continente);
      console.log(webpage);

      if (nombre == "")
        alert('Hay que rellenar todos los campos!')
      else if (lat == '')
        alert('Hay que rellenar todos los campos!')
      else if (longit == '')
        alert('Hay que rellenar todos los campos!')
      else if (img == '')
        alert('Hay que rellenar todos los campos!')
      else if (webpage = '')
        alert('Hay que rellenar todos los campos!')
      else if (categoriaUnesco = '')
        alert('Hay que rellenar todos los campos!')
      else if (pais = '')
        alert('Hay que rellenar todos los campos!')
      else if (continente = '')
        alert('Hay que rellenar todos los campos!')
      else {
        //Funcion ajax        
        $.ajax({
          url: '/whyb/web/ajax/ajax.php',
          type: 'POST',
          data: {
            func: 'modifyUnescoplace',
            unescoId: unescoId,
            nombre: nombre,
            lat: lat,
            longit: longit,
            img: img,
            webpage: webpage,
            pais: pais,
            continente: continente,
            categoria: categoriaUnesco
          },                
          dataType: 'json',
          success: function(resultado) {
            alert(resultado);
          },
          beforeSend: function() {
            $('#loadingPrivateResults').css("display","block");
          },
          complete: function() {
            $('#loadingPrivateResults').css("display","none");
          }
        });
      }
    });

    //Actualizar por ajax menu privado sitios Unesco
    $('#updatePrivateListBtn').click(function(){
      //Seleccionar categoria
      var category = getCategory('placesCategory', 'checkCat');
      //Seleccionar continente
      var continent = getContinent();
      //Seleccionar pais
      var country = getCountry('placesCountry', 'selCountries');

      //Comprobar si están todos los campos vacíos antes de enviar la consulta
      if(country == undefined && category == '' && continent == ''){
        alert('Tienes que elegir algún parámetro!')
        return false;
      }
      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'private_list',
          categoria: category,
          continente: continent,
          pais: country
        },                
        dataType: 'json',
        success: function(resultado) {
          $('#privateResults').html(resultado);
        },
        beforeSend: function() {
          $('#loadingPrivateResults').css("display","block");
        },
        complete: function() {
          $('#loadingPrivateResults').css("display","none");
        }
      });
    });

    //Actualizar por ajax sitios que quiero visitar
      $('#btnQuieroVisitar').click(function(){
      clearOverlays();

      //Seleccionar categoria
      var category = getCategory('quieroVisitarCategory', 'quieroVisitar');
      //Seleccionar pais
      var country = getCountry('quieroVisitarCountry', 'selQuieroVisitarUnesco');

      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'quieroVisitar',
          categoria: category,
          pais: country,
          visited: 0
        },                
        dataType: 'json',
        success: function(resultado) {
          if (resultado != ''){
            $.each(resultado[0], function(){
              //Nuevo marcador
              var marker = new google.maps.Marker({
                position: new google.maps.LatLng(this.lat, this.lng),
                icon: this.icon,
                map: map,
                title: this.title
              });
              //Meter marker en array de marcadores
              markersArray[this.placeId] = marker;
              //Variable para datos para infowindow
              var contentString = '\
                <div class="placeresult" style="border:none;">\
                <img src="'+this.img+'" style="position: relative; float:left; height: 80px; width: 80px;"/>\
                <h3 class="titleresult">'+this.title+'</h3>\
                <div class="textresult">\
                <span><b>Categoría: </b>'+this.category+'</span>\
                <br/>\
                <span><b>País: </b>'+this.country+'</span>\
                <br/>\
                <span><b>Continente: </b>'+this.continent+'</span>\
                <br/>\
                <span><b>Web: </b><a href="'+this.web+'" class="linkResult" target="_blank">'+this.web+'</a></span>\
                </div>\
                <div id="'+this.placeId+'" class="moreresult">\
                <a href="javascript: void(0)" class="enlace" onclick="deletePlace('+this.placeId+',\'false\')">Eliminiar de la lista de sitios que quiero visitar</a>\
                </div>\
                ';
              //Onclick
              google.maps.event.addListener(marker, 'click', function() {
                if (infoWindow != null)
                  closeInfoWindow();

                map.setZoom(5);
                map.setCenter(marker.getPosition());
                //nuevo infowindow
                infoWindow = new google.maps.InfoWindow({
                  content: contentString
                });
                infoWindow.open(map, marker);
              });
            });
            map.setCenter(new google.maps.LatLng(20,10));
            map.setZoom(2);
          }
          else
            alert('No se ha encontrado ningún resultado');
        },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
      });
    });

    //Actualizar por ajax sitios Unesco que he visitado
      $('#btnVisitadoUnesco').click(function(){
      clearOverlays();

      //Seleccionar categoria
      var category = getCategory('myUnescoCategory', 'myUnescoCategory');
      //Seleccionar pais
      var country = getCountry('myUnescoSelect', 'selHeVisitadoUnesco');

      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'quieroVisitar',
          categoria: category,
          pais: country,
          visited: 1
        },                
        dataType: 'json',
        success: function(resultado) {
          if (resultado != ''){
            $.each(resultado[0], function(){
              //Nuevo marcador
              var marker = new google.maps.Marker({
                position: new google.maps.LatLng(this.lat, this.lng),
                icon: this.icon,
                map: map,
                title: this.title
              });
              //Meter marker en array de marcadores
              markersArray[this.placeId] = marker;
              //Variable para datos para infowindow
              var contentString = '\
                <div class="placeresult" style="border:none;">\
                <img src="'+this.img+'" style="position: relative; float:left; height: 80px; width: 80px;"/>\
                <h3 class="titleresult">'+this.title+'</h3>\
                <div class="textresult">\
                <span><b>Categoría: </b>'+this.category+'</span>\
                <br/>\
                <span><b>País: </b>'+this.country+'</span>\
                <br/>\
                <span><b>Continente: </b>'+this.continent+'</span>\
                <br/>\
                <span><b>Web: </b><a href="'+this.web+'" class="linkResult" target="_blank">'+this.web+'</a></span>\
                </div>\
                <div id="'+this.placeId+'" class="moreresult">\
                <a href="javascript: void(0)" class="enlace" onclick="deletePlace('+this.placeId+',\'false\')">Eliminiar de la lista de sitios que he visitado</a>\
                </div>\
                ';
              //Onclick
              google.maps.event.addListener(marker, 'click', function() {
                if (infoWindow != null)
                  closeInfoWindow();

                map.setZoom(5);
                map.setCenter(marker.getPosition());
                //nuevo infowindow
                infoWindow = new google.maps.InfoWindow({
                  content: contentString
                });
                infoWindow.open(map, marker);
              });
            });
            map.setCenter(new google.maps.LatLng(20,10));
            map.setZoom(2);
          }
          else
            alert('No se ha encontrado ningún resultado');
        },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
      });
    });

    //Cargar ciduades dependiendo del país
    $("#selMyPlaces").change(function(){
      if (this.value == 0) {
        var mandando = "<select id='selMyPlacesCities' name='selMyPlacesCities' style='width:120px;'>\
                            <option value=''>Selecciona país</option>\
                        </select>";
        $("#myCitiesSelect").html(mandando);
      }
      else {
        //Funcion ajax        
        $.ajax({
          url: '/whyb/web/ajax/ajax.php',
          type: 'POST',
          data: {
            func: 'ciudad',
            pais: this.value
          },                
          dataType: 'json',
          success: function(resultado) {
            $("#btnVisitadoMios").css('display','block');
            $("#myCitiesSelect").html(resultado);
          },
          beforeSend: function() {
            var mandando = "<select id='selMyPlacesCities' name='selMyPlacesCities' style='width:120px;'>\
                              <option value=''>Obteniendo...</option>\
                          </select>"; 
            $("#myCitiesSelect").html(mandando);
            $("#btnVisitadoMios").css('display','none');
          },
        });
      }
    });

    //Actualizar por ajax mis sitios visitados
      $('#btnVisitadoMios').click(function(){
      //Limpiar mapa de marcadores
      clearOverlays();
      //Seleccionar pais
      var country = getCountry('myPlacesSelect', 'selMyPlaces');
      //Seleccionar ciudad
      var city = $("#selMyPlacesCities").val();

      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'mapaMisLugares',
          country: country,
          city: city
        },                
        dataType: 'json',
        success: function(resultado) {
          if (resultado != ''){
          $.each(resultado, function(){
            //Nuevo marcador
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(this.lat, this.lng),
              map: map,
              icon: '/whyb/web/img/mine.png',
              title: this.title,
            });
            //Meter marker en array de marcadores
            markersArray[this.placeId] = marker;
            //Variable para datos para infowindow
            var contentString = '\
              <div style="height: 140px; width: 370px;">\
              <h1 style="width:100px;">'+this.place+'</h1>\
              <br/>\
              <span><b>Situación: </b>'+this.situation+'</span>\
              <br/>\
              <span><b>Ciudad: </b>'+this.city+'</span>\
              <br/>\
              <span><b>País: </b>'+this.country+'</span>\
              <br/>\
              <span><b>Descripción: </b>'+this.description+'</span>\
              <div id="'+this.placeId+'" class="moreresult" style="margin: 15px 30px;">\
              <a href="javascript: void(0)" class="enlace" onclick="deletePlace('+this.placeId+',\'true\')">Eliminiar este lugar</a>\
              </div>\
              </div>';
            //Onclick
            google.maps.event.addListener(marker, 'click', function() {
              if (infoWindow != null)
                closeInfoWindow();

              map.setZoom(5);
              map.setCenter(marker.getPosition());
              //nuevo infowindow
              infoWindow = new google.maps.InfoWindow({
                content: contentString
              });
              infoWindow.open(map, marker);
            });
          });
          map.setCenter(new google.maps.LatLng(20,10));
          map.setZoom(2);
          }
          else
            alert('No se ha encontrado ningún resultado');
        },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
      });
    });

    //Guardar sitio propio
    $('#updateLugares').click(function(){
      //Id del pais
      var countryId = $("#placesCountryId").val();
      //Latitud
      var lat = $("#placesLat").val();
      //Longitud
      var lon = $("#placeslong").val();
      //Ciudad
      var ciudad = $("#placesCity").val();
      //Situación
      var situacion = $("#placesSituation").val();
      //Lugar
      var lugar = $("#placesLugar").val();
      //Descripcion
      var comentario = $("#placesComentarios").val();

      if (ciudad == "------")
        alert('Hay que rellenar todos los campos!')
      else if (ciudad == '')
        alert('Hay que rellenar todos los campos!')
      else if (situacion == '')
        alert('Hay que rellenar todos los campos!')
      else if (lugar == '')
        alert('Hay que rellenar todos los campos!')
      else if (comen = '')
        alert('Hay que rellenar todos los campos!')
      else {
        //Funcion ajax        
        $.ajax({
          url: '/whyb/web/ajax/ajax.php',
          type: 'POST',
          data: {
            func: 'myPlaces',
            countryId: countryId,
            lat: lat,
            lon: lon,
            ciudad: ciudad,
            situacion: situacion,
            comentario: comentario,
            lugar: lugar
          },                
          dataType: 'json',
          success: function(resultado) {
            $("#placesCountryId").val();
            $("#placesLat").val();
            $("#placeslong").val();
            $("#placesCountry").val("------");
            $("#placesCity").val("------");
            $("#placesSituation").val("------");
            $("#placesLugar").val('');
            $("#placesComentarios").val('');
            alert(resultado);
          },
          beforeSend: function() {
            $('#divCargandoMap').css("display","block");
          },
          complete: function() {
            $('#divCargandoMap').css("display","none");
          }
        });
      }
    });

  //Comprobar campos formulario
  if ($('#formulario').length){
      $( "#formularioBtn" ).click(function() {
        var error = false;

        //Comprobar campo usuario
        if(!$("#txtUserName").val().match(/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]{4,}$/)){
          $("#userError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;Al menos 4 carateres entre letras y números');
          $("#txtUserName").removeClass("correcto");
          $("#txtUserName").addClass("error");
          error = true;
        }
        else {
          if($('#txtUserName').attr('class') == 'error'){
            $("#userError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;El nombre de usuario ya esta en uso');
            $("#txtUserName").removeClass("correcto");
            $("#txtUserName").addClass("error");
            error = true;
          }
          else{
            $("#txtUserName").removeClass("error");
            $("#txtUserName").addClass("correcto");
            $("#userError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>');  
          }
        }

        //Comprobar campo contaseña
        if(!$("#txtPass").val().match(/(?=^.{6,12}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/)){
          $("#passError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;Entre 6 y 12 caracteres y al menos una mayúscula y un número');
          $("#txtPass").addClass("error"); 
          $("#txtPassRep").addClass("error");
          error = true;  
        }
        else {
          $("#txtPass").removeClass("error");
          $("#txtPass").addClass("correcto");
          $("#passError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>');  
        }

        //Comprobar campo repetir contaseña
        if($("#txtPass").val() != $("#txtPassRep").val()){
          $("#passRepError").html('<img src="/whyb/web/img/error.png" class="imgForm" />&nbsp;&nbsp;Las contraseñas no son iguales');
          $("#txtPassRep").addClass("error");
          error = true;
        }
        else {
          if($("#txtPassRep").val() != ""){
            $("#txtPassRep").removeClass("error");
            $("#txtPassRep").addClass("correcto");
            $("#passRepError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>'); 
          }
          else
            $("#passRepError").html('<img src="/whyb/web/img/error.png" class="imgForm" />&nbsp;&nbsp;La contraseña tiene que coincidir con la anterior');
        }

        //Comprobar campo email
        if(!$("#txtMail").val().match(/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/)){
          $("#mailError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;La dirección de correo electrónico no es correcta: ejemplo@ejemplo.com');
          $("#txtMail").removeClass("correcto");
          $("#txtMail").addClass("error");
          error = true;       
        }
        else {
          if($('#txtMail').attr('class') == 'error'){
            $("#mailError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;La dirección de correo electrónico ya esta en uso');
            $("#txtMail").removeClass("correcto");
            $("#txtMail").addClass("error");
            error = true;
          }
          else{
            $("#txtMail").removeClass("error");
            $("#txtPassRep").addClass("correcto");
            $("#mailError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>');
          }
        }

        var passCodificada = hex_md5($('#txtPass').val());
        $('#txtPass').val(passCodificada);
        $('#txtPassRep').val(passCodificada);
        
        if (error == true){
          return false;
        }
      });
    }

    //Codificar pass al inicar sesión
    $( "#iniSesionFormBtn" ).click(function() {
      var passCodificada = hex_md5($('#txtPassReg').val());
      $('#txtPassReg').val(passCodificada);
    });

    //Codificar pass al inicar sesión privada
    $( "#iniPrivateSesionFormBtn" ).click(function() {
      var passCodificada = hex_md5($('#txtPrivatePassReg').val());
      $('#txtPrivatePassReg').val(passCodificada);
    });

    //Modificar usuario
    $("#UserMenuBtn").click(function(){
      var name = $("#txtMenuName").val();
      var dateOfBirth = $("#selYear").val()+"-"+$("#selMonth").val()+"-"+$("#selDay").val();
      var sex = $("input[name='sex']:checked").val(); 
      var country = $("#selCountriesUser").val();

      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'modificarDatosUsuario',
          name: name,
          dateOfBirth: dateOfBirth,
          sex: sex,
          country: country
        },                
        dataType: 'json',
        success: function(resultado) {
          alert(resultado);
        },
        beforeSend: function() {
          $('#divCargandoUserMenu').css("display","block");
        },
        complete: function() {
          $('#divCargandoUserMenu').css("display","none");
        }
      });
    });

    //Baja usuario
    $("#UserDeleteMenuBtn").click(function(){
      var pregunta = confirm('Seguro que quieres dar de baja el usuario? \n Se perderán todos los lugares que has guardado.');
      if (pregunta == true) {
        //Funcion ajax        
        $.ajax({
          url: '/whyb/web/ajax/ajax.php',
          type: 'POST',
          data: {
            func: 'bajaUsuario'
          },                
          dataType: 'json',
          success: function(resultado) {
            alert(resultado);
            //Redirigir a la pagina principal!
          },
          beforeSend: function() {
            $('#divCargandoUserMenu').css("display","block");
          },
          complete: function() {
            $('#divCargandoUserMenu').css("display","none");
          }
        });
      }
    });

    //Comprobaciones al perder el foco
    if($("#txtUserName").length){
      //Comprobar usuario
      $("#txtUserName").keyup(function() {
        if($("#txtUserName").val().length >= 4){
          var nick = $("#txtUserName").val();
          //Funcion ajax        
          $.ajax({
            url: '/whyb/web/ajax/ajax.php',
            type: 'POST',
            data: {
              func: 'nick',
              nick: nick
            },                
            dataType: 'json',
            success: function(resultado) {
              if (resultado == true){
                $("#txtUserName").removeClass("correcto");
                $("#txtUserName").addClass("error");
                $("#userError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;El nombre de usuario ya esta en uso');
              }
              else{
                $("#txtUserName").removeClass("error");
                $("#txtUserName").addClass("correcto");
                $("#userError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>');
              }
            }          
          });
        }
        else{
          $("#txtUserName").removeClass("correcto");
          $("#txtUserName").addClass("error");
          $("#userError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;Al menos 4 carateres entre letras y números');
        }
      });
    
      //Comprobar si las contraseñas son correctas
      $("#txtPass").keyup(function() {
        if(!$("#txtPass").val().match(/(?=^.{6,12}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/)){
          $("#passError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;Entre 6 y 12 caracteres y al menos una mayúscula y un número');
          $("#txtPass").removeClass("correcto");
          $("#txtPass").addClass("error");
        }
        else{
          $("#txtPass").removeClass("error");
          $("#passError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>');
          $("#txtPass").addClass("correcto");
        }
      });

      $("#txtPassRep").keyup(function() {
        if($("#txtPass").val() != $("#txtPassRep").val()){
          $("#passRepError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;Las contraseñas no son iguales');
          $("#txtPassRep").removeClass("correcto");
          $("#txtPassRep").addClass("error");
        }
        else{
          if($("#txtPassRep").val().match(/^([a-z]+[0-9]+)|([0-9]+[a-z]+)/i)){
            $("#txtPassRep").removeClass("error");
            $("#passRepError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>'); 
            $("#txtPassRep").addClass("correcto");
          }
        }
      });
    
      //Comprobar si ya existe el mail al registrarse
      $("#txtMail").keyup(function() {
        if($("#txtMail").val().match(/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/)){  
          var mail = $("#txtMail").val();
          //Funcion ajax        
          $.ajax({
            url: '/whyb/web/ajax/ajax.php',
            type: 'POST',
            data: {
              func: 'mail',
              mail: mail
            },                
            dataType: 'json',
            success: function(resultado) {
              if (resultado == true){
                $("#txtMail").removeClass("correcto");
                $("#txtMail").addClass("error");
                $("#mailError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;La dirección de correo electrónico ya esta en uso');
              }
              else{
                $("#txtMail").removeClass("error");
                $("#txtMail").addClass("correcto");
                $("#mailError").html('<img src="/whyb/web/img/correcto.png" class="imgForm"/>');
              }
            }          
          });
        }
        else{
          $("#txtMail").removeClass("correcto");
          $("#txtMail").addClass("error");
          $("#mailError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;El email no es correcto: ejemplo@ejemplo.com');
        }
      });
    }
  });

  function getCategory(div,check){
      var category = [];
      if ($('#'+div).css('display') != 'none') {
        if ($('#'+check+'1').is(":checked")) 
          category.push($("#"+check+"1").val());
        if ($('#'+check+'2').is(":checked")) 
          category.push($("#"+check+"2").val());
        if ($('#'+check+'3').is(":checked")) 
          category.push($("#"+check+"3").val());
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

  function getCountry(div,select){
    if ($('#'+div).css('display') != 'none' && $("#selCountries").val()!= 'noCountry')
        return $("#"+select).val();
  }

  //FUNCIONES ACTUALIZAR LISTADO
  function dontWantToVisit(placeId){
    //Funcion ajax        
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'dontWantToVisit',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('Se ha eliminado el lugar de tu lista correctamente');
          $('#'+placeId+'').html("<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisit("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited("+placeId+")'>Ya visitado</a>");
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

  function notVisited(placeId){
    //Funcion ajax        
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'notVisited',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('El lugar se ha eliminado de tu lista correctamente');
          $('#'+placeId+'').html("<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisit("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited("+placeId+")'>Ya visitado</a>");
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

  function wantToVisit(placeId){
    //Funcion ajax 
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'wantToVisit',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('¡El lugar se ha agregado a tu lista correctamente!');
          $('#'+placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisit('+placeId+')">Ya no quiero visitarlo!</a>');
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

  function alreadyVisited(placeId){
    //Funcion ajax        
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'alreadyVisited',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('¡El lugar se ha agregado a tu lista correctamente!');
          $('#'+placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="notVisited('+placeId+')">No lo he visitado!</a>');
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }


    //FUNCIONES ACTUALIZAR MAPA
    function dontWantToVisitMap(placeId, imagen, titulo, categoria, pais, continente, web){
    $.each(infoArray, function(){
      var contentString = nuevoInfoWindow(placeId, this[placeId].img, this[placeId].title, this[placeId].category, this[placeId].country, this[placeId].continent, this[placeId].web, 'dontWantToVisit');
      nuevoClick(placeId, contentString);
    });

    //Funcion ajax        
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'dontWantToVisit',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('Se ha eliminado el lugar de tu lista correctamente');
          $('#'+placeId+'').html("<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisitMap("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited("+placeId+")'>Ya visitado</a>");
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

  function notVisitedMap(placeId, imagen, titulo, categoria, pais, continente, web){
    $.each(infoArray, function(){
      var contentString = nuevoInfoWindow(placeId, this[placeId].img, this[placeId].title, this[placeId].category, this[placeId].country, this[placeId].continent, this[placeId].web, 'notVisited');
      nuevoClick(placeId, contentString);
    });

    //Funcion ajax        
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'notVisited',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('El lugar se ha eliminado de tu lista correctamente');
          $('#'+placeId+'').html("<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisitMap("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited("+placeId+")'>Ya visitado</a>");
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

    function wantToVisitMap(placeId){
    $.each(infoArray, function(){
      var contentString = nuevoInfoWindow(placeId, this[placeId].img, this[placeId].title, this[placeId].category, this[placeId].country, this[placeId].continent, this[placeId].web, 'wantToVisit');
      nuevoClick(placeId, contentString);
    });

    //Funcion ajax 
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'wantToVisit',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('¡El lugar se ha agregado a tu lista correctamente!');
          $('#'+placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisitMap('+placeId+')">Ya no quiero visitarlo!</a>');
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

  function alreadyVisitedMap(placeId){
    $.each(infoArray, function(){
      var contentString = nuevoInfoWindow(placeId, this[placeId].img, this[placeId].title, this[placeId].category, this[placeId].country, this[placeId].continent, this[placeId].web, 'alreadyVisited');
      nuevoClick(placeId, contentString);
    });

    //Funcion ajax        
    $.ajax({
      url: '/whyb/web/ajax/ajax.php',
      type: 'POST',
      data: {
      func: 'alreadyVisited',
      placeId: placeId
      },                
      dataType: 'json',
      success: function(resultado) {
        console.log(resultado);
        if (resultado == true) {
          alert('¡El lugar se ha agregado a tu lista correctamente!');
          $('#'+placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="notVisitedMap('+placeId+')">No lo he visitado!</a>');
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      },
        beforeSend: function() {
          $('#divCargandoMap').css("display","block");
        },
        complete: function() {
          $('#divCargandoMap').css("display","none");
        }
    });
  }

  //Funcion para pintar los textos del nuevo infowindow
  function nuevoInfoWindow(placeId, imagen, titulo, categoria, pais, continente, web, redi){
    contentString = '\
                  <div class="placeresult" style="border:none;">\
                  <img src="'+imagen+'" style="position: relative; float:left; height: 80px; width: 80px;"/>\
                  <h3 class="titleresult">'+titulo+'</h3>\
                  <div class="textresult">\
                  <span><b>Categoría: </b>'+categoria+'</span>\
                  <br/>\
                  <span><b>País: </b>'+pais+'</span>\
                  <br/>\
                  <span><b>Continente: </b>'+continente+'</span>\
                  <br/>\
                  <span><b>Web: </b><a href="'+web+'" class="linkResult" target="_blank">'+web+'</a></span>\
                  </div>\
                  <div id="'+placeId+'" class="moreresult">';

    switch (redi){
      case 'wantToVisit':
        contentString += '<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisitMap('+placeId+')">Ya no quiero visitarlo!</a>';
        break;
      case 'alreadyVisited':
        contentString += '<a href="javascript: void(0)" class="enlace" onclick="notVisitedMap('+placeId+')">No lo he visitado!</a>';
        break;
      case 'dontWantToVisit':
        contentString += "<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisitMap("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisitedMap("+placeId+")'>Ya visitado</a>";
        break;
      case 'notVisited':
        contentString += "<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisitMap("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisitedMap("+placeId+")'>Ya visitado</a>";
        break;
      default:
        break;
    } 

    contentString += '</div>';

    return contentString;
  }

  //Funcion para pintar nuevo infowindow
  function nuevoClick(placeId, contentString){
    google.maps.event.addListener(markersArray[placeId], 'click', function() {
        if (infoWindow != null)
          closeInfoWindow();

        map.setZoom(5);
        map.setCenter(markersArray[placeId].getPosition());
        //nuevo infowindow
        infoWindow = new google.maps.InfoWindow({
          content: contentString
        });
        infoWindow.open(map, markersArray[placeId]);
      });
  }

  function deletePlace(placeId, myPlace){
    var segurir = confirm ('¿Seguro que deseas elimiar este lugar?');
    if (segurir == true) {
      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'deleteWU',
          placeId: placeId,
          myPlace: myPlace
        },                
        dataType: 'json',
        success: function(resultado) {
          console.log(resultado);
          if (resultado == true) {
            markersArray[placeId].setMap(null);
            alert('¡El lugar se ha eliminado correctamente!');
          }
          else
            alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
        },
          beforeSend: function() {
            $('#divCargandoMap').css("display","block");
          },
          complete: function() {
            $('#divCargandoMap').css("display","none");
          }
      });
    }
  }

  function borraUnesco(unescoId){
    var conf = confirm("¿Estas seguro que quieres eliminar este lugar de la Unesco?");
    if (conf == true){ 
      //Funcion ajax        
      $.ajax({
        url: '/whyb/web/ajax/ajax.php',
        type: 'POST',
        data: {
          func: 'deletePrivatePlaces',
          unescoId: unescoId
        },                
        dataType: 'json',
        success: function(resultado) {
          if (resultado == true) {
            $('#privateResult'+unescoId).remove();
            alert('¡El lugar se ha eliminado correctamente!');
          }
          else
            alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
        },
          beforeSend: function() {
            $('#loadingPrivateResults').css("display","block");
          },
          complete: function() {
            $('#loadingPrivateResults').css("display","none");
          }
      });
    }
  }