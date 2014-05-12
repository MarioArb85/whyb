<?php 

class places {						   

  static function construye() {
  	global $firephp;
    
    //Leer el archivo .xml
    $xml = simplexml_load_file("c:/xampp/htdocs/whyb/src/unesco/unesco_places_ES.xml");
    $xmle = simplexml_load_file("c:/xampp/htdocs/whyb/src/unesco/unesco_places_EN.xml");

    //$consulta = "INSERT INTO places (`typeId`, `name`, `region`, `country`, `latitude`, `longitude`, `unescoimage`, `web`) VALUES ";
    //$consulta = "UPDATE countries SET `countryName_es`='' WHERE `countryId`='AD';";
    $cont=2;
    $guardado ="Afganistán";
    for ($i=0; $i<=921; $i++){
        //Guardando los datos en variables
        //$categoria = $xml->row[$i]->category;
        //$sitio = $xml->row[$i]->site;
        //$latitud = $xml->row[$i]->latitude;
        //$longitud = $xml->row[$i]->longitude;
        $paisIso = $xml->row[$i]->iso_code;
        //$web = $xml->row[$i]->http_url;
        //$imagen = $xml->row[$i]->image_url;
        //$continente = $xml->row[$i]->region;
        $paisNombre = $xml->row[$i]->states;
        //$paisIsoEN = $xmle->row[$i]->iso_code;
        //$paisNombreEN = $xmle->row[$i]->states;
        //$sitioEN = $xmle->row[$i]->site;
        //$imagenEN = $xmle->row[$i]->image_url;
    	
        $firephp->log($guardado, 'guardado');
        $firephp->log($paisNombre, 'pais');    

        if ($guardado == $paisNombre) {
            $guardado = $paisNombre;
            $firephp->log($cont, 'contador');
            $cont++;
        }

        //Codificar categoría
/*        switch ($categoria) {
            case 'Natural':
                $tipo = 1; 
                break;
            case 'Cultural':
                $tipo = 2; 
                break;
            case 'Mixed':
                $tipo = 3; 
                break; 
            default:
                $tipo = 0;
                break;
        }

        //Traducir continente
        switch ($continente) {
            case 'Europe and North America':
                $region = "Europa y América del Norte"; 
                break;
            case 'Asia and the Pacific':
                $region = "Asia-Pacífico";
                break;
            case 'Africa':
                $region = "África"; 
                break;
            case 'Arab States':
                $region = "Estados Árabes";
                break;
            case 'Latin America and the Caribbean':
                $region = "Estados Árabes"; 
                break;
            default:
                $region = "none"; 
                break;
        }
*/
        //Generar consulta para introducir los datos
    	//$consulta .= " ($tipo, '$sitio', '$region', '$paisIso', $latitud, $longitud, '$imagen', '$web'),";

/*
        //Imprimir los resultados ordenados por lugar
    	//$body .= "Categoria: $tipo<br/>";
    	$body .= "Sitio: $sitio<br/>";
		//$body .= "Latitud: $latitud<br/>";
		//$body .= "Longitud: $longitud<br/>";
		$body .= "Pais ISO: $paisIso<br/>";
        $body .= "Pais nombre: $paisNombre<br/>";
		$body .= "Web: $web<br/>";
		//$body .= "Imagen: <a href='$imagen'>Imagen del lugar</a><br/>";
		$body .= "Region: $region<br/>";
        $body .= "Sitio (en): $sitioEN<br/>";
        $body .= "Pais ISO (en): $paisIsoEN<br/>";
        $body .= "Pais nombre (en): $paisNombreEN<br/>";
		$body .= "<hr/>";
*/
	}
/*
    //Cambiar la ultima , por ;
	$consulta = substr($consulta, 0, -1);
	$consulta .= ";";

	//$firephp->log($consulta, 'consulta');

	//conexion bbdd
	$conexion = new mysqli('localhost', 'root', '', 'whyb');
	$conexion->set_charset('utf8');

	if ($conexion->connect_error){
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	
	$conexion->query($consulta);
*/
	//return $consulta;
    return $body;
  }
}

?>