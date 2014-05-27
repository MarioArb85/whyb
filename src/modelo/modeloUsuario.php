<?php
	class modeloUsuario {

		//Guarda usuario
		static function alta($request){
			global $firephp;
			//Comprobar si los campos obligatorios estan completados
			$avisos = self::verificacion($request);
			if ($avisos != "")  // se ha producido algún error en la verificación
	  			throw new LogicException($avisos);
    		else {
    			$dob = $request->get('selYear')."-".$request->get('selMonth')."-".$request->get('selDay');
      			$conexion = accesoBBDD::abreConexionBD();

      			if (!$conexion)
      				die('Error de conexión (' . $conexion->connect_errno . ') ' . $conexion->connect_error);

      			$consulta = "INSERT INTO users (rolId, countryId, nickname, password, email, name, birthdate, sex)
	                 		VALUES (3, '".$request->get('selCountries')."', '".$request->get('txtUserName')."', '".md5($request->get('txtPass'))."',
                     '".$request->get('txtMail')."', '".$request->get('txtName')."', '$dob', '".$sex = $request->get('sex')."')";
				
				$resultado = $conexion->query($consulta);
				//$firephp->log($resultado, 'nuevo usuario');

				if ($resultado) {
			      AccesoBBDD::cierraConexionBD($conexion);
		        } 
		        else {
		        	switch ($conexion->errno) {
		            	case 1062:
		            	$mensajeError = "Nombre de usuario ya existente";
		            	break;
		        	}
					AccesoBBDD::cierraConexionBD($conexion);
				 	throw new Exception("Error: $mensajeError");
		        }
		        return $resultado;
      		}
		}


		//Comprueba usuario
		static function logUser($request){
			global $firephp;
      		$conexion = accesoBBDD::abreConexionBD();

      		if (!$conexion)
      			die('Error de conexión (' . $conexion->connect_errno . ') ' . $conexion->connect_error);
      		else{
	      		$consulta = "SELECT userId, password FROM users WHERE nickname = '".$request->get('txtUserNameReg')."'";
	      		if ($resultado = $conexion->query($consulta)) {
	        		while($fila = $resultado->fetch_object()) { 
	          			$user = new Usuario($fila->userId, null, null, null, $fila->password, null, null, null, null, null);
	        		}	
	        		$resultado->free();
	      		}
	      		AccesoBBDD::cierraConexionBD($conexion);
		 		return $user;
	    	}
	  	}

		//Comprueba los campos introducidos en el formulario
		static function verificacion($request){
			$avisos = "";
		    if ($request->get('txtUserName') == "")
			  $avisos .= "- El campo usuario no puede estar vacío" . "<br /> \n";
			if ($request->get('txtPass') == "")
			  $avisos .= "- El campo contraseña no puede estar vacío" . "<br /> \n";
			if ($request->get('txtPassRep') == "")
			  $avisos .= "- El campo repetir contraseña no puede estar vacío" . "<br /> \n";
			if ($request->get('txtPass') != "" && $request->get('txtPassRep') != ""){
				if ($request->get('txtPass') != $request->get('txtPassRep'))
			  		$avisos .= "- Los contraseñas no coinciden!" . "<br /> \n";
	  		}
	  		if ($request->get('txtMail') == "")
			  $avisos .= "- El campo email no puede estar vacío" . "<br /> \n";

		    return $avisos;	  
		}
	}
?>