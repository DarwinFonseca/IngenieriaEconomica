<?php
{	//Definición de variables

	$nombre = $_POST['nombre'];
    $id = intval(preg_replace('/[^0-9]+/', '', $_POST['id']), 10);
    $cantidadPrestamo = intval(preg_replace('/[^0-9]+/', '', $_POST['cantidadPrestamo']), 10);
    $tipoCredito = $_POST['tipoCredito'];
    $plazoCuotaFija = $_POST['plazoCuotaFija'];
    $plazoMuerto = $_POST['plazoMuerto'];
    $periodoCuotaFija = $_POST['periodoCuotaFija'];
    $periodoMuerto = $_POST['periodoMuerto'];
    $periodoDeGracia = $_POST['periodoDeGracia'];
    $tasaEA = $_POST['tasaEA'];
    $tasaNA = $_POST['tasaNA'];
    $tasaP = $_POST['tasaP'];
	$array = DAO::obtenerArrayDatos($tipoCredito, $plazoCuotaFija, $plazoMuerto, $periodoCuotaFija, $periodoMuerto);
		$dias = $array[0];
		$periodosEnAño = $array[1];
		$mesesParaFecha = $array[2];
		$numeroCuotasPagar = $array[3];
		//echo "<br><hr>los dias son $dias<br>Los periodos en un año son $periodosEnAño<br>Los meses para la fecha son $mesesParaFecha <br>Número de cuotas $numeroCuotasPagar<hr><br>";
	$ips = DAO::obtenerIntereses($tasaEA, $tasaNA, $tasaP, $dias, $periodosEnAño);
	$i = $ips[3];

	//Obtiene la fecha para Bogotá, Colombia
	date_default_timezone_set("America/Bogota");

	$amortizacionCapital = DAO::obtenerAmortizacionCapital($cantidadPrestamo, $numeroCuotasPagar);
	$amortizacionInteres = DAO::obtenerAmortizacionInteres($cantidadPrestamo, $i);
	$nCuotasPeriodoMuerto = DAO::obtenerCuotasDeAmortizacion($periodosEnAño);
	
	/*
	echo "<hr>el valor de i es $i<br>";
    echo "<hr>Datos recibidos: <br>";
    echo "$nombre <br> $id <br> $cantidadPrestamo <br> tipo de crédito es $tipoCredito
    <br> $plazoCuotaFija <br> $plazoMuerto <br> $periodoCuotaFija <br> $periodoMuerto <br> $periodoDeGracia<hr>
	<br> $tasaEA <br> $tasaNA <br> $tasaP<hr>";
	*/
	if(empty($tasaEA) && empty($tasaNA)  && empty($tasaP) ){
		echo  " <script>alert('Recuerde digitar el valor del interés')
		location.href = '../';
		</script>";
	}
}

class DAO{

	static function obtenerIntereses($tasaEA, $tasaNA, $tasaP, $dias, $periodosEnAño){
		//Evaluando los diferentes tipos de entrada posibles...
		if ($tasaEA!=null && ($tasaNA!=null || $tasaP!=null || $tasaNA==null || $tasaP==null ) ) {
		  //echo "<br>Resultados obtenidos con el EA<br>";
		  $ips=DAO::obtenerTasasConEA($tasaEA, $dias, $periodosEnAño);
		}else{
		  if ($tasaNA!=null && ($tasaP!=null || $tasaP==null)) {
			//echo "<br>Resultados obtenidos con el NA<br>";
			$ips=DAO::obtenerTasasConNA($tasaNA, $dias, $periodosEnAño);
		  }else{
			if ($tasaP!=null) {
			  //echo "<br>Resultados obtenidos con el Periódico<br>";
			  $ips=DAO::obtenerTasasConP($tasaP, $dias, $periodosEnAño);
			}
		  }
		}
		return $ips;
	}

	static function obtenerArrayDatos($tipoCredito, $plazoCuotaFija, $plazoMuerto, $periodoCuotaFija, $periodoMuerto){
		if ($tipoCredito=="cuotaFija") {
			$array = DAO::obtenerDiasPeriodosMeses($periodoCuotaFija);
			$nCuotasPagar = $plazoCuotaFija * $array[1];
			array_push($array, $nCuotasPagar);
		}else{
			$array = DAO::obtenerDiasPeriodosMeses($periodoMuerto);
			$nCuotasPagar = $plazoMuerto * $array[1];
			array_push($array, $nCuotasPagar);
		}
		return $array;
	}

