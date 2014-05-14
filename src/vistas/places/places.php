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
                $checkCat .= "<input type='checkbox' name='checkCat' value='".$fila->typeId."'/>".$fila->name_en."<br/>";
        }       
        // se libera el cursor
        $resultado->free();
    }


    //Pinta checkboxes continentes
    $consulta = "SELECT continentId, name_en FROM continents";

    if ($resultado = $conexion->query($consulta)) {
        $checkCont = "";
        while ($fila = $resultado->fetch_object()) {
                $checkCont .= "<input type='checkbox' name='checkCont' value='".$fila->continentId."'/>".$fila->name_en."<br/>";
        }       
        // se libera el cursor
        $resultado->free();
    }


    //Pinta select paises
    $consulta = "SELECT countryId, countryname_en FROM countries ORDER BY countryname_en";

    if ($resultado = $conexion->query($consulta)) {
        $select = "<select name='selCountries' style='width:120px;'>";
        $select .= "<option value='' selected>--- No country ---</option>";
        while ($fila = $resultado->fetch_object()) {
            $select .= "<option value='".$fila->countryId."'>".$fila->countryname_en."</option>";
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
                Filter by:<br/><br/>
                <div id='placesFilters'/>
                    Category:<br/>
                    <div id='placesCategory'>          
                        $checkCat
                        <br/>
                    </div>  
                    Continent:<br/>
                    <div id='placesContinent'>          
                        $checkCont
                        <br/>
                    </div>
                    Country:<br/>
                    <div id='placesCountry'>          
                        $select
                        <br/>
                    </div>
                    <hr style='color: #919aa3;' width='80%'/>
                    <br/>
                    <div id='updateList'>          
                        <input type='button' name='updateListBtn' value='Update list'/>
                    </div>
                </div>    
            </div>
            <div id='results'>
            </div>
        </div>
    ";

    return $body;
  }
}
?>