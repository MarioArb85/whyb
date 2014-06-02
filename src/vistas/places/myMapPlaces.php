<?php 

class myMapPlaces {						   

  static function construye() {
    global $firephp;

    //pinta categorias quiero visitar
    $checkCat = formularios::buildCategories('quieroVisitar');
    //pinta categorias quiero visitar
    $checkCatUnesco = formularios::buildCategories('myUnescoCategory');
    //pinta formulario sitios unesco quiero visitar
    $quieroVisitarUnesco = formularios::buildMyCountries(1, 0);
    //pinta formulario sitios unesco he visitado
    $heVisitadoUnesco = formularios::buildMyCountries(1, 1);
    //pinta formulario mis sitios
    $formularioMisSitios = formularios::buildMyCountries(0, 1);

    $body = "
            <div id='divCargandoMap' class='cargandoMap' style='display: none;'>
                <div class='cargandoImg'>
                    <img src='/whyb/web/img/load.gif' height='30px' width='30px'/>
                </div>
            </div>
            <div id='myMapPage'>  
                <div id='filters'>
                    <span class='linkTitle linkPlaces'>&nbsp;&nbsp;Quiero visitar...</span>
                    <span class='linkFilter linkPlaces'>&nbsp;&nbsp;Categoría:</span>
                    <br/><br/><br/><br/>
                    <div id='quieroVisitarCategory' class='sangria'>          
                        $checkCat
                    </div>  
                    <br/>
                    <span class='linkFilter linkPlaces'>&nbsp;&nbsp;País:</span>
                    <br/><br/>
                    <div id='quieroVisitarCountry' class='sangria'>          
                        $quieroVisitarUnesco
                    </div>
                    <br/>
                    <div id='updateList'>          
                        <a href='javascript: void(0)' id='btnQuieroVisitar' name='btnQuieroVisitar' class='formularioBtn enlace'>Actualizar</a>
                    </div>
                </div>
                <div id='mapMyPlaces'>
                </div>
                <div id='filters' style='width: 140px'>
                    <span class='linkTitle linkPlaces'>&nbsp;&nbsp;Unesco visitados...</span>
                    <span class='linkFilter linkPlaces'>&nbsp;&nbsp;Categoría:</span>
                    <br/><br/><br/><br/>
                    <div id='myUnescoCategory' class='sangria'>          
                        $checkCatUnesco
                    </div>  
                    <br/>
                    <span class='linkFilter linkPlaces'>&nbsp;&nbsp;País:</span>
                    <br/><br/>
                    <div id='myUnescoCategory' class='sangria'>          
                        $heVisitadoUnesco
                    </div>
                    <br/>
                    <div id='updateList'>          
                        <a href='javascript: void(0)' id='btnVisitadoUnesco' name='btnVisitadoUnesco' class='formularioBtn enlace'>Actualizar</a>
                    </div>
                    <span class='linkTitle linkPlaces' style='margin-top: 30px;'>&nbsp;&nbsp;Mis lugares visitados</span>
                    <span class='linkFilter linkPlaces'>&nbsp;&nbsp;País:</span>
                    <br/><br/><br/><br/><br/><br/>
                    <div id='myPlacesSelect' class='sangria'>          
                        $formularioMisSitios
                    </div>  
                    <br/>
                    <a<span class='linkFilter linkPlaces'>&nbsp;&nbsp;Ciudad:</span>
                    <br/><br/>
                    <div id='myCitiesSelect' class='sangria' style='margin-top:0px;'>
                        <select id='selMyPlacesCountries' name='selMyPlacesCountries' style='width:120px;'>
                            <option value='ciudad'>Ciudad</option>
                        </select>         
                    </div>
                    <br/>
                    <div id='updateList'>          
                        <a href='javascript: void(0)' id='btnVisitadoMios' name='btnVisitadoMios' class='formularioBtn enlace'>Actualizar</a>
                    </div>
                </div>
            </div>
            ";

    return $body;
  }
}
?>