	static function obtenerDiasPeriodosMeses($periodo){
	//la función regresa un arreglo con los días del periodo, periodos en el año y los meses usadas en las fechas respectivamente.
		switch ($periodo) {
		  case 'mesVencido':
			return [30, 12, 1] ;
			break;
		  case 'bimestreVencido':
			return [60, 6, 2];
			break;
		  case 'trimestreVencido':
			return [90, 4, 3];
			break;
		}
	}

	static function obtenerTasasConEA($valorRecibido, $dias, $meses){
		$iEA=$valorRecibido;
		$exponente = $dias / 360;
		$iPeriodico = (pow((1+$valorRecibido/100),$exponente) - 1)*100;
		$iNA = $iPeriodico * $meses;
		$i = $iPeriodico/100;
		//echo "El valor EA = $iEA, el NA = $iNA, el periódico = $iPeriodico, el valor de i = $i";
		return array($iEA, $iNA, $iPeriodico, $i);
	}

	static function obtenerTasasConNA($valorRecibido, $dias, $meses){
		$iNA=$valorRecibido;
		$iPeriodico = $valorRecibido / $meses;
		$exponente = 360 / $dias;
		$iEA = (pow((1+($iPeriodico/100)),$exponente) - 1)*100;
		$i = $iPeriodico/100;
		//echo "El valor EA = $iEA, el NA = $iNA, el periódico = $iPeriodico, el valor de i = $i";
		return array($iEA, $iNA, $iPeriodico, $i);
	}

	static function obtenerTasasConP($valorRecibido, $dias, $meses){
		$iPeriodico=$valorRecibido;
		$iNA = $valorRecibido * $meses;
		$exponente = 360 / $dias;
		$iEA = (pow((1+($valorRecibido/100)),$exponente) - 1)*100;
		$i = $valorRecibido/100;
		//echo "El EA = $iEA, el valor NA = $iNA, el periódico = $iPeriodico, el valor de i = $i";
		return array($iEA, $iNA, $iPeriodico, $i);
	}

	static function obtenerValorCuotaFija($cantidadPrestamo, $numeroCuotasPagar, $i){
		//$aux=pow((1+round($i,4)),$numeroCuotasPagar);
		//$valorCuotaFija=$cantidadPrestamo * ( ($aux * round($i,4)) / ($aux - 1) );
		$aux=pow((1+$i),$numeroCuotasPagar);
		$valorCuotaFija=$cantidadPrestamo * ( ($aux * $i) / ($aux - 1) );
		return $valorCuotaFija;
	}

	static function obtenerAmortizacionInteres($ValorPrestamo, $i) {
        return ( $ValorPrestamo * $i );
    }

	static function obtenerAmortizacionCapital($valorCuotaFija, $amortizacionInteres) {
        return ( $valorCuotaFija - $amortizacionInteres );
    }

	static function graficarTablaCuotaFija($cantidadPrestamo, $numeroCuotasPagar, $mesesParaFecha, $amortizacionCapital, $amortizacionInteres, $i){
      $year=date("Y");
      $month=date("m");
      $day=date("d");
      //Restricciones para meses y años

      $inicioTabla=
        '<center><h1>Cuadro de amortización con cuota fija</h1></center>
		<div class="container table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr align="right">
                <th>N° cuota</th>
                <th>Fecha</th>
                <th>Saldo capital</th>
                <th>Amortizacion de capital</th>
                <th>Amortizacion de interés</th>
                <th>Cuota fija</th>
                <th>Flujo de caja</th>
              </tr>
            </thead>
            <tbody>';
      $finTabla='
            </tbody>
          </table>
        </div>';

      echo "$inicioTabla";

      //Impresion de los datos para cada fila en la tabla de amortización.
      for ($x=0; $x <= $numeroCuotasPagar; $x++) {

        //Modificaciones para cada fila
        if($x==0) {
          $showAC = 0;
          $showAI = 0;
		  $showCF = 0;
		  $showFC = $cantidadPrestamo;
          $showSC = $cantidadPrestamo;
		}else{
          $month += $mesesParaFecha;
          $showCF = DAO::obtenerValorCuotaFija($cantidadPrestamo, $numeroCuotasPagar, $i);
          $showFC = -$showCF;
          $showAI = DAO::obtenerAmortizacionInteres($showSC, $i);
		  //$showSaldoCapitalAnterior = $showSC + $showCF;
		  $showAC = DAO::obtenerAmortizacionCapital($showCF, $showAI);
          $showSC -= $showAC;
		}
        if ($month>12) {
          $month-=12;
          $year++;
        }
        //Para evitar que muestre -0,00 sino 0,00
        if ($showSC<0) {
          $showSC*=(-1);
        }

	  echo '
        <tr align="right">
          <th>'.$x.'</th>
          <td>'.$day."-".$month."-".$year.'</td>
          <td>'.number_format($showSC,2).'</td>
          <td>'.number_format($showAC,2).'</td>
          <td>'.number_format($showAI,2).'</td>
          <td>'.number_format($showCF,2).'</td>
          <td>'.number_format($showFC,2).'</td>
        </tr>';
      }

      echo "$finTabla";
    }

