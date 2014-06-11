<?php
	class formularios {

		//Pinta select
		static function buildCountries($country,$page){
			$conexion = AccesoBBDD::abreConexionBD();

			if ($page == 'userInfo')
				$selectName = 'selCountriesUser';
			else if ($page == 'privateData')
				$selectName = 'selPrivateData';
			else
				$selectName = 'selCountries';

			$consulta = "SELECT countryId, countryname_es FROM countries ORDER BY countryname_es";

	   		if($resultado = $conexion->query($consulta)) {
		        $countries = "<select id='$selectName' name='selCountries' style='width:120px;'>";
		        while ($fila = $resultado->fetch_object()) {
		        	if ($fila->countryId == $country)
		        		$countries .= "<option value='".$fila->countryId."' selected>".$fila->countryname_es."</option>";
		        	else
		        		$countries .= "<option value='".$fila->countryId."'>".$fila->countryname_es."</option>";
		        }       
		        //se libera el cursor
		        $resultado->free();
		        $countries .= "</select>";
		    }

			return $countries;
		}

		//Pinta categorias
		static function buildCategories($nombre){
			$conexion = AccesoBBDD::abreConexionBD();

		    $consulta = "SELECT categoryId, categoryName_es FROM category";
		    
		    if ($resultado = $conexion->query($consulta)) {
		        $checkCat = "";
		        while ($fila = $resultado->fetch_object()) {
		            if($fila->categoryId != 0)
		                $checkCat .= "<input type='checkbox' id='$nombre".$fila->categoryId."' value='".$fila->categoryId."'/>".$fila->categoryName_es."<br/>";
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
		static function buildYear($anio){
			$year = '<select id="selYear" name="selYear">';
			for ($i = 2010; $i>=1900; $i--){
				if($i == $anio)
					$year .= "<option value='$i' selected>$i</option>";	
				else		
					$year .= "<option value='$i'>$i</option>";
			}
			$year .= '</select>';

			return $year;
		}

		//Pinta mes
		static function buildMonth($mes){
			$month = '<select id="selMonth" name="selMonth">';
			for ($i = 1; $i<=12; $i++){
				if($i == $mes)
					$month .= "<option value='$i' selected>$i</option>";
				else
					$month .= "<option value='$i'>$i</option>";
			}
			$month .= '</select>';
			return $month;
		}

		//Pinta dia
		static function buildDay($dia){
			$day = '<select id="selDay" name="selDay">';
			for ($i = 1; $i<=31; $i++){
				if($i == $dia)
					$day .= "<option value='$i' selected>$i</option>";
				else
					$day .= "<option value='$i'>$i</option>";
			}
			$day .= '</select>';
			return $day;
		}

		//Pinta select mio unesco/propio
		static function buildMyCountries($unesco, $visited){
			global $firephp;
			$conexion = AccesoBBDD::abreConexionBD();

			if ($unesco == 1){
				if($visited == 0)
					$idSelect = 'selQuieroVisitarUnesco';
				else
					$idSelect = 'selHeVisitadoUnesco';
			}
			else
				$idSelect = 'selMyPlaces';

			$consulta = "SELECT DISTINCT  p.countryId, c.countryName_es FROM places p ,placesvisited v, countries c WHERE v.userId= ".$_SESSION['userId']." and v.isUnesco = $unesco and v.visited = $visited and p.placeId = v.placeId and c.countryId = p.countryId ORDER BY c.countryname_es;";

	   		if($resultado = $conexion->query($consulta)) {
		        $countries = "<select id='".$idSelect."' name='".$idSelect."' style='width:120px;'>";
		        $countries .= "<option value=''>Todos</option>";
		        while ($fila = $resultado->fetch_object()) {
		        	$countries .= "<option value='".$fila->countryId."'>".$fila->countryName_es."</option>";
		        }       
		        // se libera el cursor
		        $resultado->free();
		        $countries .= "</select>";
		    }

			return $countries;
		}

		//Pinta select ciudades
		static function buildCities($country,$userId){
			global $firephp;
			$conexion = AccesoBBDD::abreConexionBD();

			$consulta = "select city
						from places
						where placeId in (select placeId		
											from  placesvisited
											where userId = $userId
											and isUnesco = 0
											and visited = 1)
						and countryId = '$country';";

	   		if($resultado = $conexion->query($consulta)) {
	   			$cities = "<select id='selMyPlacesCities' name='selMyPlacesCities' style='width:120px;'>";
                while ($fila = $resultado->fetch_object()) {
                	$cities .= "<option value='".$fila->city."'>".$fila->city."</option>";
		        }    
		        $cities .= "</select> ";
		        // se libera el cursor
		        $resultado->free();
		    }
			return $cities;
		}

		//Select cateagories
		static function selectCategories($category){
			$conexion = AccesoBBDD::abreConexionBD();

			$consulta = "SELECT categoryId, categoryName_es FROM category ORDER BY categoryName_es";

	   		if($resultado = $conexion->query($consulta)) {
		        $countries = "<select id='privateCategories' name='privateCategories'>";
		        while ($fila = $resultado->fetch_object()) {
		        	if ($fila->categoryId == $category)
		        		$countries .= "<option value='".$fila->categoryId."' selected>".$fila->categoryName_es."</option>";
		        	else
		        		$countries .= "<option value='".$fila->categoryId."'>".$fila->categoryName_es."</option>";
		        }   
		        $countries .= "</select>";    
		        //se libera el cursor
		        $resultado->free(); 
		    }

			return $countries;
		}

		//Select cateagories
		static function selectContinents($continent){
			$conexion = AccesoBBDD::abreConexionBD();

			$consulta = "SELECT continentId, continentName_es FROM continents ORDER BY continentName_es";

	   		if($resultado = $conexion->query($consulta)) {
		        $countries = "<select id='privateContinents' name='privateContinents'>";
		        while ($fila = $resultado->fetch_object()) {
		        	if ($fila->continentId == $continent)
		        		$countries .= "<option value='".$fila->continentId."' selected>".$fila->continentName_es."</option>";
		        	else
		        		$countries .= "<option value='".$fila->continentId."'>".$fila->continentName_es."</option>";
		        }   
		        $countries .= "</select>";    
		        //se libera el cursor
		        $resultado->free(); 
		    }

			return $countries;
		}
	}
?>