<?php 

class admin_modify {						   

  static function construye($data) {
  	global $firephp;

    $body = "<div class='divRegForm'>
                <div id='divPrivateModify'>
                    <h1>Modificar datos lugar de la Unesco</h1>
                    <br/><br/>
                    <table>
                        <tr>
                            <th>Nombre:</th>
                            <td><input type='text' id ='txtUnescoName' name='txtUnescoName' autofocus/></td>
                        </tr>
                        <tr>
                            <th>Latitud:</th>
                            <td><input type='text' id ='txtUnescoLong' name='txtUnescoLong'/></td>
                        </tr>
                        <tr>
                            <th>Longitud:</th>
                            <td><input type='text' id ='txtUnescoLat' name='txtUnescoLat'/></td>
                        </tr>
                        <tr>
                            <th>Imagen:</th>
                            <td><input type='text' id ='txtUnescoImage' name='txtUnescoImage'/></td>
                        </tr>
                        <tr>
                            <th>Web:</th>
                            <td><input type='text' id ='txtUnescoWeb' name='txtUnescoWeb'/></td>
                        </tr>
                        <tr>
                            <th>Categoría:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>País:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Continente:</th>
                            <td></td> 
                        </tr>
                    </table>
                    <br/><br/><br/><br/>
                    <input type='submit'  value='Modificar' id='formularioUnescoBtn' class='formularioBtn enlace' style='font-size:150%;'/></td>
                    <a href='/whyb/web/admin/menu/' style='margin-left: 100px;' class='enlace'>Volver al menú principal</a></td>
                </div>    
            </div>";

    return $body;
  }
}
?>