	static function obtenerCuotasDeAmortizacion($periodosEnAño){
		//echo "<hr><hr><hr><br><br>PERIODOS $periodosEnAño MULTIPLICADO POR 3 =  ".($periodosEnAño*3);
		return $periodosEnAño*3;
	}

	static function graficarTablaMuerto($cantidadPrestamo, $numeroCuotasPagar, $mesesParaFecha, $amortizacionCapital, $amortizacionInteres, $i, $nCuotasPeriodoMuerto){
      $year=date("Y");
      $month=date("m");
      $day=date("d");
      //Restricciones para meses y años

      $inicioTabla=
        '<center><h1>Cuadro de amortización con periodo de gracia muerto</h1></center>
		<div class="container table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr align="right">
                <th>N° cuota</th>
                <th>Fecha</th>
                <th>Saldo capital</th>
                <th>Amortizacion de capital</th>
                <th>Amortizacion de interés</th>
                <th>Cuota fija</th>
                <th>Flujo de caja</th>
              </tr>
            </thead>
            <tbody>';
      $finTabla='
            </tbody>
          </table>
        </div>';

      echo "$inicioTabla";
	  $nCuotasSinPeriodoMuerto=$numeroCuotasPagar-$nCuotasPeriodoMuerto;
      //Impresion de los datos para cada fila en la tabla de amortización.
      for ($x=0; $x <= $numeroCuotasPagar; $x++) {
		//Modificaciones para cada fila
        if($x==0) {
          $showAC = 0;
          $showAI = 0;
		  $showCF = 0;
		  $showFC = $cantidadPrestamo;
          $showSC = $cantidadPrestamo;
		}else{
			if($x > 0 && $x <= $nCuotasPeriodoMuerto ){

			  $month += $mesesParaFecha;
			  $showAC = 0;
			  $showCF = 0;
			  $showAI = DAO::obtenerAmortizacionInteres($showSC, $i);
			  $showSC += $showAI;
			  $showFC = 0;
			}else{
				if($x == $nCuotasPeriodoMuerto+1){
			  $showCF = DAO::obtenerValorCuotaFija($showSC, $nCuotasSinPeriodoMuerto, $i);
			  }
			  $month += $mesesParaFecha;
			  $showFC = -$showCF;
			  $showAI = DAO::obtenerAmortizacionInteres($showSC, $i);
			  //$showSaldoCapitalAnterior = $showSC + $showCF;
			  $showAC = DAO::obtenerAmortizacionCapital($showCF, $showAI);
			  $showSC -= $showAC;
			}
		}
        if ($month>12) {
          $month-=12;
          $year++;
        }
        //Para evitar que muestre -0,00 sino 0,00
        if ($showSC<0) {
          $showSC*=(-1);
        }

	  echo '
        <tr align="right">
          <th>'.$x.'</th>
          <td>'.$day."-".$month."-".$year.'</td>
          <td>'.number_format($showSC,2).'</td>
          <td>'.number_format($showAC,2).'</td>
          <td>'.number_format($showAI,2).'</td>
          <td>'.number_format($showCF,2).'</td>
          <td>'.number_format($showFC,2).'</td>
        </tr>';
      }

      echo "$finTabla";
    }

}
?>
<!DOCTYPE html>
<html lang="es" >

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <?php include 'header2.php';?>

    <body onload="funcionTipoPrestamo()" id="page-top">
	
	<!-- Image and text -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	  <img class="mr-2" src="../img/min_icon.png" width="32" height="32">
      <a class="navbar-brand" href="../">Economic Solutions</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="../">Inicio <span class="sr-only">(current)</span></a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="#" onclick="imprimirResultados()">Imprimir resultados</a>
          </li>
        </ul>
		<label class="navbar-brand" title="Bogotá, Colombia" ><h4><?php date_default_timezone_set("America/Bogota"); echo "Fecha: " . date("Y/m/d");?></h4></label>			
      </div>
    </nav>
	
	
	<div class="container">
    <center>
	<br>
	<img class="" src="../img/min_icon.png" alt="" width="10%" height="auto">
        <h1 class="mb-1">Economic Solutions</h1><br>
        <h2>Resultados del simulador de crédito</h2>
    </center>
    <hr><br>
    
    <form class="" action="methods.php" method="POST">
	<div class="row">
		<div class="col-sm">
		  <div class="form-group row">
            <Label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">Nombre del cliente:
                <input class="form-control" type="text" name="nombre" placeholder="Ej: Pepito Perez" value="<?=$nombre;?>" required>
            </div>
        </div>
			<div id="form">
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Número de identificación:
						<input class="form-control" id="amount" type="text" min="5000000" max="9999999999" name="id" placeholder="1234567890" value="<?= number_format($id) ;?>">
					</div>
				</div>
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Cantidad del préstamo:
						<input class="form-control"id="amount" type="text" name="cantidadPrestamo" min="1000000" max="1000000000" placeholder="Cantidad del préstamo" value="<?= number_format($cantidadPrestamo);?>">
					</div>
				</div>
			</div>
			<div class="form-group row">
				<Label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">Tipo de préstamo:
					<select class="form-control" name="tipoCredito" id="tipoCredito" onchange="funcionTipoPrestamo()">
						<?php
						if ($tipoCredito=="cuotaFija") {
						echo '
						<option value="cuotaFija" id="cuotaFija" selected>Cuota Fija</option>
						<option value="periodoDeGraciaMuerto" id="periodoDeGraciaMuerto">Periodo De Gracia Muerto</option>';
						}else{
						echo '
						<option value="cuotaFija" id="cuotaFija" >Cuota Fija</option>
						<option value="periodoDeGraciaMuerto" id="periodoDeGraciaMuerto" selected>Periodo De Gracia Muerto</option>';
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm">
			  <div id="datosCuotaFija">
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Plazo (años):
						<select class="form-control" name="plazoCuotaFija" id="plazoCuotaFija" placeholder="Tiempo en años">
							<?php
							$plazosCF = array(3,4,5,6,7);
							foreach($plazosCF as $plazos){
							if($plazos==$plazoCuotaFija){
							echo '<option value='.$plazos.' selected>'.$plazos.'</option>';
							}else{
							echo '<option value='.$plazos.'>'.$plazos.'</option>';
							}
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Periodo de amortización:
						<select class="form-control" name="periodoCuotaFija">
							<?php
							$periodosCFArray = array("mesVencido","trimestreVencido");
							switch ($periodoCuotaFija){
							case "mesVencido":
							echo '
							<option value="mesVencido" selected>Mensual</option>
							<option value="trimestreVencido">Trimestral</option>';
							break;
							case "trimestreVencido":
							echo '
							<option value="mesVencido">Mensual</option>
							<option value="trimestreVencido" selected>Trimestral</option>';
							break;
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div id="datosPeriodoDeGraciaMuerto">
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Plazo (años):
						<select class="form-control" name="plazoMuerto" id="plazoMuerto" placeholder="Tiempo en años">
							<?php
							$plazosMArray = array(5,6,7,8,9,10);
							foreach($plazosMArray as $plazos){
							if($plazos==$plazoMuerto){
							echo '<option value='.$plazos.' selected>'.$plazos.'</option>';
							}else{
							echo '<option value='.$plazos.'>'.$plazos.'</option>';
							}
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Periodo de amortización:
						<select class="form-control" name="periodoMuerto">
							<?php
							switch ($periodoMuerto){
							case "mesVencido":
							echo '
							<option value="mesVencido" selected>Mensual</option>
							<option value="bimestreVencido">Bimestral</option>
							<option value="trimestreVencido">Trimestral</option>';
							break;
							case "bimestreVencido":
							echo '
							<option value="mesVencido">Mensual</option>
							<option value="bimestreVencido" selected>Bimestral</option>
							<option value="trimestreVencido">Trimestral</option>';
							break;
							case "trimestreVencido":
							echo '
							<option value="mesVencido">Mensual</option>
							<option value="bimestreVencido">Bimestral</option>
							<option value="trimestreVencido" selected>Trimestral</option>';
							break;
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Periodo de gracia (años):
						<input class="form-control" type="text" disabled value="3">
						<input class="form-control" type="text" hidden name="periodoDeGracia" value="3">
					</div>
				</div>
			</div>

			<div id="tasasDeInteres">
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Efectivo anual (%):
						<input class="form-control" type="number" step=".01" min="0" name="tasaEA" value="<?=round($ips[0],2);?>" placeholder="Efectivo anual">
					</div>
				</div>
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Nominal anual (%):
						<input class="form-control" type="number" step=".01" min="0" name="tasaNA" value="<?=round($ips[1],2);?>" placeholder="Normal anual">
					</div>
				</div>
				<div class="form-group row">
					<Label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">Periódico (%):
						<input class="form-control" type="number" step=".01" min="0" name="tasaP" value="<?=round($ips[2],2);?>" placeholder="Periódico">
					</div>
				</div>
			</div>
		</div>
    </div>
        <center>
            <input class="btn btn-primary" type="submit" name="consultar" value="Consultar">
        </center>
        <br><br><br><br>
    </form>
	<script>
	(function ($, undefined) {

		"use strict";

		// When ready.
		$(function () {

			var $form = $("#form");
			var $input = $form.find("input");

			$input.on("keyup", function (event) {


				// When user select text in the document, also abort.
				var selection = window.getSelection().toString();
				if (selection !== '') {
					return;
				}

				// When the arrow keys are pressed, abort.
				if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
					return;
				}


				var $this = $(this);

				// Get the value.
				var input = $this.val();

				var input = input.replace(/[\D\s\._\-]+/g, "");
				input = input ? parseInt(input, 10) : 0;

				$this.val(function () {
					return input === 0 ? "" : input.toLocaleString("en-US");
				});
			});

			/**
		   * ==================================
		   * When Form Submitted
		   * ==================================
		   */
			$form.on("submit", function (event) {

				var $this = $(this);
				var arr = $this.serializeArray();

				for (var i = 0; i < arr.length; i++) {if (window.CP.shouldStopExecution(0)) break;
					arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, ''); // Sanitize the values.
				}window.CP.exitedLoop(0);;

				console.log(arr);

				event.preventDefault();
			});

		});
	})(jQuery);
	//# sourceURL=pen.js
	</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

    <script>
                    function funcionTipoPrestamo() {
                        var x = document.getElementById("tipoCredito").value;
                        if (x == "cuotaFija") {
                            $(document.getElementById("datosCuotaFija")).show();
                            $(document.getElementById("datosPeriodoDeGraciaMuerto")).hide();
                        }
                        if (x == "periodoDeGraciaMuerto") {
                            $(document.getElementById("datosCuotaFija")).hide();
                            $(document.getElementById("datosPeriodoDeGraciaMuerto")).show();
                        }
                    }

                    function imprimirResultados() {
                        print();
                    }
    </script>
    <?php
    if ($tipoCredito=="cuotaFija") {
    DAO::graficarTablaCuotaFija($cantidadPrestamo, $numeroCuotasPagar, $mesesParaFecha, $amortizacionCapital, $amortizacionInteres, $i);
    }else{
    DAO::graficarTablaMuerto($cantidadPrestamo, $numeroCuotasPagar, $mesesParaFecha, $amortizacionCapital, $amortizacionInteres, $i, $nCuotasPeriodoMuerto);
    }
    ?>
    <input class="btn btn-danger" name="Imprimir" value="Imprimir" onclick="imprimirResultados()">
    <!-- Footer -->
    <?php include 'footer.php';?>

    <!-- Scripts de diseño -->
    <?php include 'scripts2.php';?>
	</div>
</body>
</html>
