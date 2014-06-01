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

		//No quiero visitar un sitio
		static function noQuieroVisitarlo($placeId, $userId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		//Recuperar id del continente
	      	$consulta = "DELETE FROM placesvisited WHERE userId = $userId and placeid = $placeId and visited = 0";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//No he visitado un sitio
		static function notVisited($placeId, $userId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		//Recuperar id del continente
	      	$consulta = "DELETE FROM placesvisited WHERE userId = $userId and placeid = $placeId and visited = 1";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//Quiero visitar un sitio
		static function wantToVisit($placeId, $userId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		//Recuperar id del continente
	      	$consulta = "INSERT INTO placesvisited (userId, placeId, visited, isUnesco)
	      				VALUES ($userId, $placeId, 0, 1)";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//Ya he visitado un sitio
		static function alreadyVisited($placeId, $userId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		//Recuperar id del continente
	      	$consulta = "INSERT INTO placesvisited (userId, placeId, visited, isUnesco)
	      				VALUES ($userId, $placeId, 1, 1)";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}
	}
?>