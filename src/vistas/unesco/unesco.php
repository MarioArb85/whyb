<?php 

class unesco {						   

  static function construye() {
    global $firephp;

    //pinta categorias
    $checkCat = formularios::buildCategories();

    //pinta select
    $select = formularios::buildCountries();

    //Pinta continentes
    $checkCont = formularios::buildContinents();

    $body = "
        <div id='divCargando' class='cargando' display='none'>
            <div class='cargandoImg'>
                <img src='/whyb/web/img/load.gif' height='30px' width='30px'/>
            </div>
        </div>
        <div id='unescoPage'>
            <div id='filters'>
                <a href='#' onclick='ocultar(\"placesCategory\",\"imgCategory\")' class='linkFilter'>&nbsp;<img id='imgCategory' src='/whyb/web/img/flecha_abajo.png'/>&nbsp;&nbsp;Categoría:</a>
                <br/><br/>
                <div id='placesCategory' class='sangria'>          
                    $checkCat
                </div>  
                <br/>
                <a href='#' onclick='ocultar(\"placesCountry\",\"imgCountry\")' class='linkFilter'>&nbsp;<img id='imgCountry' src='/whyb/web/img/flecha_abajo.png'/>&nbsp;&nbsp;País:</a>
                <br/><br/>
                <div id='placesCountry' class='sangria'>          
                    $select
                </div>
                <br/>
                <a href='#' onclick='ocultar(\"placesContinent\",\"imgContinent\")' class='linkFilter'>&nbsp;<img id='imgContinent' src='/whyb/web/img/flecha_derecha.png'/>&nbsp;&nbsp;Continente:</a>
                <br/><br/>
                <div id='placesContinent' class='sangria' style='display: none;'>          
                    $checkCont
                </div>
                <br/><br/>
                <div id='updateList'>          
                    <a href='javascript: void(0)' id='updateListBtn' name='updateListBtnMap' class='formularioBtn enlace'/>Actualizar</a>
                </div>
            </div>
            <div id='results'></div>
        </div>
        <div id='paginacion'></div>";

    return $body;
  }
}
?>