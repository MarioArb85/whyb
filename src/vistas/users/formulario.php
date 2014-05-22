<?php 
	class formulario{

		static function construye() {
			$dia = funciones::buildDay();
			$mes = funciones::buildMonth();
			$anio = funciones::buildYear();
			$select = funciones::buildCountries(null);

		    $cuerpo = "
		      <div id='divForm'>
		        <img src='/whyb/web/img/imgForm.png' id='imgForm'/>
		        <div id='cuerpoForm'>
		          <h1>Formulario de registro</h1>
		          <br/>
		          <span id='required' hidden='true'>Los campos marcados con * son obligatorios</span>
		          <br/><br/>
		          <form action='#' method='post'>
		          <table>
		            <tr>
		              <th><span class='required'>*</span> Usuario:</th>
		              <td><input type='text' name='txtUserName' autofocus/></td>
		            </tr>
		            <tr>
		              <th><span class='required'>*</span> Contraseña:</th>
		              <td><input type='password' name='txtPass'/></td>
		            </tr>
		            <tr>
		              <th><span class='required'>*</span> Repetir contrasena:</th>
		              <td><input type='password' name='txtPassRep'/></td>
		            </tr>
		            <tr>
		              <th><span class='required'>*</span> Email:</th>
		              <td><input type='text' name='txtMail'/></td>
		            </tr>
		            <tr>
		              <th>&nbsp;&nbsp;&nbsp;Nombre:</th>
		              <td><input type='text' name='txtName'/></td>
		            </tr>
		            <tr>
		              <th>&nbsp;&nbsp;&nbsp;Apellido:</th>
		              <td><input type='text' name='txtSurname'/></td>
		            </tr>
		            <tr>
		              <th>&nbsp;&nbsp;&nbsp;Fecha de nacimiento:</th>
		              <td>&nbsp;$dia&nbsp;/&nbsp;$mes&nbsp;/&nbsp;$anio</td>
		            </tr>
		            <tr>
		              <th>&nbsp;&nbsp;&nbsp;Sexo:</th>
		              <td><input type='radio' name='sex' value='male'/>Hombre
		                  &nbsp;&nbsp;&nbsp;<input type='radio' name='sex' value='female'/>Mujer
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
		          <input type='submit' value='Aceptar' id='formularioBtn'/></td>
		          <a href='/whyb/web' style='margin-left: 100px;'>Volver al inicio</a></td>
		          </form>
		        </div>  
		      </div>";

    	return $cuerpo;
  		}
	}
?>