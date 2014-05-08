<?php 
  class places_controller {

    static function draw() {
      global $firephp;
      $usuario = "";
      $admin = 0;
      $titulo = "WHYB map";
      $header = header::construye($usuario, $admin);
      $body = "";
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

  }
?>