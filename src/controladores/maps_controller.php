<?php 
  class maps_controller {

    static function draw() {
      global $firephp;
      $usuario = "";
      $admin = 0;
      $titulo = "WHYB map";
      $header = header::construye($usuario, $admin);
      $menu = menu::construye($usuario);
      $body = mapa::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;

    }

  }
?>