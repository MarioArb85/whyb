<?php 

class places {						   

  static function construye() {
    global $firephp;

    $body = '
            <div id="divCargandoMap" class="cargandoMap" style="display: none;">
                <div class="cargandoImg">
                    <img src="/whyb/web/img/load.gif" height="30px" width="30px"/>
                </div>
            </div>
            <div id="mapPage">  
                <div id="filters">
                    <span class="linkFilter linkPlaces">&nbsp;&nbsp;&nbsp;País:</span>
                    <br/><br/>
                    <input type="text" id="placesCountry" value="------" readonly/>
                    <br/><br/>
                    <span class="linkFilter linkPlaces">&nbsp;&nbsp;&nbsp;Ciudad:</span>
                    <br/><br/>
                    <input type="text" id="placesCity" value="------" readonly/>
                    <br/><br/>
                    <span class="linkFilter linkPlaces">&nbsp;&nbsp;&nbsp;Situación:</span>
                    <br/><br/>
                    <input type="text" id="placesSituation" value="------" readonly/>
                    <br/><br/>
                    <span class="linkFilter linkPlaces">&nbsp;&nbsp;&nbsp;Lugar:</span>
                    <br/><br/>
                    <input type="text" id="placesLugar"/>
                    <br/><br/>
                    <span class="linkFilter linkPlaces">&nbsp;&nbsp;&nbsp;Comentarios:</span>
                    <br/><br/>
                    <textarea id="placesComentarios" rows="9" cols="16" maxlength="256" style="resize:none;">Arrastra la marca del mapa para obtener la localización!</textarea>
                    <br/><br/><br/>
                    <input type="hidden" id="placesCountryId"/>
                    <input type="hidden" id="placesLat"/>
                    <input type="hidden" id="placeslong"/>
                    <div id="updateList">          
                        <a href="javascript: void(0)" id="updateLugares" class="formularioBtn enlace">Guardar lugar!</a>
                    </div>
                </div>
                <div id="mapPlaces">
                </div>
            </div>
            ';

    return $body;
  }
}
?>