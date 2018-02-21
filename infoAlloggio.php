<?php include("header.php"); ?>

<div class="conteiner mt-3">
	<div class="row justify-content-center">
		<div class="col-sm-8 col-md-6 col-lg-4 col-xl-3">
			<h2>Info Alloggio #12345</h2>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-sm-4 col-lg-3 col-xl-2">
			<div id="carouselExampleIndicators" class="carousel slide" style="width:100%;" data-ride="carousel">
			  <ol class="carousel-indicators">
			    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			  </ol>
			  <div class="carousel-inner" role="listbox">
			    <div class="carousel-item active" style="height:200px;">
			      <img class="d-block img-fluid" src="Immagine.jpg" style="width:100%; height:100%; object-fit: cover !important; object-position:center !important;" alt="First slide">
			    </div>
			    <div class="carousel-item" style="height:200px;">
			      <img class="d-block img-fluid" src="Appartamento.jpg" style="width:100%; height:100%; object-fit: cover !important; object-position:center !important;" alt="Second slide">
			    </div>
			    <div class="carousel-item" style="height:200px;">
			      <img class="d-block img-fluid" src="Immagine.jpg" style="width:100%; height:100%; object-fit: cover !important; object-position:center !important;" alt="Third slide">
			    </div>
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
		</div>
		<div class="col-sm-8 col-md-6 col-lg-4 col-xl-3">
			<p><strong>Nome: </strong><a href="alloggio.php">NomeAlloggio</a></p>
			<p><strong>#Ospiti: </strong>3</p>
			<p><strong>Città: </strong>NomeCittà</p>
			<p><strong>Via: </strong>Via jsjsjsc</p>
			<p><strong>Descrizione: </strong>jsajsa hdhs djdksh aoiosda oaduoa</p>

		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-auto">
			<!-- PRENOTAZIONI -->
		  <div class="tab-pane" id="Prenotazioni" role="tabpanel">
		  	<h3 class="text-center">Prenotazioni</h3>
		  	<!-- Richieste in sospeso -->
		  	<div class="card mb-2">
					<h4 class="card-header">Richieste in sospeso <span class="badge badge-danger">2</span></h4>
					<div class="card-block">
				  	<div class="col-auto">
				      <table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Guadagno</th>
							      <th>Accetta</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>11/04/2018</td>
							      <td>18/04/2018</td>
							      <td>1</td>
							      <td>450€</td>
							    	<td>
							      	<a href="#"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
							      	<a href="#"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
							      </td>
							    </tr>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/03/2018</td>
							      <td>20/03/2018</td>
							      <td>3</td>
							      <td>250€</td>
							      <td>
							      	<a href="#"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
							      	<a href="#"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
							      </td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>
		  	<!-- Richieste accettate -->
		  	<div class="card mb-2">
					<h4 class="card-header">Richieste accettate</h4>
					<div class="card-block">
				  	<div class="col-auto">
				  		<table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Guadagno</th>
							      <th>Inizia</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/02/2018</td>
							      <td>18/02/2018</td>
							      <td>2</td>
							      <td>150€</td>
							    	<td>
							      	<a href="#"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
							      	<a href="#"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
							      </td>
							    </tr>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/03/2018</td>
							      <td>20/03/2018</td>
							      <td>3</td>
							      <td>250€</td>
							      <td>
							      	<a href="#"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
							      	<a href="#"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
							      </td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>
		  	<!-- Soggiorni in corso -->
		  	<div class="card mb-2">
					<h4 class="card-header">Soggiorni in corso</h4>
					<div class="card-block ">
				  	<div class="col-auto">
				      <table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Guadagno</th>
							      <th>Finito</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/02/2018</td>
							      <td>18/02/2018</td>
							      <td>2</td>
							      <td>150€</td>
							    	<td>
							      	<a href="#"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
							      	<a href="#"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
							      </td>
							    </tr>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/03/2018</td>
							      <td>20/03/2018</td>
							      <td>3</td>
							      <td>250€</td>
							      <td>
							      	<a href="#"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
							      	<a href="#"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
							      </td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>

		  </div>

		  <!-- PRENOTAZIONI PASSATE -->
		  <div class="tab-pane" id="PrenotazioniPassate" role="tabpanel">
		  	<h3 class="text-center">Prenotazioni passate</h3>
		  	<!-- Soggiorni conlusi -->
		  	<div class="card mb-2">
					<h4 class="card-header">Soggiorni conclusi</h4>
					<div class="card-block">
				  	<div class="col-auto">
				      <table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Guadagno</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/02/2018</td>
							      <td>18/02/2018</td>
							      <td>2</td>
							      <td>150€</td>
							    </tr>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/03/2018</td>
							      <td>20/03/2018</td>
							      <td>3</td>
							      <td>250€</td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>

		  	<!-- Soggiorni cancellati -->
		  	<div class="card mb-2">
					<h4 class="card-header">Soggiorni cancellati</h4>
					<div class="card-block">
				  	<div class="col-auto">
				      <table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Data Canc</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/02/2018</td>
							      <td>18/02/2018</td>
							      <td>2</td>
							      <td>12/02/2018</td>
							    </tr>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/03/2018</td>
							      <td>20/03/2018</td>
							      <td>3</td>
							      <td>12/02/2018</td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>

		  	<!-- Prenotazioni rifutate -->
		  	<div class="card mb-2">
					<h4 class="card-header">Prenotazioni rifutate</h4>
					<div class="card-block">
				  	<div class="col-auto">
				      <table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Data Rif</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/02/2018</td>
							      <td>18/02/2018</td>
							      <td>2</td>
							      <td>12/02/2018</td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>

		  	<!-- Prenotazioni annullate -->
		  	<div class="card mb-2">
					<h4 class="card-header">Prenotazioni annullate</h4>
					<div class="card-block">
				  	<div class="col-auto">
				      <table class="table table-responsive text-center">
							  <thead>
							    <tr>
							      <th>#id</th>
							      <th>Ospite</th>
							      <th>Check-in</th>
							      <th>Check-out</th>
							      <th>#Ospiti</th>
							      <th>Data Annul</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <th scope="row"><a href="infoPrenotazione.php">1123</a></th>
							      <td><a href="viewProfile.php">NomeUtente</a></td>
							      <td>15/02/2018</td>
							      <td>18/02/2018</td>
							      <td>2</td>
							      <td>12/02/2018</td>
							    </tr>
							  </tbody>
							</table>
				  	</div>
				  </div>
		  	</div>
		</div>

	</div>
</div>

<?php include("footer.php"); ?>