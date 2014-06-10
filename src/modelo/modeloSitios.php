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

	      	$consulta = "DELETE FROM placesvisited WHERE userId = $userId and placeid = $placeId and visited = 0";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//No he visitado un sitio
		static function notVisited($placeId, $userId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

	      	$consulta = "DELETE FROM placesvisited WHERE userId = $userId and placeid = $placeId and visited = 1";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//Quiero visitar un sitio
		static function wantToVisit($placeId, $userId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

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

	      	$consulta = "INSERT INTO placesvisited (userId, placeId, visited, isUnesco)
	      				VALUES ($userId, $placeId, 1, 1)";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//Borrar sitio UNESCO o privado
		static function deletePlace($placeId, $userId, $myPlace){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

	      	$consulta = "DELETE FROM placesvisited WHERE userId = $userId and placeId = $placeId";
	      	$resultado = $conexion->query($consulta);

	      	//CIUDADO!!!! BORRA SITIO DE LA UNESCO!!
	      	if ($myPlace == 'true'){
	      		$consulta = "DELETE FROM places WHERE placeId = $placeId";
	      		$resultado = $conexion->query($consulta);
	      	}

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//Consultar mis Lugares
		static function myPlaces($userId, $country, $city){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

	      	$consulta = "select placeId, t.countryName_es, city, situation, place, description, latitude, longitude
							from places p
							join category c
							on p.categoryId = c.categoryId
							join countries t
							on p.countryId = t.countryId
							where p.placeId in (select placeId		
												from  placesvisited
												where userId = $userId
												and isUnesco = 0
												and visited = 1)";

			if ($country != ''){
				$consulta .= "and p.countryId = '$country'
								and p.city = '$city';";
			}
			if ($resultado = $conexion->query($consulta)) {
				if ($conexion->affected_rows == 0)
					$sitios = '';
				else {
					while ($fila = $resultado->fetch_object()) {	
				        $marca = array( 'placeId' => $fila->placeId, 'country' => $fila->countryName_es, 'city' => $fila->city, 'situation' => $fila->situation, 'place' => $fila->place, 'description' => $fila->description, 'lat' => $fila->latitude, 'lng' => $fila->longitude, );
				        $sitios[$fila->placeId] = $marca;
			    	}
			    }
		    }
			AccesoBBDD::cierraConexionBD($conexion);
			return $sitios;
		}

		//Borrar sitio UNESCO
		static function deleteUnesco($unescoId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

	      	$consulta = "DELETE FROM places WHERE placeId = $unescoId";
	      	$resultado = $conexion->query($consulta);

			AccesoBBDD::cierraConexionBD($conexion);

			return $resultado;
		}

		//Consultar datos sitio de la Unesco
		static function dataUnesco($unescoId){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

	      	$consulta = "SELECT categoryId, countryId, continentId, latitude, longitude, unesco_es, unescoimage, web_es FROM places WHERE placeId = $unescoId";
	      	
			if ($resultado = $conexion->query($consulta)) {
				while ($fila = $resultado->fetch_object()) {
					$datos[] = array('category' => $fila->categoryId, 'country' => $fila->countryId, 'continent' => $fila->continentId, 'lat' => $fila->latitude, 'lng' => $fila->longitude, 'name' => $fila->unesco_es, 'img' => $fila->unescoimage, 'web' => $fila->web_es);
				}
			}

			AccesoBBDD::cierraConexionBD($conexion);

			return $datos;
		}
	}
?>
