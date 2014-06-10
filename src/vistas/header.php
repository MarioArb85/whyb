<?php 
class header {

  static function construye($usuario) {
    //Ver si es admin o no
    if($_SESSION['userRol'] == 1)
      $dire = DIR_ADMIN_MENU;
    else
      $dire = DIR_MENU_DATA;

    if($usuario=="") {
      $cab = '
          <a href="/whyb/web/form/" class="enlace">Registrarse</a>
          <a href="/whyb/web/log/" class="enlace" style="margin-left: 50px;">Iniciar sesión</a><br/>';
    }
    else
      $cab = "Conectado como:&nbsp;&nbsp;&nbsp;<a href='$dire' class='enlace'>$usuario</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<a href='/whyb/web/disconnect/' class='enlace'>cerrar sesión</a>";

    $cabecera = "  
          <div id='cabecera'>
            <div id='logo'>
              <a href='/whyb/web'><img src='/whyb/web/img/logo.png' /></a>
            </div>
            <div id='registro'>
            $cab
            </div>
          </div>";

    return $cabecera;
  }
}
?>