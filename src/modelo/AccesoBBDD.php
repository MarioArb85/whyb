<?php

class AccesoBBDD {
	
	/*** Funciones de acceso a BD ***/
	static function abreConexionBD() {
		$conexion = new mysqli('localhost', 'root', '', 'whyb');
		$conexion->set_charset('utf8');
		
		if ($conexion->connect_error){
			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}
		return $conexion;
	}
	
	static function cierraConexionBD($conexion) {
		$conexion->close();
	}
}
?>