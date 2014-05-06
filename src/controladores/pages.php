<?php 
	class pages{

		static function portada() {
			global $firephp;
		    $usuario = "";
		    $admin = 0;
		    $titulo = "Where have you been";
		    $header = header::construye($usuario, $admin);
		    $body=inicio::construye();
		    $footer = footer::construye();
		    $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
		    $pagina = $paginaDetalle->mostrar();
		    //$firephp->log($paco, 'Mensaje');
		    return $pagina;
		}










	}
 ?>