<?php 

class places {						   

  static function construye() {
    global $firephp;

    $body = "
            <div id='mapPage'>
                <div id='filters'>
                </div>
                <div id='map'></div>
            </div>
        ";

    return $body;
  }
}
?>