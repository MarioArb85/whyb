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
            <div id='menu'>
                menu
            </div>
            <div id='filters'>
                <div id='placesFilters'/>
                    Filter by:<br/><br/>
                    <a href='#'><img src='/whyb/web/img/flecha_abajo.png'/></a>&nbsp;Category:<br/>
                    <div id='placesCategory' class='sangria'>          
                        $checkCat
                    </div>  
                    <br/>
                    <a href='#' onclick='ocultar()'><img src='/whyb/web/img/flecha_abajo.png'/></a>&nbsp;Country:
                    <br/>
                    <div id='placesCountry' class='sangria'>          
                        $select
                    </div>
                    <br/>
                    <a href='#' onclick='ocultar()'><img src='/whyb/web/img/flecha_abajo.png'/></a>&nbsp;Continent:
                    <br/>
                    <div id='placesContinent' class='sangria' style='display: none;'>          
                        $checkCont
                    </div>
                    <br/>
                    
                    <hr style='color: #919aa3;' width='80%'/>
                    <br/>
                    <div id='updateList'>          
                        <input type='button' id='updateListBtn' name='updateListBtn' value='Update list'/>
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