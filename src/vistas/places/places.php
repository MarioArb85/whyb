<?php 

class places {						   

  static function construye() {
  	global $firephp;
   
    $conexion = new mysqli('localhost', 'root', '', 'whyb');
    $conexion->set_charset('utf8');

    if ($conexion->connect_error){
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }


    //Pinta checkboxes categorias
    $consulta = "SELECT typeId, name_en FROM type";

    if ($resultado = $conexion->query($consulta)) {
        $checkCat = "";
        while ($fila = $resultado->fetch_object()) {
            if($fila->typeId != 0)
                $checkCat .= "<input type='checkbox' id='checkCat".$fila->typeId."' value='".$fila->typeId."'/>".$fila->name_en."<br/>";
        }       
        // se libera el cursor
        $resultado->free();
    }


    //Pinta checkboxes continentes
    $consulta = "SELECT continentId, name_en FROM continents";

    if ($resultado = $conexion->query($consulta)) {
        $checkCont = "";
        while ($fila = $resultado->fetch_object()) {
                $checkCont .= "<input type='checkbox' id='checkCont".$fila->continentId."' value='".$fila->continentId."'/>".$fila->name_en."<br/>";
        }       
        // se libera el cursor
        $resultado->free();
    }


    //Pinta select paises
    $consulta = "SELECT countryId, countryname_en FROM countries ORDER BY countryname_en";

    if ($resultado = $conexion->query($consulta)) {
        $select = "<select id='selCountries' name='selCountries' style='width:120px;'>";
        $select .= "<option value='noCountry' selected>--- No country ---</option>";
        while ($fila = $resultado->fetch_object()) {
            if($fila->countryId != 'DE')
                $select .= "<option value='".$fila->countryId."'>".$fila->countryname_en."</option>";
            else
                $select .= "<option value='".$fila->countryId."' selected>".$fila->countryname_en."</option>";
        }       
        // se libera el cursor
        $resultado->free();
        $select .= "</select>";
    }

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
            <div id='results'>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_417.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Ibiza, biodiversidad y cultura</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Mixed</span>
                        <br/>
                        <span><b>Country: </b>Spain</span>
                        <br/>
                        <span><b>Continent: </b>Europe</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
                <div class='placeresult'>
                    <img src='http://whc.unesco.org/uploads/sites/site_367.jpg' style='position: relative; float:left;'/>
                    <h3 class='titleresult'>Tréveris - Monumentos romanos, catedral de San Pedro e iglesia de Nuestra Señora</h3>
                    <div class='textresult'>
                        <span><b>Category: </b>Cultural</span>
                        <br/>
                        <span><b>Country: </b>Alemania</span>
                        <br/>
                        <span><b>Continent: </b>Europa</span>
                        <br/>
                        <span><b>Web: </b><a href='http://whc.unesco.org/es/list/367' class='linkResult'>http://whc.unesco.org/es/list/367</a></span>
                    </div>
                    <div class='moreresult'>
                        <a href='#''>Want to visit it!</a>
                        <a href='#'' style='padding-left: 70px;'>Map</a>
                    </div>
                </div>
            </div>
        </div>
        <div id='paginacion'></div>
    ";

    return $body;
  }
}
?>