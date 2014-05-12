<?php 

class places {						   

  static function construye() {
  	global $firephp;
    
    //Leer el archivo .xml
    $xml = simplexml_load_file("c:/xampp/htdocs/whyb/src/unesco/unesco_places_ES.xml");
    $xmle = simplexml_load_file("c:/xampp/htdocs/whyb/src/unesco/unesco_places_EN.xml");

    //conexion bbdd
    $conexion = new mysqli('localhost', 'root', '', 'whyb');
    $conexion->set_charset('utf8');

    $consulta2 = "INSERT INTO places (`typeId`, `countryId`, `continentId`, `latitude`, `longitude`, `unesco_es`, `unescoimage`, `web_es`, `web_en`) VALUES ";

    if ($conexion->connect_error){
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $cont=0;
    for ($i=0; $i<=921; $i++){
        $cont++;
        //Guardando los datos en variables
        $categoria = $xml->row[$i]->category;
        $sitio = $xml->row[$i]->site;
        $latitud = $xml->row[$i]->latitude;
        $longitud = $xml->row[$i]->longitude;
        $paisIso = $xml->row[$i]->iso_code;
        $webEN = $xml->row[$i]->http_url;
        $imagen = $xml->row[$i]->image_url;

        $paisIsoEN = $xmle->row[$i]->iso_code;
        //$sitioEN = $xmle->row[$i]->site;
        //$webEN = $xmle->row[$i]->http_url;

        $sitioEN = "";

        //Codificar categoría
        switch ($categoria) {
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

        /*$cont=0;
        for ($i=0; $i<=921; $i++){
            $cont++;
            $firephp->log($web, 'consulta');
            $firephp->log($xmle->row[$i]->http_url, 'consulta');

            if((string)$web == (string)$xmle->row[$i]->http_url){
                $firephp->log('Entrooooooooooooooooooooooooooooooooooooo', 'consulta');
                $firephp->log($cont, 'consulta');
                $sitioEN = $xmle->row[$i]->site;
                break; 
            }
        }
        */
        //Convertir pagina a español
        $web = str_replace("/en/","/es/",$webEN);

        //Covertir codigo pais a mayusculas
        $paisIso = strtoupper($paisIso);

        //Recuperar el Id del continente al que pertenece el pais
        $consulta1 = "SELECT continentId FROM countries WHERE countryId='$paisIso'";
        $result = $conexion->query($consulta1);
        $pasar = mysqli_fetch_array($result);
        $continent = $pasar['continentId'];

        //Generar consulta para introducir los datos
    	$consulta2 .= " ($tipo, '$paisIso', $continent, $latitud, $longitud, '$sitio', '$imagen', '$web', '$webEN'),";

        //Imprimir los resultados ordenados por lugar
    	$body .= "Categoria ID: $tipo<br/>";
        $body .= "Pais ISO: $paisIso<br/>";
        $body .= "Continente ID: ".$pasar['continentId']."<br/>";
		$body .= "Latitud: $latitud<br/>";
		$body .= "Longitud: $longitud<br/>";
		$body .= "Sitio: $sitio<br/>";
        $body .= "Sitio (en): $sitioEN<br/>";
		$body .= "Imagen: $imagen<br/>";
        $body .= "Web: $web<br/>";
        $body .= "Web (en): $webEN<br/>";
		$body .= "<hr/>";
	}

    //Cambiar la ultima , por ;
	$consulta2 = substr($consulta2, 0, -1);
	$consulta2 .= ";";

	$firephp->log($cont, 'consulta');

	$conexion->query($consulta2);
    

	//return $consulta;
    return $body;
  }
}

?>