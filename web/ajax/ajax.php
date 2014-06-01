<?php
	require '../../src/modelo/_listaModelos.php';
	require_once '../../vendor/FirePHPCore/FirePHP.class.php';
	//Cargar firephp
	ob_start();
	//instanciar un objeto de la clase FirePHP
	$firephp = FirePHP::getInstance(true);

	//Arracamos sesion
	session_start();

	$func = $_POST['func'];

	//conexion bbdd
	$conexion = new mysqli('localhost', 'root', '', 'whyb');
	$conexion->set_charset('utf8');

	if ($conexion->connect_error){
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	switch ($func) {
		case 'result':
			//Para pasar parámetros de vuelta
			$list = array();

			//Contadores para paginar
			$contDivs = 1;
			$mostrar = 1;

			if(isset($_POST['categoria']) || isset($_POST['continente']) || isset($_POST['pais'])) {
				//Recoger datos para filtrar
				if (isset($_POST['categoria'])){
					$cat = $_POST['categoria'];
					//$category = explode(",", $cat);
				}

				if (isset($_POST['continente'])){
					$cont = $_POST['continente'];
					//$continent = explode(",", $cont);
				}

				if (isset($_POST['pais']))
					$country = $_POST['pais'];

			    $consulta = "SELECT	p.unescoimage, p.unesco_es, t.categoryName_es, c.countryName_es, d.continentName_es, p.web_es, p.placeId, p.latitude, p.longitude FROM places p, category t, countries c, continents d WHERE ";

				if (isset($cat)){
					$consulta .= "(";
					foreach ($cat as $cat) {
						$consulta .= " t.categoryId = ".$cat." or"; 
					}
					$consulta = substr($consulta, 0, -2);
					$consulta .= ") and ";
				}

				if (isset($cont)){
					$consulta .= "(";
					foreach ($cont as $cont) {
						$consulta .= " d.continentId = ".$cont." or"; 
					}
					$consulta = substr($consulta, 0, -2);
					$consulta .= ") and ";
				}

				if (isset($country)){
					$consulta .= " c.countryId = '".$country."' and";
				}

				$consulta .= " p.categoryId = t.categoryId and p.countryId = c.countryId and p.continentId = d.continentId;";
				$firephp->log($consulta, 'Mensaje');
				if ($resultado = $conexion->query($consulta)) {
					//Contadores para paginar
					$contDiv1 = 0;
					$contDiv2 = 0;
			        $body = "";
			        while ($fila = $resultado->fetch_object()) {
			        	if ($contDiv1 == 0){
			        		if ($contDivs == 1)
			        			$body .= "<div id='p".$contDivs."' class='pagedemo _current' style=''>";
			        		else 
			        			$body .= "<div id='p".$contDivs."' class='pagedemo' style='display:none;'>";	
			        	}
		                $body .= "<div class='placeresult'>";
		                $body .= "<img src='".$fila->unescoimage."' style='position: relative; float:left; height: 80px; width: 80px;'/>";
		                $body .= "<h3 class='titleresult'>".$fila->unesco_es."</h3>";
		                $body .= "<div class='textresult'>";
		                $body .= "<span><b>Categoría: </b>".$fila->categoryName_es."</span>";
		                $body .= "<br/>";
		                $body .= "<span><b>País: </b>".$fila->countryName_es."</span>";
		                $body .= "<br/>";
		                $body .= "<span><b>Continente: </b>".$fila->continentName_es."</span>";
		                $body .= "<br/>";
		                $body .= "<span><b>Web: </b><a href='".$fila->web_es."' class='linkResult' target='_blank'>".$fila->web_es."</a></span>";
		                $body .= "</div>";
		                $body .= "<div id='".$fila->placeId."' class='moreresult'>";
		                if (isset($_SESSION['user'])){  	
		                	$body .= '<a href="javascript: void(0)" style="text-align: none;" class="enlace" onclick="wantToVisit('.$fila->placeId.')">Quiero visitarlo!</a>';
		                	$body .= "<a href='javascript: void(0)' style='padding-left: 50px;' class='enlace' onclick='alreadyVisited(".$fila->placeId.")'>Ya visitado</a>";
		            	}
		            	else {
		            		$body .= "<p>¡Inicia sesión para guardalo en tu lista!</p>";
		            	}
		                $body .= "</div>";
		                $body .= "</div>";
			            $contDiv1 = 1;
		                $contDiv2++;
			            if ($contDiv2 == 12){
		                	$body .= "</div>";
		                	$contDiv1 = 0;
		                	$contDiv2 = 0;
		                	$contDivs++;
		                }
	        		}

		        	$body .= '</div>';

		        	if ($contDivs >= 10)
		        		$mostrar = 10;
		        	else
		        		$mostrar = $contDivs;

			        // se libera el cursor
			        $resultado->free();

			        $list[0] = $body;
					$list[1] = $contDivs;
					$list[2] = $mostrar;

			        //Para comprobar los visitados y los pendientes de visitar
			        if (isset($_SESSION['user'])){
			        	$consulta = "SELECT placeId, visited FROM placesvisited WHERE userId=".$_SESSION['userId']." and isUnesco = 1";
			        	if ($resultado = $conexion->query($consulta)) {
			        		while ($fila = $resultado->fetch_object()) {
			        			$result = array('placeId' => $fila->placeId, 'visited' => $fila->visited);
								$list[] = $result;
			        		}
						}
			    	}
				}
				else{ 
					$list[0] = 'Elige algún parámetro melón!';
				}
			}

			echo json_encode($list);

			break;

		case 'map':
			//Para pasar parámetros de vuelta
			$list = array();

			if(isset($_POST['categoria']) || isset($_POST['continente']) || isset($_POST['pais'])) {
				//Recoger datos para filtrar
				if (isset($_POST['categoria'])){
					$cat = $_POST['categoria'];
					//$category = explode(",", $cat);
				}

				if (isset($_POST['continente'])){
					$cont = $_POST['continente'];
					//$continent = explode(",", $cont);
				}

				if (isset($_POST['pais']))
					$country = $_POST['pais'];

			    $consulta = "SELECT	p.unescoimage, p.unesco_es, t.categoryName_es, c.countryName_es, d.continentName_es, p.web_es, p.placeId, p.latitude, p.longitude FROM places p, category t, countries c, continents d WHERE ";

				if (isset($cat)){
					$consulta .= "(";
					foreach ($cat as $cat) {
						$consulta .= " t.categoryId = ".$cat." or"; 
					}
					$consulta = substr($consulta, 0, -2);
					$consulta .= ") and ";
				}

				if (isset($cont)){
					$consulta .= "(";
					foreach ($cont as $cont) {
						$consulta .= " d.continentId = ".$cont." or"; 
					}
					$consulta = substr($consulta, 0, -2);
					$consulta .= ") and ";
				}

				if (isset($country)){
					$consulta .= " c.countryId = '".$country."' and";
				}

				$consulta .= " p.categoryId = t.categoryId and p.countryId = c.countryId and p.continentId = d.continentId;";

				if ($resultado = $conexion->query($consulta)) {
					while ($fila = $resultado->fetch_object()) {
						if ($fila->categoryName_es == 'Natural')
							$mark = '/whyb/web/img/natural.png';
						else if ($fila->categoryName_es == 'Cultural')
							$mark = '/whyb/web/img/cultural.png';
						else if ($fila->categoryName_es == 'Mixto')
							$mark = '/whyb/web/img/mixed.png';

						$marca = array('lat' => $fila->latitude, 'lng' => $fila->longitude, 'icon' => $mark,'title' => $fila->unesco_es, 'img' => $fila->unescoimage);
						$list[] = $marca;
					}
				}
			}

			echo json_encode($list);
			break;

		case 'nick':
			$nick = $_POST['nick'];
			$coincide = false;

			$consulta = "SELECT nickname from users";
			
			if ($resultado = $conexion->query($consulta)) {
					while ($fila = $resultado->fetch_object()) {
						if($fila->nickname == $nick)
							$coincide = true;
					}
			}
			echo json_encode($coincide);
			break;

		case 'mail':
			$mail = $_POST['mail'];
			$coincide = false;

			$consulta = "SELECT email from users";
			
			if ($resultado = $conexion->query($consulta)) {
					while ($fila = $resultado->fetch_object()) {
						if($fila->email == $mail)
							$coincide = true;
					}
			}
			echo json_encode($coincide);
			break;

		case 'myPlaces':
			$userId = $_SESSION['userId'];
			$countryId = $_POST['countryId'];
			$lat = $_POST['lat'];
			$lon = $_POST['lon'];
			$ciudad = $_POST['ciudad'];
			$situacion = $_POST['situacion'];
			$lugar = $_POST['lugar'];
			$comentario = $_POST['comentario'];

			modeloSitios::alta($countryId, $lat, $lon, $ciudad, $situacion, $lugar, $comentario, $userId);

			$mensaje = 'El lugar ha sido guardado correctamente.';

			echo json_encode($mensaje);
			break;

		case 'dontWantToVisit':
			$userId = $_SESSION['userId'];
			$placeId = $_POST['placeId'];
			$resultado = modeloSitios::noQuieroVisitarlo($placeId, $userId);
			echo json_encode($resultado);
			break;

		case 'notVisited':
			$userId = $_SESSION['userId'];
			$placeId = $_POST['placeId'];
			$resultado = modeloSitios::notVisited($placeId, $userId);
			echo json_encode($resultado);
			break;

		case 'wantToVisit':
			$userId = $_SESSION['userId'];
			$placeId = $_POST['placeId'];
			$resultado = modeloSitios::wantToVisit($placeId, $userId);
			echo json_encode($resultado);
			break;

		case 'alreadyVisited':
			$userId = $_SESSION['userId'];
			$placeId = $_POST['placeId'];
			$resultado = modeloSitios::alreadyVisited($placeId, $userId);
			echo json_encode($resultado);
			break;

		default:
			$body = "error";
			break;
	}

?>