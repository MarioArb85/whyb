<?php
	class modeloSitios {

		//Guarda sitio propio
		static function alta($countryId, $lat, $lon, $ciudad, $situacion, $lugar, $comentario, $usuarioId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		//Recuperar id del continente
	      	$consulta = "SELECT continentId FROM countries WHERE countryId='$countryId'";
	      	$resultado = $conexion->query($consulta);
	      	$fila = $resultado->fetch_object();
	      	$continentid = $fila->continentId;

	   		$consulta = "INSERT INTO places (placeId, categoryId, countryId, continentId, latitude, longitude, place, description, city, situation)
		                 VALUES (null, 0, '$countryId', $continentid, $lat, $lon, '$lugar', '$comentario', '$ciudad', '$situacion')";
			$conexion->query($consulta);
			$placeId = $conexion->insert_id;

			$consulta = "INSERT INTO placesvisited (userId, placeId, visited)
		                 VALUES ($usuarioId, $placeId, 1)";
		    $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);
		}
	}
?>