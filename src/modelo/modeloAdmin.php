<?php
	class modeloAdmin {

		//Comprueba usuario
		static function logUser($request){
			global $firephp;

      		$conexion = accesoBBDD::abreConexionBD();

	      	$consulta = "SELECT userId, password,rolId FROM users WHERE nickname = '".$request->get('txtPrivateUserNameReg')."'";
	      	if ($resultado = $conexion->query($consulta)) {
	        	if($fila = $resultado->fetch_object()) { 
	        		$user = new Usuario($fila->userId, $fila->rolId, null, null, $fila->password, null, null, null, null, null);
	        	}
	        	else
	      			$user = '';

	        	$resultado->free();
	      	}
	      	else
	      		$user = '';
	      	
	      	AccesoBBDD::cierraConexionBD($conexion);
		 	return $user;
	  	}
	}
?>
