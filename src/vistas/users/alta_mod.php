<?php 
	class alta_mod{

		static function construye($resultado) {
			global $firephp;
			
			if ($resultado == 1)
				$mensaje = '<p>Usuario creado correctamente</p>';
			else
				$mensaje = '<p>Error al crear el usuario. Por favor inténtelo mas tarde</p>';

			$cuerpo = "
			<div id='divForm' class='divRegForm'>
		        <img src='/whyb/web/img/imgForm.png' id='imgForm' class='imgFormReg'/>
		        <div id='resultNewUser' class='cuerpoForm'>
					<div id='textNewUser'>
					$mensaje
					</div>
					<div id='linkNewUser'>
					<a href='".DIR_INICIO."' class='bigLink'>Volver al inicio</a>
					</div>
				</div> 
			</div>";

    		return $cuerpo;
  		}
	}
?>