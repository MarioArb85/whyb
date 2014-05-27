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
    static function iniciaSesion() {
      global $firephp;
      $usuario = "";
      $admin = 0;
      $titulo = "Iniciar sesión";
      $header = header::construye($usuario, $admin);
      $body = registro::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    //Registro de usuario - resultado
    static function logResultado($request) {
      global $firephp;
      $resultado = modeloUsuario::logUser($request);
      if ($resultado == md5($request->get('txtPassReg')){


      }
      else{
        $dire = '/whyb/web/log/';
        header('Location: '.$dire);
      }

      $usuario = "";
      $admin = 0;
      $titulo = "Iniciar sesión";
      $header = header::construye($usuario, $admin);
      $body = registro::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      //return $pagina;
      return 'Redirigiendo...';
    }
  }
?>