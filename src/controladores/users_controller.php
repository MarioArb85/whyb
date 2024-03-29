<?php 
  class users_controller {

    //Pinta formulario
    static function form() {
      global $firephp;
      $titulo = "Alta usuario";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu='';
      $body = formulario::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      return $pagina;
    }

    //Guarda nuevo usuario
    static function alta_mod($request) {
      global $firephp;
      $resultado = modeloUsuario::alta($request);
      $titulo = "Resultado registro";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu='';
      $body = alta_mod::construye($resultado);
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    //Registro de usuario
    static function iniciaSesion() {
      global $firephp;
      $titulo = "Iniciar sesión";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu='';
      $body = registro::construye();
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header, $menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    //Registro de usuario - resultado
    static function logResultado($request) {
      global $firephp;

        $resultado = modeloUsuario::logUser($request);
        
        $firephp->log($resultado, 'Mensaje');

        if($resultado != null || $resultado != ''){
          if ($resultado->getPassword() == $request->get('txtPassReg')){
            //Usuario y contraseña correctos
            $_SESSION['user'] = $request->get('txtUserNameReg');
            $_SESSION['userId'] = $resultado->getUserId();

            header('Location: /whyb/web/places/show/');
            die();
          }
          else{
            $_SESSION['error'] = 'Error al logearse';
            $dire = '/whyb/web/log/';
            header('Location: '.$dire);
            die();
          }
          return 'Redirigiendo...';
        }
        else{
          $firephp->log($resultado, 'Mensaje');
          $_SESSION['error'] = 'Error al logearse';
          $dire = '/whyb/web/log/';
          header('Location: '.$dire);
          die();
        }

    }

    static function disconnect() {
      session_destroy();
      header('Location: /whyb/web/');
      die();
      return 'Redirigiendo...';
    }

  }
?>