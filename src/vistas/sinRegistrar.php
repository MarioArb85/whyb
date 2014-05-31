<?php 
class sinRegistrar {

  static function construye() {
    $body = '
          <div id="sinRegistrarPage">
            <div id="mensajeSinRegistrar">
              <img src="'.DIR_IMG.'registro.png" id="imgSinRegistrar" height="50px" width="50px"/>
              <p style="margin-left: 100px;">¡Para acceder es necesario iniciar sesión!</p>
              <br/>
              <a href="/whyb/web/log/" class="enlace" style="margin-left: 140px;">Iniciar sesión</a><br/>
              <br/><br/>
              <p style="margin-left: 125px;">¿Aún no te has registrado? ¡Únete!</p>
              <br/>
              <a href="/whyb/web/form/" class="enlace" style="margin-left: 200px;">Regístrate!</a>
            </div>
          </div>';

    return $body;
  }
}
?>