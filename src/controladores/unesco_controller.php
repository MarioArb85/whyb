<?php 
  class unesco_controller {

    static function draw() {
      //global $firephp;
      $titulo = "Sitios Unesco";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu = menu::construye($usuario, 'linkActive', '', '', '');
      $body = unesco::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

  }
?>