<?php 

    class userMenu {

      static function construye() {
      	global $firephp;

      	$body = '
        <div id="menuPage">
            <div id="menuFilters">
            	<a href="javascript: void(0)" id="menuUnesco" class="linkMenu filterSelected">Quiero visitar...</a></br>
            	<a href="javascript: void(0)" id="menuLugares" class="linkMenu">Lugares visitados</a></br>
            	<a href="javascript: void(0)" id="menuDatos" class="linkMenu">Info usuario</a> 
            </div>
            <div id="menuResults"/>       
            </div>    	
        </div>
        <div id="paginacion"></div>';
    	
        return $body;
      }
      
    }
?>