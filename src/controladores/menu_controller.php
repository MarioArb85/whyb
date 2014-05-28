<?php 
  class menu_controller {

    static function menu() {
      global $firephp;

      $titulo = "Sitios Unesco";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu = cabecera::construye();
      $body = userMenu::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');

      return $pagina;
    }
  }
?>