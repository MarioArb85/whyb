<?php
	class formularios {

		//Pinta select
		static function buildCountries($country){
			$conexion = AccesoBBDD::abreConexionBD();

			$consulta = "SELECT countryId, countryname_es FROM countries ORDER BY countryname_es";

	   		if($resultado = $conexion->query($consulta)) {
		        $countries = "<select id='selCountries' name='selCountries' style='width:120px;'>";
		        while ($fila = $resultado->fetch_object()) {
		        	$countries .= "<option value='".$fila->countryId."'>".$fila->countryname_es."</option>";
		        }       
		        // se libera el cursor
		        $resultado->free();
		        $countries .= "</select>";
		    }

			return $countries;
		}

		//Pinta categorias
		static function buildCategories(){
			$conexion = AccesoBBDD::abreConexionBD();

		    $consulta = "SELECT categoryId, categoryName_es FROM category";
		    
		    if ($resultado = $conexion->query($consulta)) {
		        $checkCat = "";
		        while ($fila = $resultado->fetch_object()) {
		            if($fila->categoryId != 0)
		                $checkCat .= "<input type='checkbox' id='checkCat".$fila->categoryId."' value='".$fila->categoryId."'/>".$fila->categoryName_es."<br/>";
		        }       
		        // se libera el cursor
		        $resultado->free();
		    }

			return $checkCat;
		}

		//Pinta continentes
		static function buildContinents(){
			$conexion = AccesoBBDD::abreConexionBD();

		   	$consulta = "SELECT continentId, continentName_es FROM continents";

		    if ($resultado = $conexion->query($consulta)) {
		        $checkCont = "";
		        while ($fila = $resultado->fetch_object()) {
		            $checkCont .= "<input type='checkbox' id='checkCont".$fila->continentId."' value='".$fila->continentId."'/>".$fila->continentName_es."<br/>";
		        }       
		        // se libera el cursor
		        $resultado->free();
		    }

			return $checkCont;
		}

		//Pinta año
		static function buildYear(){
			$year = '<select id="selYear" name="selYear">';
			for ($i = 2010; $i>=1900; $i--){
				$year .= "<option value='$i'>$i</option>";
			}
			$year .= '</select>';
			return $year;
		}

		//Pinta mes
		static function buildMonth(){
			$month = '<select id="selMonth" name="selMonth">';
			for ($i = 1; $i<=12; $i++){
				$month .= "<option value='$i'>$i</option>";
			}
			$month .= '</select>';
			return $month;
		}

		//Pinta dia
		static function buildDay(){
			$day = '<select id="selDay" name="selDay">';
			for ($i = 1; $i<=31; $i++){
				$day .= "<option value='$i'>$i</option>";
			}
			$day .= '</select>';
			return $day;
		}

		//Pinta select mio unesco/propio
		static function buildMyCountries($unesco){
			global $firephp;
			$conexion = AccesoBBDD::abreConexionBD();

			$consulta = "SELECT DISTINCT  p.countryId, c.countryName_es FROM places p ,placesvisited v, countries c WHERE v.userId= ".$_SESSION['userId']." and v.isUnesco = $unesco and p.placeId = v.placeId and c.countryId = p.countryId ORDER BY c.countryname_es;";
			$firephp->log($consulta, 'Mensaje');
	   		if($resultado = $conexion->query($consulta)) {
		        $countries = "<select id='selCountries' name='selCountries' style='width:120px;'>";
		        $countries .= "<option value='0'>Elige un país</option>";
		        while ($fila = $resultado->fetch_object()) {
		        	$countries .= "<option value='".$fila->countryId."'>".$fila->countryName_es."</option>";
		        }       
		        // se libera el cursor
		        $resultado->free();
		        $countries .= "</select>";
		    }

			return $countries;
		}
	}
?>