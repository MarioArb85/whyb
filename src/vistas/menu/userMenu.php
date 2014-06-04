<?php 

    class userMenu {

      static function construye($userData) {
      	global $firephp;
        $male = '';
        $female = '';

        list($year, $month, $day) = split('[-]', $userData->getBirthdate());

        if ($day < 10)
          $day = substr($day, -1);

        if ($month < 10)
          $month = substr($month, -1);

        $dia = formularios::buildDay($day);
        $mes = formularios::buildMonth($month);
        $anio = formularios::buildYear($year);
        $select = formularios::buildCountries($userData->getCountryId());

        if($userData->getSex() == 'male')
          $male = 'checked';
        else if($userData->getSex() == 'female')
          $female = 'checked';

      	$body = "
        <div id='menuPage'>
          <div id='divCargandoUserMenu'>
            <div id='cargandoImguserMenu'>
              <img src='/whyb/web/img/load.gif' height='30px' width='30px'/>
            </div>
          </div>
          <div id='menuFilters'>
          	<a href='".DIR_MENU_DATA."' id='menuDatos' class='linkMenu filterSelected'>Datos usuario</a>
            <a href='".DIR_MENU_DELETE."' id='menuBaja' class='linkMenu'>Darse de baja</a>
            <span class='linkTitle linkPlaces' style='margin-top: 50px; width: 170px; padding-left: 10px;'>Ir a...</span>
            <a href='".DIR_UNESCO."' id='menuUnesco' class='linkMenu' style='margin-top: 0px;''>Sitios Unesco</a>
            <a href='".DIR_MAP."' id='menuUnesco' class='linkMenu'>Mapa Unesco</a>
            <a href='".DIR_PLACES."' id='menuUnesco' class='linkMenu'>Mis lugares</a>
            <a href='".DIR_SHOW_PLACES."' id='menuUnesco' class='linkMenu'>Ver mis lugares</a>
          </div>
          <div id='menuResults'/>
            <h1>Modificar datos de usuario</h1>
            <br/><br/>
             <table>
              <tr>
              <th><span class='required'>*</span> Usuario:</th>
                <td><input type='text' id ='txtUserMenuName' name='txtUserName' value='".$userData->getNickname()."' style='background-color: LightGray;' class='cursor' readonly/></td>
              </tr>
              <tr>
                <th><span class='required'>*</span> Email:</th>
                <td><input type='text' id ='txtMenuMail' value='".$userData->getEmail()."' style='background-color: LightGray;' class='cursor' readonly/></td>
              </tr>
              <tr>
                <th>&nbsp;&nbsp;&nbsp;Nombre:</th>
                <td><input type='text' id='txtMenuName' value='".$userData->getName()."'/></td>
              </tr>
              <tr>
                <th>&nbsp;&nbsp;&nbsp;Fecha de nacimiento:</th>
                <td>&nbsp;$dia&nbsp;/&nbsp;$mes&nbsp;/&nbsp;$anio</td>
              </tr>
              <tr>
                <th>&nbsp;&nbsp;&nbsp;Sexo:</th>
                <td>
                <input type='radio' name='sex' value='male' $male>Hombre
                <input type='radio' name='sex' value='female' $female>Mujer
                </td>
              </tr>
              <tr>
                <th><span class='required'>*</span> Pais:</th>
                <td>
                  $select
                </td> 
              </tr>
            </table>
            <br/><br/><br/><br/>
            <a id='UserMenuBtn' class='enlace' style='padding-left: 100px; cursor:pointer;'>Actualizar datos</a>      
          </div>    	
        </div>
        <div id='paginacion'></div>";
    	
        return $body;
      }
      
    }
?>