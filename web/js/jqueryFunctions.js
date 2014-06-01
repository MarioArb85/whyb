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
          $('#results').html('<img src="/whyb/web/img/load.gif" />');
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
          console.log(markersArray[markersArray.length-1].getPosition().toString());
          console.log('valentin cabeza de chucrut');
          map.setZoom(4);
        },
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
          }
        });
      }
    });

  //Comprobar campos formulario
  if ($('#formulario').length){
      $( "#formulario" ).click(function() {
        var error = false;

        //Comprobar campo usuario
        if(!$("#txtUserName").val().match(/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]{4,}$/)){
          $("#userError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;El nombre tiene que tener al menos 4 carateres entre letras y números');
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
        if(!$("#txtPass").val().match(/^([a-z]+[0-9]+)|([0-9]+[a-z]+)/i)){
          $("#passError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;La contraseña debe tener  al menos un número y una letra');
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

        if (error == true){
          return false;
        }
      });
    }

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
          $("#userError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;El nombre tiene que tener al menos 4 carateres entre letras y números');
        }
      });
    
      //Comprobar si las contraseñas son correctas
      $("#txtPass").keyup(function() {
        if(!$("#txtPass").val().match(/^([a-z]+[0-9]+)|([0-9]+[a-z]+)/i)){
          $("#passError").html('<img src="/whyb/web/img/error.png" class="imgForm"/>&nbsp;&nbsp;La contraseña debe tener al menos un número y una letra');
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

  function getCategory(){
      var category = [];
      if ($('#placesCategory').css('display') != 'none') {
        if ($('#checkCat1').is(":checked")) {
          category.push($("#checkCat1").val());
        }
        if ($('#checkCat2').is(":checked")) {
          category.push($("#checkCat2").val());
        }
        if ($('#checkCat3').is(":checked")) {
          category.push($("#checkCat3").val());
        }
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
        if (resultado == true) {
          alert('Se ha eliminado el lugar de tu lista correctamente');
          $('#'+placeId+'').html("<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisit("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited("+placeId+")'>Ya visitado</a>");
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
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
        if (resultado == true) {
          alert('El lugar se ha eliminado de tu lista correctamente');
          $('#'+placeId+'').html("<a href='javascript: void(0)' style='text-align: none;' class='enlace' onclick='wantToVisit("+placeId+")'>Quiero visitarlo!</a><a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited("+placeId+")'>Ya visitado</a>");
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
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
        if (resultado == true) {
          alert('¡El lugar se ha agregado a tu lista correctamente!');
          $('#'+placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisit('+placeId+')">Ya no quiero visitarlo!</a>');
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
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
        if (resultado == true) {
          alert('¡El lugar se ha agregado a tu lista correctamente!');
          $('#'+placeId+'').html('<a href="javascript: void(0)" class="enlace" onclick="notVisited('+placeId+')">No lo he visitado!</a>');
        }
        else
          alert('Ha ocurrido un error. Vuelva a intentarlo mas tarde.');
      }
    });
  }