<?php 

class admin_login {						   

  static function construye() {
  	global $firephp;

    if ($_SESSION['error'] == 'Error al logearse')
                $error = '';
            else
                $error = 'style="display:none;"';

            $_SESSION['error'] = '';

    $body = "
            <div class='divRegForm'>
                <div id='divIniPrivateSesion'>
                    <h1>Iniciar Sesión</h1>
                    <br/><br/>
                    <span id='iniPrivateSesionError' class='required' $error>Nombre de usuario o contraseña incorrectos.</span>
                    <br/><br/>
                    <form id='iniPrivateSesionForm' action='/whyb/web/admin/log/' method='post'>
                    <table>
                        <tr>
                            <th>Usuario:</th>
                            <td><input type='text' id ='txtPrivateUserNameReg' name='txtPrivateUserNameReg' autofocus/></td>
                        </tr>
                        <tr>
                            <th>Contraseña:</th>
                            <td><input type='password' id ='txtPrivatePassReg' name='txtPrivatePassReg'/></td>
                        </tr>
                    </table>
                    <br/><br/>
                    <input type='submit' id='iniPrivateSesionFormBtn' value='Iniciar' class='formularioBtn enlace' style='font-size:150%;'/></td>
                    <a href='/whyb/web' style='margin-left: 50px;' class='enlace'>Volver a la web</a></td>
                    </form>
                </div>
            </div>";

    return $body;
  }
}
?>