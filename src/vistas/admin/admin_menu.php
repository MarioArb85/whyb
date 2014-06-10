<?php 

class admin_menu {						   

  static function construye() {
  	global $firephp;

    if ($_SESSION['error'] == 'Error al logearse')
                $error = '';
            else
                $error = 'style="display:none;"';

            $_SESSION['error'] = '';

    $body = "
            <div class='divRegForm'>
                <div id='divPrivateMenu'>
                    <h1>Menu privado para la gestión de la web</h1>
                    <ul id='privateMenu' style='padding-left: 30px;'>
                        <li><a href='".DIR_ADMIN_MENU_LIST."'>Listado de lugares Unesco</a></li>
                        <li><a href='#'>Agregar lugares Unesco (xml)</a></li>
                    </ul>
                </div>    
            </div>";

    return $body;
  }
}
?>