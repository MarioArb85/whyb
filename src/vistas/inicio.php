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
      <p>'Where have you been' es un diario de viajes que, una vez vez registrado, te permite guardar los luagres que has visitado en todo el mundo
       y adjuntar un breve comentario sobre cada uno de ellos. También puedes buscar los sitios catalogados por la UNESCO como
       Patrimonio de la Humanidad y guardarlos en tu lista de 'Lugares que quiero visitar'.</p>
      <br/>
      <table id='tablaInicio' style='margin-left: 170px;'>
        <tr class='marginTop'>
          <th>
            <a href='".DIR_UNESCO."' class='bigLink enlace'>Sitios Unesco</a>
          </th>
          <td>
            <p>Ir al listado de sitios de la Unesco</p>
          </td>
        <tr>
        <tr>
          <th>
            <a href='".DIR_MAP."' class='bigLink enlace marginTop'>Mapa Unesco</a>
          </th>
          <td>
            <p>Mapa con los luagares Patrimonio de la Humanidad</p>
          </td>
        <tr>
        <tr>
          <th>
            <a href='".DIR_PLACES."' class='bigLink enlace'>Mis lugares</a>
          </th>
          <td>
            <p>Guarda tus sitios favoritos</p>
          </td>
        <tr>
        <tr>
          <th>
            <a href='".DIR_SHOW_PLACES."' class='bigLink enlace'>Ver mis lugares</a>
          </th>
          <td>
            <p>Gestiona tus lugares visitados y los que quieres visitar</p>
          </td>
        <tr>
      <table>
    </div>
    </div>";
	  
    return $cuerpo;
  }
}
?>