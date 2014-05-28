<?php 
  class menu_controller {

    static function unescoPlaces() {
      global $firephp;

      $titulo = "Sitios Unesco";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu = '';
      //$body = mapa::construye();
      $body = '';
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');

      return $pagina;
    }

  }
?>