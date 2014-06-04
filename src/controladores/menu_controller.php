<?php 
  class menu_controller {

    static function menu() {
      global $firephp;
      $titulo = "Menu usuario";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $userData = modeloUsuario::userData($_SESSION['userId']);
      $menu = cabecera::construye();
      $body = userMenu::construye($userData);
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');

      return $pagina;
    }
  }
?>