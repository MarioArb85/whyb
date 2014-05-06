<?php 
class users_controller {

  static function form() {
	  $cuerpo = "
      <div id='divForm'>
        <img src='/whyb/web/img/imgForm.png' id='imgForm'/>
        <div id='cuerpoForm'>
          <table>
            <tr>
              <th>Firstname</th>
              <td>Lastname</td>
            </tr>
          </table>
        </div>  
      </div>";
    return $cuerpo;
  }
}
?>