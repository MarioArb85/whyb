<?php 
  class places_controller {

    static function draw() {
      global $firephp;
      //Comprobar si existe usuario
      (isset($_SESSION['user']))? $user = $_SESSION['user'] : $user = "";
      $titulo = "Mis lugares";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu = menu::construye($usuario, '', '', 'linkActive', '');
      if ($user == "")
        $body = sinRegistrar::construye();
      else
        $body = places::construye();

      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    static function myPlaces() {
      global $firephp;
      //Comprobar si existe usuario
      (isset($_SESSION['user']))? $user = $_SESSION['user'] : $user = "";
      $titulo = "Ver mis lugares";
      $header = header::construye($user);
      $menu = menu::construye($usuario, '', '', '', 'linkActive');
      if ($user == "")
        $body = sinRegistrar::construye();
      else
        $body = myMapPlaces::construye();

      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();

      return $pagina;
    }

  }
?>