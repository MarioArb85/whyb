<?php 
class header {

  static function construye($usuario,$admin) {
    $cabecera = "  
	  <div id='cabecera'>
	    <div id='logo'>
        <a href='/whyb/web'><img src='/whyb/web/img/logo.png' /></a>
      </div>
      <div id='registro'>
	";
    
    if ($admin=="1")
   		$cabecera .= "Conectado como: <a href='#'><b>$usuario</b></a> (admin)";
    else{
    	if($usuario=="")
      		$cabecera .= "<a href='/whyb/web/form/' class='separa'>Registrarse</a>
                        <a href='#'>Iniciar sesion</a><br/>";
    	else
    		$cabecera .= "Conectado como: <a href='#'><b>$usuario</b></a>";
    }
    	
	$cabecera .= "
	     </div>
	  </div>
	";	
    return $cabecera;
  }
}
?>