<?phpclass plantillaPagina {  private $titulo;  // el t�tulo (etiqueta <title>) de la p�gina  private $cabecera;  // la cabecera de la p�gina (dentro del <body>)  private $contenido;  // el contenido de la p�gina (dentro del <body>, despu�s de la cabecera)  private $pie;  // el pie de la p�gina (dentro del <body>, despu�s del contenido)  private $pagina;  // todo lo anterior junto    function __construct($titulo="", $cabecera="", $contenido, $pie="") {    global $firephp;    $css = "/whyb/web/css/estilos.css";    $this->pagina = <<<HTML<html><head>  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  <title>$titulo</title>  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>  <script type='text/javascript' src='/whyb/src/gmaps/gmaps.js'></script>  <script type="text/javascript" src="/whyb/src/paginate/jquery.paginate.js" ></script>  <link href="$css" rel="stylesheet" type="text/css"/>  <script type='text/javascript'>    var map;    $(document).ready(function(){      if($('#map').length){        map = new GMaps({          el: '#map',          lat: 46.800028,          lng: 8.136319,          zoom: 4,          zoomControl : true,        });      }      //Actualizar por ajax sitios Unesco      $('#updateListBtn').click(function(){        //Seleccionar categoria        var category = [];        if ($('#checkCat1').is(":checked")) {          category.push($("#checkCat1").val());        }        if ($('#checkCat2').is(":checked")) {          category.push($("#checkCat2").val());        }        if ($('#checkCat3').is(":checked")) {          category.push($("#checkCat3").val());        }            //Seleccionar continente        var continent = [];        if ($('#placesContinent').css('display') != 'none') {          alert('entra continente');          if ($('#checkCont1').is(":checked")) {            continent.push($("#checkCont1").val());          }          if ($('#checkCont2').is(":checked")) {            continent.push($("#checkCont2").val());          }          if ($('#checkCont3').is(":checked")) {            continent.push($("#checkCont3").val());          }          if ($('#checkCont4').is(":checked")) {            continent.push($("#checkCont4").val());          }          if ($('#checkCont5').is(":checked")) {            continent.push($("#checkCont5").val());          }          if ($('#checkCont6').is(":checked")) {            continent.push($("#checkCont6").val());          }          if ($('#checkCont7').is(":checked")) {            continent.push($("#checkCont7").val());          }        }        //Seleccionar pais        if ($('#placesCountry').css('display') != 'none' && $("#selCountries").val()!= 'noCountry' )          var country = $("#selCountries").val();        //Funcion ajax                $.ajax({          url: '/whyb/src/vistas/places/prueba.php',          type: 'POST',          data: {                func: 'result',                categoria: category,                continente: continent,                pais: country                },                          dataType: 'json',          success: function(resultado) {            $('#results').html(resultado[0]);            //Paginate            $("#paginacion").paginate({              count     : resultado[1],              start     : 1,              display     : resultado[2],              border          : true,              border_color      : '#fff',              text_color        : '#fff',              background_color      : 'black',                border_hover_color    : '#ccc',              text_hover_color      : '#000',              background_hover_color  : '#fff',               images          : false,              mouse         : 'press',              onChange          : function(page){                            $('._current','#results').removeClass('_current').hide();                            $('#p'+page).addClass('_current').show();                            }            });          },          beforeSend: function() {            $('#results').html('Cargando...');          }        });      });      //Actualizar por ajax mapa Unesco      $('#updateListBtnMap').click(function(){        //Borra marcas?        map = new GMaps({          el: '#map',          lat: 46.800028,          lng: 8.136319,          zoom: 4,          zoomControl : true,        });        //Seleccionar categoria        var category = [];        if ($('#checkCat1').is(":checked")) {          category.push($("#checkCat1").val());        }        if ($('#checkCat2').is(":checked")) {          category.push($("#checkCat2").val());        }        if ($('#checkCat3').is(":checked")) {          category.push($("#checkCat3").val());        }            //Seleccionar continente        var continent = [];        if ($('#placesContinent').css('display') != 'none') {          alert('entra continente');          if ($('#checkCont1').is(":checked")) {            continent.push($("#checkCont1").val());          }          if ($('#checkCont2').is(":checked")) {            continent.push($("#checkCont2").val());          }          if ($('#checkCont3').is(":checked")) {            continent.push($("#checkCont3").val());          }          if ($('#checkCont4').is(":checked")) {            continent.push($("#checkCont4").val());          }          if ($('#checkCont5').is(":checked")) {            continent.push($("#checkCont5").val());          }          if ($('#checkCont6').is(":checked")) {            continent.push($("#checkCont6").val());          }          if ($('#checkCont7').is(":checked")) {            continent.push($("#checkCont7").val());          }        }        //Seleccionar pais        if ($('#placesCountry').css('display') != 'none' && $("#selCountries").val()!= 'noCountry' )          var country = $("#selCountries").val();        //Funcion ajax                $.ajax({          url: '/whyb/src/vistas/places/prueba.php',          type: 'POST',          data: {                func: 'map',                categoria: category,                continente: continent,                pais: country                },                          dataType: 'json',          success: function(resultado) {            $.each(resultado, function(){              map.addMarker({                lat: this.lat,                lng: this.lng,                icon: '/whyb/web/img/sunny.png',                title: this.title,                infoWindow: {                  content: '<h3>'+this.title+'</h3><img src="'+this.img+'"/>'                }              });            });          },        });      });    });  </script>  <script type='text/javascript'>    function ocultar(){      var continentes = document.getElementById('placesContinent');      var paises = document.getElementById('placesCountry');            if (paises.style.display == null || paises.style.display == 'none'){        paises.style.display = 'block';        continentes.style.display = 'none';      }      else {        paises.style.display = 'none';        continentes.style.display = 'block';      }            /*      if (continentes.style.display == '' || continentes.style.display == 'none')        continentes.style.display = 'block';      else        continentes.style.display = 'none';      */    }  </script></head>  <body>$cabecera $contenido $pie</body></html>HTML; }    function mostrar() {    //print $this->pagina;    return $this->pagina;  }}?> 