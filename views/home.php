<!DOCTYPE html>
<html lang="es"> 
<?php include 'header.php';?>
  <body onload="funcionTipoPrestamo()" id="page-top">
  
	<!-- Image and text -->
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	  <img class="mr-2" src="img/min_icon.png" width="32" height="32">
      <a class="navbar-brand" href="#">Economic Solutions</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#soluciones">Tipos de simulación</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="#contacto">Contáctenos</a>
          </li>
		</ul>
		<label class="navbar-brand" title="Bogotá, Colombia"><h4><?php date_default_timezone_set("America/Bogota"); echo "Fecha: " . date("Y/m/d");?></h4></label>	
      </div>
	</nav>
  
    

    <!-- Header -->
    <header class="masthead d-flex">
      <div class="container text-center my-auto">
	  <img class="" src="img/min_icon.png" alt="" width="10%" height="auto">
        <h1 style="font-size:8vw;">Bienvenido al simulador de crédito</h1>
        <!--h3 class="mb-5">
          <em>
            <?php date_default_timezone_set("America/Bogota");
        	echo date("Y/m/d")."<br><br>"; ?> </em>
        </h3-->
		<br>
        <a class="btn btn-info btn-xl js-scroll-trigger" href="#soluciones">Soluciones</a>
      </div>
      <div class="overlay"></div>
    </header>
   
    <!-- Portfolio -->
    <section class="content-section" id="soluciones">
      <div class="container">
        <div class="content-section-heading text-center">
          <h3 class="text-secondary mb-0">Seleccione:</h3>
          <h2 class="mb-5">Cuadros de amortización</h2>
        </div>
        <div class="row no-gutters">
          <div class="col-lg-6">
            <a class="portfolio-item" data-toggle="modal" data-target="#miModal">
              <span class="caption">
                <span class="caption-content">
                  <h2>Cuota fija</h2>
                  <p class="mb-0">Se calcula el interés sobre el saldo de capital insoluto al momento del pago proyectado, con una tasa de interés y plazo determinado por las partes, lo que implica que de no modificarse las condiciones iniciales del contrato, los intereses cobrados en cada cuota se liquidan y se cobran sobre el saldo insoluto para ese momento y no por todo el periodo restante.</p>
                </span>
              </span>
              <img class="img-fluid" src="img/portfolio-1.jpg" alt="">
            </a>
          </div>
         
          <div class="col-lg-6">
            <a class="portfolio-item" data-toggle="modal" data-target="#miModal">
              <span class="caption">
                <span class="caption-content">
                  <h2>Periodo de gracia muerto</h2>
                  <p class="mb-0">Es aquel tiempo en el que no hay pagos de intereses ni abono a capital, pero los intereses causados se acumulan al capital principal, produciéndose un incremento en la deuda por acumulación de los intereses durante el periodo de gracia.</p>
                </span>
              </span>
              <img class="img-fluid" src="img/portfolio-4.jpg" alt="">
            </a>
          </div>
        </div>
      </div>
	  <center>
	  <br>
	<a class="btn btn-primary btn-xl " data-toggle="modal" data-target="#miModal" id="contacto">Consultar</a></center>
	</section>

	<div class="container">
	<hr>
	<!-- Contact Us -->
	<!--Section: Contact v.2-->
	<section class="mb-4 container" >

		<!--Section heading-->
		<h2 class="h1-responsive font-weight-bold text-center my-4">Contactenos</h2>
		<!--Section description-->
		<p class="text-center w-responsive mx-auto mb-5">¿Tiene alguna pregunta? Por favor no dude en contactarnos directamente. Nuestro equipo le responderá en cuestión de horas para ayudarlo.</p>

		<div class="row">

			<!--Grid column-->
			<div class="col-md-9 mb-md-0 mb-5">
				<form id="contact-form" name="contact-form" action="mail.php" method="POST">

					<!--Grid row-->
					<div class="row">

						<!--Grid column-->
						<div class="col-md-6">
							<div class="md-form mb-0">
								<input type="text" id="name" name="name" class="form-control">
								<label for="name" class="">Nombre</label>
							</div>
						</div>
						<!--Grid column-->

						<!--Grid column-->
						<div class="col-md-6">
							<div class="md-form mb-0">
								<input type="text" id="email" name="email" class="form-control">
								<label for="email" class="">Email</label>
							</div>
						</div>
						<!--Grid column-->

					</div>
					<!--Grid row-->

					<!--Grid row-->
					<div class="row">
						<div class="col-md-12">
							<div class="md-form mb-0">
								<input type="text" id="subject" name="subject" class="form-control">
								<label for="subject" class="">Asunto</label>
							</div>
						</div>
					</div>
					<!--Grid row-->

					<!--Grid row-->
					<div class="row">

						<!--Grid column-->
						<div class="col-md-12">

							<div class="md-form">
								<textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
								<label for="message">Mensaje</label>
							</div>

						</div>
					</div>
					<!--Grid row-->

				</form>

				<div class="text-center text-md-left">
					<a class="btn btn-primary" onclick="alert('Datos enviados')">Enviar</a>
				</div>
				
			</div>
			<!--Grid column-->

			<!--Grid column-->
			<div class="col-md-3 text-center">
				<ul class="list-unstyled mb-0">
					<li><i class="fa fa-map-marker fa-2x"></i>
						<p>San Francisco, CA 94126, USA</p>
					</li>

					<li><i class="fa fa-phone mt-4 fa-2x"></i>
						<p>+ 01 234 567 89</p>
					</li>

					<li><i class="fa fa-envelope mt-4 fa-2x"></i>
						<p>contacto@mdbootstrap.com</p>
					</li>
				</ul>
			</div>
			<!--Grid column-->

		</div>

	</section>
	<!--Section: Contact v.2-->
	<hr>
	</div>
	
	
    <!--Pop Up de http://blog.gtoeurope.es/crear-modal-en-bootstrap/-->

    <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Diligencie el formulario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form class="modal-body" action="views/methods.php" method="POST">
              <div class="form-group">
                Nombre del cliente:
                <input class="form-control" type="text" name="nombre" placeholder="Ej: Pepito Perez" required>
                <br>Número de identificación:<div id="form"> 
                <input class="form-control" id="amount" type="text" min="5000000" max="9999999999" name="id" placeholder="1234567890" required>
                <br>Cantidad del préstamo:
                <input class="form-control" id="amount" type="text" name="cantidadPrestamo" min="1000000" max="9000000000" placeholder="Cantidad del préstamo" required></div>
                <br>Tipo de préstamo:
                <select class="form-control" name="tipoCredito" id="tipoCredito" onchange="funcionTipoPrestamo()">
                    <option value="cuotaFija" id="cuotaFija">Cuota Fija</option>
                    <option value="periodoDeGraciaMuerto" id="periodoDeGraciaMuerto">Periodo De Gracia Muerto</option>
                </select>

                <div id="datosCuotaFija">
                  <br>Plazo (años):
                  <select class="form-control" name="plazoCuotaFija" id="plazoCuotaFija" placeholder="Tiempo en años">
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                  </select> 
                  <br>Periodo de amortización:
                  <select class="form-control" name="periodoCuotaFija">
                      <option value="mesVencido">Mensual</option>
                      <option value="trimestreVencido">Trimestral</option>
                  </select>
                </div>

                <div id="datosPeriodoDeGraciaMuerto">
                  <br>Plazo (años):
                  <select class="form-control" name="plazoMuerto" id="plazoMuerto" placeholder="Tiempo en años">
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                  </select> 
                  <br>Periodo de amortización:
                  <select class="form-control" name="periodoMuerto">
                      <option value="mesVencido">Mensual</option>
                      <option value="bimestreVencido">Bimestral</option>
                      <option value="trimestreVencido">Trimestral</option>
                  </select>
                  <br>Periodo de gracia (años):
                  <input class="form-control" type="text" disabled value="3">
                  <input class="form-control" type="text" hidden name="periodoDeGracia" value="3">
                </div>

                <div id="tasasDeInteres">
                    <br>Efectivo anual (%):
                    <input class="form-control" type="number" step=".01" min="0.1" name="tasaEA" placeholder="Efectivo anual">
                    <br>Nominal anual (%):
                    <input class="form-control" type="number" step=".01" min="0.1" name="tasaNA" placeholder="Normal anual">
                    <br>Periódico (%):
                    <input class="form-control" type="number" step=".01" min="0.1" name="tasaP" placeholder="Periódico">
                </div>
				<br>
                <center>
                  <input class="btn btn-primary" type="submit" name="consultar" value="Consultar">
                </center>
              </div>
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
			
            <script>
			
              function onload(){

                var tipoInicio=document.getElementById("tipoCredito").value;
                document.getElementById("body").innerHTML += tipoInicio;
                    $(document.getElementById("datosCuotaFija")).show();
                    $(document.getElementById("datosPeriodoDeGraciaMuerto")).hide();
				}
              function funcionTipoPrestamo() {
                var x = document.getElementById("tipoCredito").value;
                if (x=="cuotaFija") {
                  $(document.getElementById("datosCuotaFija")).show();
                  $(document.getElementById("datosPeriodoDeGraciaMuerto")).hide();
                }
                if (x=="periodoDeGraciaMuerto") {
                  $(document.getElementById("datosCuotaFija")).hide();
                  $(document.getElementById("datosPeriodoDeGraciaMuerto")).show();
                }
              }
            </script>
          </div>
        </div>
      </div>
    </div>
 
    <!-- Footer -->
    <?php include 'footer.php';?>

    <!-- Scripts de diseño -->
    <?php include 'scripts.php';?>


  </body>

</html>
