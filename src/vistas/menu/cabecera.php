<?php 
class cabecera {

  static function construye($usuario) {

    $cabecera = '
    <div id="userMenu">
      <img src="'.DIR_IMG.'cabecera.png">
      </div>  
    </div>';

    return $cabecera;
  }
}
?>