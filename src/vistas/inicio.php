<?php 
class inicio {

  static function construye() {
    global $firephp;
    //$firephp->log($ip, 'ip');
    $rutaImg = DIR_IMG."portada.png";

    $cuerpo = "
    <img id='imgPortada' src='".$rutaImg."'>
    <div id='cuerpo'>
    <div id='textInicio'>
      <p>Percipit salutatus tincidunt per et, mea viderer phaedrum referrentur eu. Quas bonorum apeirian pro eu. Percipit nominati vel ne, eu corpora iudicabit eloquentiam per. Sed clita posidonium interpretaris et. Et porro latine fabellas his, ea modus libris eirmod sit. In cum enim fugit, ex per labore dicunt delicata. Eu vidit latine bonorum vim, ad adhuc errem pri, quas elitr interesset eos at.</p>
      <br/><br/>
      <a href='".DIR_UNESCO."' class='bigLink'>Sitios</a>
      <a href='".DIR_MAP."' class='bigLink' style='margin-left: 150px;'>Mapa</a>
    </div>
    </div>";
	  
    return $cuerpo;
  }
}
?>