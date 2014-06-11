<?php 

class admin_modify {						   

  static function construye($data) {
  	global $firephp;

    $paises = formularios::buildCountries($data[country],'privateData');
    $categories = formularios::selectCategories($data[category]);
    $continents = formularios::selectContinents($data[continent]);

    $body = "
            <div id='loadingPrivateResults' class='cargandoBueno'>
                Cargando...
                <br/><br/><br/>
                <img src='/whyb/web/img/load.gif' height='30px' width='30px'/>
            </div>
            <div class='divRegForm'>
                <div id='divPrivateModify'>
                    <h1>Modificar datos lugar de la Unesco</h1>
                    <br/><br/>
                    <table>
                        <tr>
                            <th>Nombre:</th>
                            <td><input type='text' id ='txtUnescoName' name='txtUnescoName' value='".$data[name]."' size='64' autofocus/></td>
                        </tr>
                        <tr>
                            <th>Latitud:</th>
                            <td><input type='text' id ='txtUnescoLat' name='txtUnescoLat' value='".$data[lat]."' size='10'></td>
                        </tr>
                        <tr>
                            <th>Longitud:</th>
                            <td><input type='text' id ='txtUnescoLong' name='txtUnescoLong' value='".$data[lng]."' size='10'/></td>
                        </tr>
                        <tr>
                            <th>Imagen:</th>
                            <td><input type='text' id ='txtUnescoImage' name='txtUnescoImage' value='".$data[img]."' size='48'/></td>
                        </tr>
                        <tr>
                            <th>Web:</th>
                            <td><input type='text' id ='txtUnescoWeb' name='txtUnescoWeb' value='".$data[web]."' size='32'/></td>
                        </tr>
                        <tr>
                            <th>Categoría:</th>
                            <td>$categories</td>
                        </tr>
                        <tr>
                            <th>País:</th>
                            <td>$paises</td>
                        </tr>
                        <tr>
                            <th>Continente:</th>
                            <td>$continents</td> 
                        </tr>
                        <tr>
                            <th><input type='hidden' id='txtUnescoId' value='".$data[id]."'></th>
                        </tr>
                    </table>
                    <br/><br/><br/>
                    <input type='submit'  value='Modificar' id='formularioUnescoBtn' class='formularioBtn enlace' style='font-size:150%;'/></td>
                    <a href='".DIR_ADMIN_MENU_LIST."' style='margin-left: 100px;' class='enlace'>Volver al listado</a></td>
                </div>    
            </div>";

    return $body;
  }
}
?>