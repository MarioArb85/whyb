<?php 
class menu {

  static function construye($usuario) {

    $cabecera = '
    <div id="menu">
      <img src="'.DIR_IMG.'menu.png">
      <div id="menuLinks">
        <div id="linkPlaces">
          <a href="/whyb/web/places/" class="link ">Unesco places</a>
        </div>
        <div id="linkPlaces">
          <a href="/whyb/web/map/" class="link ">Unesco Map</a>
        </div>
        <div id="linkPlaces">
          <a href="#" class="link ">My places</a>
        </div>
        <div id="linkPlaces">
          <a href="#" class="link " style="border-right: 0px;">My routes</a>
        </div>
      </div>  
    </div>';

    return $cabecera;
  }
}
?>