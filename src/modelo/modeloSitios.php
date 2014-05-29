<?php
	class modeloSitios {

		//Guarda sitio propio
		static function alta($countryId, $lat, $lon, $ciudad, $lugar, $comentario, $usuarioId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		if (!$conexion){
      			die('Error de conexión (' . $conexion->connect_errno . ') ' . $conexion->connect_error);
      		}
      		else{
      			//Recuperar id del continente
	      		$consulta = "SELECT continentId FROM countries WHERE countryId='$countryId'";
	      		$resultado = $conexion->query($consulta);
	      		$fila = $resultado->fetch_object();
	      		$continentid = $fila->continentId;

	   			$consulta = "INSERT INTO places (placeId, categoryId, countryId, continentId, latitude, longitude, place, description, city)
		                 	VALUES (null, 0, '$countryId', $continentid, $lat, $lon, '$lugar', '$comentario', '$ciudad')";

				//$result = $conexion->query($consulta);
				mysql_query($consulta);
				
				//$ultimo_id = mysql_insert_id();
				$id = mysql_insert_id();
				
				$firephp->log($id, 'ultimo id');

				AccesoBBDD::cierraConexionBD($conexion);
			}
		}
	}
?>