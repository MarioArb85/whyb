<?php 

class myMapPlaces {						   

  static function construye() {
    global $firephp;

    //pinta categorias
    $checkCat = formularios::buildCategories();
    //pinta formulario mis sitios unesco
    $formularioUnesco = formularios::buildMyCountries('1');
    //pinta formulario mis sitios
    $formularioMisSitios = formularios::buildMyCountries('0');

    $body = "
            <div id='divCargandoMap' class='cargandoMap' style='display: none;'>
                <div class='cargandoImg'>
                    <img src='/whyb/web/img/load.gif' height='30px' width='30px'/>
                </div>
            </div>
            <div id='myMapPage'>  
                <div id='filters'>
                    <a href='#'class='linkFilter'>&nbsp;<img id='imgCategory' src='/whyb/web/img/flecha_abajo.png'/>&nbsp;&nbsp;Categoría:</a>
                    <br/><br/>
                    <div id='placesCategory' class='sangria'>          
                        $checkCat
                    </div>  
                    <br/>
                    <a href='#' class='linkFilter'>&nbsp;<img id='imgCountry' src='/whyb/web/img/flecha_abajo.png'/>&nbsp;&nbsp;País:</a>
                    <br/><br/>
                    <div id='placesCountry' class='sangria'>          
                        $formularioUnesco
                    </div>
                    <br/>
                </div>
                <div id='mapPlaces'>
                </div>
            </div>
            ";

    return $body;
  }
}
?>