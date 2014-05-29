<?php
header('Content-Type: text/html; charset=utf-8');
	class formulario{

		static function construye() {
			$dia = formularios::buildDay();
			$mes = formularios::buildMonth();
			$anio = formularios::buildYear();
			$select = formularios::buildCountries(null);

		    $cuerpo = "
		    <div id='divForm' class='divRegForm'>
		        <img src='/whyb/web/img/imgForm.png' id='imgForm' class='imgFormReg'/>
		        <div id='cuerpoForm'>
		        	<h1>Formulario de registro</h1>
		          	<br/><br/>
		          	<span class='required' hidden='true'>Los campos marcados con * son obligatorios</span>
		          	<br/><br/>
		          	<form id='formulario' action='/whyb/web/form/result/' method='post'>
		          	<table>
			            <tr>
			              	<th><span class='required'>*</span> Usuario:</th>
			              	<td><input type='text' id ='txtUserName' name='txtUserName' autofocus/></td>
			              	<td><span id='userError' class='required'></span></td>
			            </tr>
			            <tr>
			              	<th><span class='required'>*</span> Contraseña:</th>
			              	<td><input type='password' id ='txtPass' name='txtPass'/></td>
			              	<td><span id='passError' class='required'></span></td>
			            </tr>
			            <tr>
			              	<th><span class='required'>*</span> Repetir contrasena:</th>
			              	<td><input type='password' id ='txtPassRep' name='txtPassRep'/></td>
			            	<td><span id='passRepError' class='required'></span></td>
			            </tr>
			            <tr>
			              	<th><span class='required'>*</span> Email:</th>
			             	<td><input type='text' id ='txtMail' name='txtMail'/></td>
			             	<td><span id='mailError' class='required'></span></td>
			            </tr>
			            <tr>
			              	<th>&nbsp;&nbsp;&nbsp;Nombre:</th>
			              	<td><input type='text' name='txtName'/></td>
			            </tr>
			            <tr>
			              	<th>&nbsp;&nbsp;&nbsp;Fecha de nacimiento:</th>
			              	<td>&nbsp;$dia&nbsp;/&nbsp;$mes&nbsp;/&nbsp;$anio</td>
			            </tr>
			            <tr>
			              	<th>&nbsp;&nbsp;&nbsp;Sexo:</th>
			              	<td>
			              		<input type='radio' name='sex' value='male'>Hombre
			                	<input type='radio' name='sex' value='female'>Mujer
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
		          	<input type='submit'  value='Aceptar' id='formularioBtn' class='formularioBtn enlace' style='font-size:150%;'/></td>
		          	<a href='/whyb/web' style='margin-left: 100px;' class='enlace'>Volver al inicio</a></td>
		        	</form>
		    	</div>  
			</div>";

    	return $cuerpo;
  		}
	}
?>