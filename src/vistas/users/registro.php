<?php 
	class registro{

		static function construye() {
			$cuerpo = "
		    <div class='divRegForm'>
		        <img src='/whyb/web/img/img_registro.png' id='imgReg' class='imgFormReg'/>
		        <div id='divIniSesion'>
					<h1>Iniciar Sesión</h1>
					<br/><br/>
					<span id='iniSesionError' class='required' hidden='true'>Nombre de usuario o contraseña incorrectos.</span>
					<br/><br/>
					<form id='iniSesionForm' action='/whyb/web/log/result/' method='post'>
					<table>
			            <tr>
			              	<th>Usuario:</th>
			              	<td><input type='text' id ='txtUserNameReg' name='txtUserNameReg' autofocus/></td>
			            </tr>
			            <tr>
			              	<th>Contraseña:</th>
			              	<td><input type='password' id ='txtPassReg' name='txtPassReg'/></td>
			            </tr>
		        	</table>
		        	<br/><br/>
		          	<input type='submit' id='iniSesionFormBtn' value='Iniciar sesión' class='formularioBtn enlace' style='font-size:150%;'/></td>
		          	<a href='/whyb/web' style='margin-left: 50px;' class='enlace'>Volver al inicio</a></td>
		        	</form>
		        </div>
			</div>";

    		return $cuerpo;
  		}
	}
?>