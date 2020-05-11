<?php class Util{
	function numeroSemana($fecha){
		$fecha_caso = $this->fechaStamp($fecha);
		$primer_dia = $this->fechaStamp($this->getPrimerDiaMes(date('Y', $this->fechaStamp($fecha)), date('m', $this->fechaStamp($fecha))));
		$diferencia = (date('W', $fecha_caso)) - (date('W', $primer_dia)) + 1;
		if($diferencia < 0)//PARA LOS DIAS QUE SOBRAN DESPUES DE LA SEMANA 52
			$diferencia = (53) - (date('W', $primer_dia)) + 1;
		return $diferencia;
	}
	function getFecha(){ //OBTENER HORA ACTUAL
		//date_default_timezone_set("America/Santiago");
		//setlocale(LC_TIME, "spanish");
		$fecha = date('d-m-Y');
		return $fecha;
	}
	function getHora(){ //OBTENER HORA ACTUAL
		//date_default_timezone_set("America/Santiago");
		//setlocale(LC_TIME, "spanish");
		$Time = strftime("%H:%M");
		return $Time;
	}
	function getHoraBD(){ //OBTENER LA HORA CORRECTA DE LA ZONA
		//date_default_timezone_set("America/Santiago");
		//setlocale(LC_TIME, "spanish");
		$Time = strftime("%H:%M:%S");
		return $Time;
	}
	function getTimeStamp(){ //OBTENER LA TIMESTAMP CORRECTA DE LA ZONA
		//date_default_timezone_set("America/Santiago");
		//setlocale(LC_TIME, "spanish");
		$Time = strftime("%H:%M:%S");
		$fecha = date('Y-m-d');
		$resultado = $fecha." ".$Time;
		return $resultado;
	}
	function fechaStamp($fecha){
		return strtotime($fecha);
	}
	function fechasAnteriores($fecha, $cantidad, $formato){
		$fecha_ultima = strtotime($fecha);
		$dias =($cantidad * 86400);
		if($formato == 'n')
			$fecha_proxima = date("d-m",$fecha_ultima - $dias);
		if($formato == 'i')
			$fecha_proxima = date("Y-m-d",$fecha_ultima - $dias);
		return $fecha_proxima;
	}
	function fechasSiguientes($fecha, $cantidad, $formato){
		$fecha_ultima = strtotime($fecha);
		$dias =($cantidad * 86400);
		if($formato == 'n')
			$fecha_proxima = date("d-m",$fecha_ultima + $dias);
		if($formato == 'i')
			$fecha_proxima = date("Y-m-d",$fecha_ultima + $dias);
		if($formato == 'cn')
			$fecha_proxima = date("d-m-Y",$fecha_ultima + $dias);
		if($formato == 's')
			$fecha_proxima = date("j",$fecha_ultima + $dias);
		if($formato == 'm')
			$fecha_proxima = date("n",$fecha_ultima + $dias);
		if($formato == 'y')
			$fecha_proxima = date("Y",$fecha_ultima + $dias);
		return $fecha_proxima;
	}
	function diasTranscurridos($fecha_menor, $fecha_mayor){
		$fecha_menor = strtotime($fecha_menor);
		$fecha_mayor = strtotime($fecha_mayor);
		$diferencia = $fecha_mayor - $fecha_menor;
		$dias = $diferencia / 86400;
		return floor($dias);
	}
	function actualizaTimeStamp($hora, $cantidad, $operando){
		switch($operando){
			case '+':	$hora = $this->fechaStamp($hora);
						$hora += $cantidad * 60;
						return date('H:i', $hora);
						break;
			case '-':	$hora = $this->fechaStamp($hora);
						$hora -= $cantidad * 60;
						return date('H:i', $hora);
						break;
		}
	}
	function getPrimerDiaMes($anio,$mes){
  		return date("Y-m-d",(mktime(0,0,0,$mes,1,$anio)));
	}
	function getUltimoDiaMes($anio,$mes){
  		return date("Y-m-d",(mktime(0,0,0,$mes+1,1,$anio)-1));
	}
	//METODOS CONVERSION FECHAS
	function fechaNormal($fecha){
		if($fecha=='')
		return $fecha;
		list($anio,$mes,$dia)=explode("-",$fecha);
		return $dia."-".$mes."-".$anio;
	}
	function fechaInvertida($fecha){
		list($dia,$mes,$anio)=explode("-",$fecha);
		return $anio."-".$mes."-".$dia;
	}	

	function edadActual($fecha) {
		list($anio,$mes,$dia) = explode("-",$fecha);
    	$anio_act = date("Y");
    	$mes_act = date("m");
    	$dia_act = date("d");
		if (($mes == $mes_act) && ($dia > $dia_act))
			$anio_act=($anio_act-1);
		if ($mes > $mes_act)
			$anio_act=($anio_act-1);
		$edad=($anio_act-$anio);
		return $edad;
	}

	//GENERA DIGITO RUT
	function generaDigito($rut){
		if($rut == '')
			return '';
		$tur = strrev($rut);
		$mult = 2;
		for ($i = 0; $i <= strlen($tur); $i++) {
			if ($mult > 7)
				$mult = 2;

		$suma = $mult * substr($tur, $i, 1) + $suma;
		$mult = $mult + 1;
		}

		$valor = 11 - ($suma % 11);

		if ($valor == 11) {
		$codigo_veri = "0";
		} elseif ($valor == 10) {
		$codigo_veri = "K";
		} else {
		$codigo_veri = $valor;
		}
		return $codigo_veri;
	}
	//FORMATEAR SALIDAS
	function formatearNumero($numero){
		return number_format($numero, 0, "", ".");
	}
	function truncarTexto($string, $limit) {
		$break=" ";//CARACTER QUE USA PARA CORTAR LA CADENA
		$pad="...";//AGREGA ESTO AL FINAL DE LA CADENA DE SALIDA
		if(strlen($string) <= $limit)// RETORNA SIN CAMBIOS SI LA CADENA ES MAS CORTA QUE EL LIMITE ESTABLECIDO
			return $string;
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
		return $string;
	}
	function ocultarTexto($string){
		$string = substr($string, 0, -3)."xxx";
		return $string;
	}
	function getMesPalabra($MEScod){
		$meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
		$datos['mes'] = $meses[$MEScod];
		return ($datos);
	}

	function getFechaPalabra($fecha){
		$DIAcod = date('N',strtotime($fecha));
		$DIAdesc = date('d',strtotime($fecha));
		$MEScod = date('n',strtotime($fecha));
		$ANIOcod = date('Y',strtotime($fecha));
		$dias = array(1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado',7=>'Domingo');
		$meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
		$datos = $dias[$DIAcod]." ".$DIAdesc." de ".$meses[$MEScod]." de ".$ANIOcod;
		//$datos = strtoupper($datos);
		return ($datos);
	}
	function calcularMinutos($hora1,$hora2){
		list($horas_1,$minutos_1) = explode(':',$hora1);
		list($horas_2,$minutos_2) = explode(':',$hora2);
		$total_minutos_1 = ($horas_1 * 60)+ $minutos_1;
		$total_minutos_2 = ($horas_2 * 60)+ $minutos_2;
		$total_minutos_trasncurridos = $total_minutos_2 - $total_minutos_1;
		return $total_minutos_trasncurridos;
	}
	function actualizaPagina($accion, $totalPag){
		switch($accion){
			case 'P':	$_SESSION['pagina_actual'] = 1;
						break;
			case 'U':	$_SESSION['pagina_actual'] = $totalPag;
						break;
			case '+':	$_SESSION['pagina_actual']++;
						if($_SESSION['pagina_actual'] > $totalPag) $_SESSION['pagina_actual'] = $totalPag;
						break;
			case '-':	$_SESSION['pagina_actual']--;
						if($_SESSION['pagina_actual'] < 1) $_SESSION['pagina_actual'] = 1;
						break;
		}
	}
	function esBisiesto($ano){
	   return date('L',mktime(1,1,1,1,1,$ano));
	}
	function edadActualCompleto($fecha_de_nacimiento){
		$fecha_actual = date ("Y-m-d");
		// separamos en partes las fechas
		$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
		$array_actual = explode ( "-", $fecha_actual );
		if($array_nacimiento[0] > 1900){
			$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
			$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
			$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días
			//ajuste de posible negativo en $días
			if ($dias < 0) {
				--$meses;
				//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
				switch ($array_actual[1]) {
					   case 1:     $dias_mes_anterior=31; break;
					   case 2:     $dias_mes_anterior=31; break;
					   case 3:
							if (esBisiesto($array_actual[0]))
							{
								$dias_mes_anterior=29; break;
							} else {
								$dias_mes_anterior=28; break;
							}
					   case 4:     $dias_mes_anterior=31; break;
					   case 5:     $dias_mes_anterior=30; break;
					   case 6:     $dias_mes_anterior=31; break;
					   case 7:     $dias_mes_anterior=30; break;
					   case 8:     $dias_mes_anterior=31; break;
					   case 9:     $dias_mes_anterior=31; break;
					   case 10:     $dias_mes_anterior=30; break;
					   case 11:     $dias_mes_anterior=31; break;
					   case 12:     $dias_mes_anterior=30; break;
				}
				$dias=$dias + $dias_mes_anterior;
			}
			//ajuste de posible negativo en $meses
			if ($meses < 0) {
				--$anos;
				$meses=$meses + 12;
			}
			$edadCompleta = "$anos a&ntilde;os, $meses meses, $dias d&iacute;as";
			return($edadCompleta);
		}else{
			return("* Verificar Fecha de Nacimiento");
		}
	}

	function edadActualCompleto2($fecha_de_nacimiento){
		$fecha_actual = date ("Y-m-d");
		// separamos en partes las fechas
		$array_nacimiento = explode ( "-", $fecha_de_nacimiento );
		$array_actual = explode ( "-", $fecha_actual );
		if($array_nacimiento[0] > 1900){
			$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
			$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
			$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días
			//ajuste de posible negativo en $días
			if ($dias < 0) {
				--$meses;
				//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
				switch ($array_actual[1]) {
					   case 1:     $dias_mes_anterior=31; break;
					   case 2:     $dias_mes_anterior=31; break;
					   case 3:
							if (esBisiesto($array_actual[0]))
							{
								$dias_mes_anterior=29; break;
							} else {
								$dias_mes_anterior=28; break;
							}
					   case 4:     $dias_mes_anterior=31; break;
					   case 5:     $dias_mes_anterior=30; break;
					   case 6:     $dias_mes_anterior=31; break;
					   case 7:     $dias_mes_anterior=30; break;
					   case 8:     $dias_mes_anterior=31; break;
					   case 9:     $dias_mes_anterior=31; break;
					   case 10:     $dias_mes_anterior=30; break;
					   case 11:     $dias_mes_anterior=31; break;
					   case 12:     $dias_mes_anterior=30; break;
				}
				$dias=$dias + $dias_mes_anterior;
			}
			//ajuste de posible negativo en $meses
			if ($meses < 0) {
				--$anos;
				$meses=$meses + 12;
			}
			$edadCompleta = "$meses meses, $dias d&iacute;as";
			return($edadCompleta);
		}else{
			return("* Verificar Fecha de Nacimiento");
		}
	}
	function formateaParametro($parametro){
		$parametro = explode(',',$parametro);
		foreach($parametro as $k=>$v){
			$variable .= "'".$v."',";
		}
		$variable = rtrim($variable,',');
		return $variable;
	}

	function getFormulario($_POST){
		$array = array();
		foreach($_POST as $nombre_campo => $valor){
			$key = str_replace("$", "", $nombre_campo);
			$array[$key] = $valor;
		}
		return $array;
	}

	function eliminaEspacios($string){ // Ej: "A      B      C" -> "A B C" , Es decir, deja solo un espacio entre palabras
		$cadena = preg_replace('/\s+/', ' ', trim($string));
		return $cadena;
	}

	function CalculaEdad( $fecha ) {
		list($Y,$m,$d) = explode("-",$fecha);
		return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}

	function limpiarCaracteresEspeciales($string){
		$string = htmlentities($string);
		$string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);

		$sin_espe = str_replace(
			array("\\", "¨", "º", "-", "~",
				"#", "@", "|", "!", "\"",
				"·", "$", "%", "&", "/",
				"(", ")", "?", "'", "¡",
				"¿", "[", "^", "`", "]",
				"+", "}", "{", "¨", "´",
				">", "< ", ";", ",", ":",
				"."),
			'',
			$string);
		return $sin_espe;
	}
}?>