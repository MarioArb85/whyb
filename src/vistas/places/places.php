<?php 

class places {						   

  static function construye() {
    global $firephp;

    //pinta categorias
    $checkCat = formularios::buildCategories();

    //pinta select
    $select = formularios::buildCountries('ES');

    //Pinta continentes
    $checkCont = formularios::buildContinents();

    $body = "
        <div id='placesPage'>
            <div id='filters'>
                <div id='placesFilters'/>
                    Filter by:<br/><br/>
                    <a href='#' onclick='ocultar(\"placesCategory\",\"imgCategory\")'><img id='imgCategory' src='/whyb/web/img/flecha_abajo.png'/></a>&nbsp;Category:<br/>
                    <div id='placesCategory' class='sangria'>          
                        $checkCat
                    </div>  
                    <br/>
                    <a href='#' onclick='ocultar(\"placesCountry\",\"imgCountry\")'><img id='imgCountry' src='/whyb/web/img/flecha_abajo.png'/></a>&nbsp;Country:
                    <br/>
                    <div id='placesCountry' class='sangria'>          
                        $select
                    </div>
                    <br/>
                    <a href='#' onclick='ocultar(\"placesContinent\",\"imgContinent\")'><img id='imgContinent'src='/whyb/web/img/flecha_derecha.png'/></a>&nbsp;Continent:
                    <br/>
                    <div id='placesContinent' class='sangria' style='display: none;'>          
                        $checkCont
                    </div>
                    <br/>
                    
                    <hr style='color: #919aa3;' width='80%'/>
                    <br/>
                    <div id='updateList'>          
                        <input type='button' id='updateListBtn' name='updateListBtn' value='Update list' class='formularioBtn'/>
                    </div>
                </div>    
            </div>
            <div id='results'></div>
        </div>
        <div id='paginacion'></div>";

    return $body;
  }
}
?>