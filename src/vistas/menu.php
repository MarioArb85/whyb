<?php 
class menu {

  static function construye($usuario, $unesco, $map, $places, $route) {

    $cabecera = "
    <div id='menu'>
      <img src='".DIR_IMG."menu.png'>
      <div id='menuLinks'>
        <div id='linkUnesco'>
          <a href='".DIR_UNESCO."' id='linkUnescoa' class='link $unesco'>Unesco places</a>
        </div>
        <div id='linkMaps'>
          <a href='".DIR_MAP."' class='link $map'>Unesco Map</a>
        </div>
        <div id='linkPlaces'>
          <a href='#' class='link $places'>My places</a>
        </div>
        <div id='linkRoutes'>
          <a href='#' class='link'  id='linkRoutesa $route'>My routes</a>
        </div>
      </div>  
    </div>";

    return $cabecera;
  }
}
?>