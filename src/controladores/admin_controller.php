<?php 
  class admin_controller {

    static function login() {
      global $firephp;
      //Destruir sesion
      session_unset();
      session_destroy();

      $titulo = "WHYB Admin";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu='';
      $body = admin_login::construye();   
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    //Comprueba usuario
    static function logAdmin($request){
      global $firephp;
      
      $resultado = modeloAdmin::logUser($request);     
      $firephp->log($resultado, 'Mensaje');

      if($resultado != null || $resultado != ''){
        if ($resultado->getPassword() == $request->get('txtPrivatePassReg') && $resultado->getRolId() == 1){
          //Usuario y contraseña correctos
          $_SESSION['user'] = $request->get('txtPrivateUserNameReg');
          $_SESSION['userId'] = $resultado->getUserId();
          $_SESSION['userRol'] = $resultado->getRolId();
          header('Location: /whyb/web/admin/menu/');
          die();
        }
        else{
          $_SESSION['error'] = 'Error al logearse';
          $dire = '/whyb/web/admin/';
          header('Location: '.$dire);
          die();
        }
        return 'Redirigiendo...';
      }
      else{
        $firephp->log($resultado, 'Mensaje');
        $_SESSION['error'] = 'Error al logearse';
        $dire = '/whyb/web/admin/';
        header('Location: '.$dire);
        die();
      }
    }

    //Menu usuario
    static function menu() {
      global $firephp;

      $titulo = "WHYB Menu";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu='';
      $body = admin_menu::construye();   
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }

    //Menu usuario - listado sitios unesco
    static function listado() {
      global $firephp;

      $titulo = "WHYB Menu";
      $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
      $menu='';
      $body = admin_listado::construye();   
      $footer = footer::construye();
      $paginaDetalle = new plantillaPagina($titulo, $header,$menu, $body, $footer);
      $pagina = $paginaDetalle->mostrar();
      //$firephp->log($paco, 'Mensaje');
      return $pagina;
    }
  }
?>