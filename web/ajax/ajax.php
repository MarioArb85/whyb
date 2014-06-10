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
			$list[3] = 'false';
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

				$consulta .= " t.categoryId != 0 and";

				$consulta .= " p.categoryId = t.categoryId and p.countryId = c.countryId and p.continentId = d.continentId;";
				//$firephp->log($consulta, 'Mensaje');
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
		                $list[3] = 'true';
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

			echo json_encode($list);
			break;

		case 'map':
			//Para pasar parámetros de vuelta
			$list = array();
			$sitios = array();
			$visitados = array();

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

				//$visitados = array();
				//Para comprobar los visitados y los pendientes de visitar
			    if (isset($_SESSION['user'])){
			       	$consulta = "SELECT placeId, visited FROM placesvisited WHERE userId=".$_SESSION['userId']." and isUnesco = 1";
			       	if ($resultado = $conexion->query($consulta)) {
			       		while ($fila = $resultado->fetch_object()) {
							$visitados[] = array ('placeId' => $fila->placeId, 'visited' => $fila->visited);
			       		}
					}
			    }
			    
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

				$consulta .= " t.categoryId != 0 and";
				
				$consulta .= " p.categoryId = t.categoryId and p.countryId = c.countryId and p.continentId = d.continentId;";
				
				if ($resultado = $conexion->query($consulta)) {
					$mark='';
					while ($fila = $resultado->fetch_object()) {
						if ($fila->categoryName_es == 'Natural')
							$mark = '/whyb/web/img/natural.png';
						else if ($fila->categoryName_es == 'Cultural')
							$mark = '/whyb/web/img/cultural.png';
						else if ($fila->categoryName_es == 'Mixto')
							$mark = '/whyb/web/img/mixed.png';

						$enlaces = '<div id="'.$fila->placeId.'" class="moreresult">';
						$entra = false;
						//comprobar si se quiere visitar o ya se ha visitado
						if (isset($_SESSION['user'])){
							if(count($visitados) > 0){
								foreach ($visitados as $key=>$value) {
									//$firephp->log($value['placeId'], 'array');
									if($value['placeId'] == $fila->placeId) {
					                	if ($value['visited'] == 0) {
					                		//$firephp->log($fila->placeId, 'result 0');
					                		$entra = true;
					                    	$enlaces .= '<a href="javascript: void(0)" class="enlace" onclick="dontWantToVisitMap('.$value['placeId'].')">Ya no quiero visitarlo!</a>';
					                    	break;
					                    }
					                	else if ($value['visited'] == 1) {
					                		//$firephp->log($fila->placeId, 'result 1');
					                		$entra = true;
					                    	$enlaces .= '<a href="javascript: void(0)" class="enlace" onclick="notVisitedMap('.$value['placeId'].')">No lo he visitado!</a>';
					                    	break;
					                    }
					                }
								}
							}
							if ($entra == false) {
				                $enlaces .= '<a href="javascript: void(0)" style="text-align: none;" class="enlace" onclick="wantToVisitMap('.$fila->placeId.')">Quiero visitarlo!</a>';
				            	$enlaces .= '<a href="javascript: void(0)" style="padding-left: 50px;" class="enlace" onclick="alreadyVisitedMap('.$fila->placeId.')">Ya visitado</a>';
				            }
				        }
				        else {
				        	$enlaces .= "<p>¡Inicia sesión para guardalo en tu lista!</p>";
				        }
				        $enlaces .= '</div>';

				        $marca = array('lat' => $fila->latitude, 'lng' => $fila->longitude, 'icon' => $mark,'title' => $fila->unesco_es, 'img' => $fila->unescoimage, 'country' => $fila->countryName_es, 'continent' => $fila->continentName_es, 'category' => $fila->categoryName_es, 'img' => $fila->unescoimage, 'web' => $fila->web_es, 'placeId' => $fila->placeId, 'enlaces' => $enlaces);
				        $sitios[$fila->placeId] = $marca;
			    	}
			    	$list[] = $sitios;
			    }
			}

			echo json_encode($list);
			break;

		case 'private_list':
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

				$consulta .= " t.categoryId != 0 and";

				$consulta .= " p.categoryId = t.categoryId and p.countryId = c.countryId and p.continentId = d.continentId;";
				$firephp->log($consulta, 'Mensaje');
				if ($resultado = $conexion->query($consulta)) {
			        $body = '<table id="tablePrivateResults">';
			        $body .= '<tr>';
			        $body .= '<th>Nombre</th>';
			        $body .= '<th>Categoria</th>';
			        $body .= '<th>Pais</th>';
			        $body .= '<th>Continente</th>';
			        $body .= '<th>Modificar</th>';
			        $body .= '<th>Eliminar</th>';
			        $body .= '</tr>';
			        while ($fila = $resultado->fetch_object()) {
			        	$body .= '<tr id="privateResult'.$fila->placeId.'">';
			        	$body .= '<td>'.$fila->unesco_es.'</td>';
			        	$body .= '<td>'.$fila->categoryName_es.'</td>';
			        	$body .= '<td>'.$fila->countryName_es.'</td>';
			        	$body .= '<td>'.$fila->continentName_es.'</td>';
			        	$body .= '<td><a href="/whyb/web/admin/menu/modify/'.$fila->placeId.'"><img src="/whyb/web/img/edit.jpg" height="20px" width="20px"/></a></td>';
			        	$body .= '<td><a href="javascript: void(0)" onclick=\'borraUnesco("'.$fila->placeId.'")\'><img src="/whyb/web/img/error.png" height="20px" width="20px"/></a></td>';
			        	$body .= '</tr>';
	        		}
	        		$body .= '</table>';

	        		$list[] = $body;

			        // se libera el cursor
			        $resultado->free();			
				}
			}

			echo json_encode($list);
			break;

		case 'deletePrivatePlaces':
			$unescoId = $_POST['unescoId'];

			$result = modeloSitios::deleteUnesco($unescoId);
			
			echo json_encode($result);
			break;

		case 'quieroVisitar':
			//Para pasar parámetros de vuelta
			$list = array();

			$userId = $_SESSION['userId'];

			if(isset($_POST['categoria']) || isset($_POST['pais'])) {
				//Recoger datos para filtrar
				if (isset($_POST['categoria']))
					$cat = $_POST['categoria'];

				if (isset($_POST['visited']))
					$visited = $_POST['visited'];
				
				if ($_POST['pais'] != '0')
					$country = $_POST['pais'];
			    
			    $consulta = "select placeId, unescoimage, unesco_es, web_es, latitude, longitude, categoryName_es, t.countryName_es, s.continentName_es 
								from places p
								join category c
								on p.categoryId = c.categoryId
								join countries t
								on p.countryId = t.countryId
								join continents s
								on p.continentId = s.continentId
								where p.placeId in (select placeId		
													from  placesvisited
													where userId = $userId
													and isUnesco = 1
													and visited = $visited) ";

				if (isset($cat)){
					$consulta .= "and (";
					foreach ($cat as $cat) {
						$consulta .= " p.categoryId = ".$cat." or"; 
					}
					$consulta = substr($consulta, 0, -2);
					$consulta .= ")";
				}

				if ($country != '')
					$consulta .= " and p.countryId = '".$country."'";
				
				if ($resultado = $conexion->query($consulta)) {
					if ($conexion->affected_rows == 0)
						$list[] = '';
					else {
						$mark='';
						while ($fila = $resultado->fetch_object()) {
							if ($fila->categoryName_es == 'Natural')
								$mark = '/whyb/web/img/natural.png';
							else if ($fila->categoryName_es == 'Cultural')
								$mark = '/whyb/web/img/cultural.png';
							else if ($fila->categoryName_es == 'Mixto')
								$mark = '/whyb/web/img/mixed.png';

							
					        $marca = array('lat' => $fila->latitude, 'lng' => $fila->longitude, 'icon' => $mark,'title' => $fila->unesco_es, 'img' => $fila->unescoimage, 'country' => $fila->countryName_es, 'continent' => $fila->continentName_es, 'category' => $fila->categoryName_es, 'web' => $fila->web_es, 'placeId' => $fila->placeId);
					        $sitios[$fila->placeId] = $marca;
				    	}
				    	$list[] = $sitios;
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

		case 'modificarDatosUsuario':
			$userId = $_SESSION['userId'];
			$name = $_POST['name'];
			$dateOfBirth = $_POST['dateOfBirth'];
			$sex = $_POST['sex'];
			$country = $_POST['country'];

			modeloUsuario::modifyuser($userId, $name, $dateOfBirth, $sex, $country);

			$mensaje = 'Usuario modificado correctamente.';

			echo json_encode($mensaje);
			break;

		case 'bajaUsuario':
			$userId = $_SESSION['userId'];

			modeloUsuario::deleteUser($userId);

			$mensaje = 'Usuario dado de baja correctamente.';

			session_destroy();

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

		case 'deleteWU':
			$userId = $_SESSION['userId'];
			$placeId = $_POST['placeId'];
			$myPlace = $_POST['myPlace'];
			$resultado = modeloSitios::deletePlace($placeId, $userId, $myPlace);
			echo json_encode($resultado);
			break;

		case 'ciudad':
			$userId = $_SESSION['userId'];
			$country = $_POST['pais'];
			$resultado = formularios::buildCities($country,$userId);
			echo json_encode($resultado);
			break;

		case 'mapaMisLugares':
			$list = array();
			$userId = $_SESSION['userId'];
			$country = $_POST['country'];
			$city = $_POST['city'];
			$list = modeloSitios::myPlaces($userId, $country, $city);

			echo json_encode($list);
			break;

		default:
			$body = "error";
			break;
	}

?>