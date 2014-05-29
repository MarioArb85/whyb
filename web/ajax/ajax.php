<?php
	global $firephp;

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
			                $body .= "<div class='moreresult'>";
			                $body .= "<a href='javascript: void(0)' style='text-align: none;' class'enlace'>Quiero visitarlo!</a>";
			                $body .= "<a href='javascript: void(0)' style='padding-left: 50px;' class'enlace'>Ya visitado</a>";
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
		    	}
			}
			else{ 
				$list[0] = 'Elige algún parámetro melón!';
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

			    $consulta = "SELECT	p.unescoimage, p.unesco_en, t.categoryName_en, c.countryName_en, d.continentName_en, p.web_en, p.placeId, p.latitude, p.longitude FROM places p, category t, countries c, continents d WHERE ";

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
						if ($fila->categoryName_en == 'Natural')
							$mark = '/whyb/web/img/natural.png';
						else if ($fila->categoryName_en == 'Cultural')
							$mark = '/whyb/web/img/cultural.png';
						else if ($fila->categoryName_en == 'Mixed')
							$mark = '/whyb/web/img/mixed.png';

						$marca = array('lat' => $fila->latitude, 'lng' => $fila->longitude, 'icon' => $mark,'title' => $fila->unesco_en, 'img' => $fila->unescoimage);
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

		default:
			$body = "error";
			break;
	}



	/**
	* Asiganado listado de personas
	*/
	/*
	$persona = array('nombre' => 'Paulina', 'edad' => 14);
	$listaPersona[] = $persona;

	$persona = array('nombre' => 'Michelle', 'edad' => 1);
	$listaPersona[] = $persona;

	$persona = array('nombre' => 'Dilan', 'edad' => 5);
	$listaPersona[] = $persona;

	$persona = array('nombre' => 'Susan', 'edad' => 24);
	$listaPersona[] = $persona;

	$persona = array('nombre' => 'Israel', 'edad' => 26);
	$listaPersona[] = $persona;

	$persona = array('nombre' => 'Lola Meraz', 'edad' => 20);
	$listaPersona[] = $persona;

	$persona = array('nombre' => $nombreCliente, 'edad' => $edadCliente);
	$listaPersona[] = $persona;
	*/
?>