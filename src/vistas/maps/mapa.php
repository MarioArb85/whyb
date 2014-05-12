<?php 

class mapa {						   

  static function construye() {
  	$mapa = "
		<div id='mapPage'>
			<div id='menu'>
				menu
			</div>
			<div id='filters'>
				filtros
			</div>
			<div id='map'></div>
			<div id='markers'>
				nuevos marcadores
			</div>
		</div>
  	";
	
    return $mapa;
  }
}
?>