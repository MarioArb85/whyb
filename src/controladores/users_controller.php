<?php 
  class users_controller {

    //Pinta formulario
    static function form() {
      global $firephp;
      $usuario = "";
      $admin = 0;
      $titulo = "Alta usuario";
      $header = header::construye($usuario, $admin);
      $body = formulario::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      return $pagina;
    }

    //Guarda nuevo usuario
    static function alta_mod($request) {
      global $firephp;
      $resultado = modeloUsuario::alta($request);
      $usuario = "";
      $admin = 0;
      $titulo = "Resultado registro";
      $header = header::construye($usuario, $admin);
      $body = alta_mod::construye($resultado);
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    //Registro de usuario
    static function registro() {
      global $firephp;
      $usuario = "";
      $admin = 0;
      $titulo = "Registro";
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