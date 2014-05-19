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
    $consulta = "SELECT categoryId, categoryName_en FROM category";

    if ($resultado = $conexion->query($consulta)) {
        $checkCat = "";
        while ($fila = $resultado->fetch_object()) {
            if($fila->categoryId != 0)
                $checkCat .= "<input type='checkbox' id='checkCat".$fila->categoryId."' value='".$fila->categoryId."'/>".$fila->categoryName_en."<br/>";
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

     //Pinta checkboxes continentes
    $consulta = "SELECT continentId, continentName_en FROM continents";

    if ($resultado = $conexion->query($consulta)) {
        $checkCont = "";
        while ($fila = $resultado->fetch_object()) {
                $checkCont .= "<input type='checkbox' id='checkCont".$fila->continentId."' value='".$fila->continentId."'/>".$fila->continentName_en."<br/>";
        }       
        // se libera el cursor
        $resultado->free();
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
            <div id='results'></div>
        </div>
        <div id='paginacion'></div>";

    return $body;
  }
}
?>