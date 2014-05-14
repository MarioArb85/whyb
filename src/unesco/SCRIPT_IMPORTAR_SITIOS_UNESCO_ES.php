<?php 

class places {						   

  static function construye() {
  	global $firephp;
    
    //Leer el archivo .xml
    $xml = simplexml_load_file("c:/xampp/htdocs/whyb/src/unesco/unesco_places_ES.xml");

    //conexion bbdd
    $conexion = new mysqli('localhost', 'root', '', 'whyb');
    $conexion->set_charset('utf8');

    if ($conexion->connect_error){
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $consulta = "INSERT INTO pruebaxml (`countryId`, `region`, `category`, `name`, `latitude`, `longitude`, `web`, `image`) VALUES ";

    foreach ($xml->row as $fila) {
        //Guardando los datos en variables
        $cuontryId = $fila->iso_code;
        $region = $fila->region;
        $category = $fila->category;
        $name = $fila->site;
        $latitude = $fila->latitude;
        $longitude = $fila->longitude;
        $web = $fila->http_url;
        $image = $fila->image_url;

        //Convertir pagina a español
        $web = str_replace("/en/","/es/",$web);

        //Covertir codigo pais a mayusculas
        $cuontryId = strtoupper($cuontryId);

        //Generar consulta para introducir los datos
    	$consulta .= " ('$cuontryId', '$region', '$category', '$name', $latitude, $longitude, '$web', '$image'),";

        //Imprimir los resultados ordenados por lugar
    	$body .= "INSERT INTO pruebaxml (`countryId`, `region`, `category`, `name`, `latitude`, `longitude`, `web`, `image`) VALUES ('$cuontryId', '$region', '$category', '$name', $latitude, $longitude, '$web', '$image');<hr/>";
	}

    //Cambiar la ultima , por ;
	$consulta = substr($consulta, 0, -1);
	$consulta .= ";";

    //Ver en consola la consulta buena
	$firephp->log($consulta, 'consulta');

	//Insertar en la base de datos
    $conexion->query($consulta);
 
    return $body;
  }
}
?>