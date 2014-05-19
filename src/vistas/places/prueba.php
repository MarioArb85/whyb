<?php
	global $firephp;

	$func = $_POST['func'];

	//Contadores para paginar
	$contDivs = 1;
	$mostrar = 1;

	//Para pasar parámetros de vuelta
	$list = array();

	switch ($func) {
		case 'result':
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

				//conexion bbdd
			    $conexion = new mysqli('localhost', 'root', '', 'whyb');
			    $conexion->set_charset('utf8');

			    if ($conexion->connect_error){
			        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			    }

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
			                $body .= "<h3 class='titleresult'>".$fila->unesco_en."</h3>";
			                $body .= "<div class='textresult'>";
			                $body .= "<span><b>Category: </b>".$fila->categoryName_en."</span>";
			                $body .= "<br/>";
			                $body .= "<span><b>Country: </b>".$fila->countryName_en."</span>";
			                $body .= "<br/>";
			                $body .= "<span><b>Continent: </b>".$fila->continentName_en."</span>";
			                $body .= "<br/>";
			                $body .= "<span><b>Web: </b><a href='".$fila->web_en."' class='linkResult' target='_blank'>".$fila->web_en."</a></span>";
			                $body .= "</div>";
			                $body .= "<div class='moreresult'>";
			                $body .= "<a href='#''>Want to visit it!</a>";
			                $body .= "<a href='#'' style='padding-left: 70px;'>Map</a>";
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

			break;

		case 'map':
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

				//conexion bbdd
			    $conexion = new mysqli('localhost', 'root', '', 'whyb');
			    $conexion->set_charset('utf8');

			    if ($conexion->connect_error){
			        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
			    }

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
						$marca = array('lat' => $fila->latitude, 'lng' => $fila->longitude, 'title' => $fila->unesco_en, 'img' => $fila->unescoimage);
						$list[] = $marca;
					}
				}
			}
			
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

	echo json_encode($list);
?>