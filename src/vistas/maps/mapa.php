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
			<script type='text/javascript'>
			$(document).ready(function(){
				map.addMarker({
			        lat: -12.042,
			        lng: -77.028333,
			        title: 'Marker with InfoWindow',
			        infoWindow: {
			          content: '<p>HTML Content</p>'
			        }
			    });
			});
  			</script>
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