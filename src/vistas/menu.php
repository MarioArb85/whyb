<?php 
class menu {

  static function construye($usuario, $unesco, $map, $places, $route) {

    $cabecera = "
    <div id='menu'>
      <img src='".DIR_IMG."menu.png'>
      <div id='menuLinks'>
        <div id='linkUnesco'>
          <a href='".DIR_UNESCO."' id='linkUnescoa' class='link $unesco'>Sitios Unesco</a>
        </div>
        <div id='linkMaps'>
          <a href='".DIR_MAP."' class='link $map'>Mapa Unesco</a>
        </div>
        <div id='linkPlaces'>
          <a href='".DIR_PLACES."' class='link $places'>Mis lugares</a>
        </div>
        <div id='linkRoutes'>
          <a href='javascript: void(0)' class='link'  id='linkRoutesa $route'>Mis rutas</a>
        </div>
      </div>  
    </div>";

    return $cabecera;
  }
}
?>