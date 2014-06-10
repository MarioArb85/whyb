<?php 

    class userBaja {

      static function construye() {
        global $firephp;

        $body = "
        <div id='divCargandoUserMenu' class='cargandoBueno'>
          Cargando...
          <br/><br/><br/>
          <img src='/whyb/web/img/load.gif' height='30px' width='30px'/>
        </div>
        <div id='menuPage'>
          <div id='menuFilters'>
            <a href='".DIR_MENU_DATA."' id='menuDatos' class='linkMenu'>Datos usuario</a>
            <a href='".DIR_MENU_DELETE."' id='menuBaja' class='linkMenu filterSelected'>Darse de baja</a>
            <span class='linkTitle linkPlaces' style='margin-top: 50px; width: 170px; padding-left: 10px;'>Ir a...</span>
            <a href='".DIR_UNESCO."' id='menuUnesco' class='linkMenu' style='margin-top: 0px;''>Sitios Unesco</a>
            <a href='".DIR_MAP."' id='menuUnesco' class='linkMenu'>Mapa Unesco</a>
            <a href='".DIR_PLACES."' id='menuUnesco' class='linkMenu'>Guardar mis lugares</a>
            <a href='".DIR_SHOW_PLACES."' id='menuUnesco' class='linkMenu'>Ver mis lugares</a>
          </div>
          <div id='menuResults'/>
            <h1 style='margin-bottom: 50px;'>Dar de baja el usuario</h1>
            <a href='javascript: void(0)' id='UserDeleteMenuBtn' class='enlace' style='margin-left: 65px; cursor:pointer;'>Darse de baja</a>
          </div>      
        </div>";
      
        return $body;
      }
      
    }
?>