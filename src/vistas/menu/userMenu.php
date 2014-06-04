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
          $male = 'checked';

      	$body = "
        <div id='menuPage'>
            <div id='menuFilters'>
            	<a href='javascript: void(0)' id='menuDatos' class='linkMenu filterSelected'>Datos usuario</a>
              <a href='javascript: void(0)' id='menuBaja' class='linkMenu'>Darse de baja</a> 
            </div>
            <div id='menuResults'/>
              <h1>Modificar datos de usuario</h1>
              <br/><br/>
              <form id='userForm' action='/whyb/web/form/result/' method='post'>
                  <table>
                    <tr>
                        <th><span class='required'>*</span> Usuario:</th>
                        <td><input type='text' id ='txtUserName' name='txtUserName' value='".$userData->getNickname()."' style='background-color: LightGray;'readonly/></td>
                        <td><span id='userError' class='required'></span></td>
                    </tr>
                    <tr>
                        <th><span class='required'>*</span> Email:</th>
                      <td><input type='text' id ='txtMail' name='txtMail' value='".$userData->getEmail()."'/></td>
                      <td><span id='mailError' class='required'></span></td>
                    </tr>
                    <tr>
                        <th>&nbsp;&nbsp;&nbsp;Nombre:</th>
                        <td><input type='text' name='txtName' value='".$userData->getName()."'/></td>
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
                  <input type='submit'  value='Actualizar datos' id='formularioBtn' class='formularioBtn enlace' style='font-size:150%;'/></td>
                </form>      
            </div>    	
        </div>
        <div id='paginacion'></div>";
    	
        return $body;
      }
      
    }
?>