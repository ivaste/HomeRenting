<?php include("header.php"); ?>

<!-- PANNELLO DI CONTROLLO OSPITE -->

<?php
	$idOspite=$_COOKIE["idUtente"];

	if(isset($_COOKIE["idUtente"])){
		// Op.25. - Annullare la Prenotazione di id=1234
		if(isset($_GET["Annulla"])){
			$idP=$_GET["Annulla"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET dataannullata='$oggi', stato='Annullata'
										WHERE id=$idP;");
			$sql->execute();
		}

		// Op.22. - Cancellare la Prenotazione di id=1234
		if(isset($_GET["Cancella"])){
			$idP=$_GET["Cancella"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET datacancellata='$oggi', stato='Cancellata'
										WHERE id=$idP;");
			$sql->execute();
		}

		// Op.27. - Inserire una Recensione (come Ospite) per la Prenotazione di id=1234
		if(isset($_GET["rec"]) && isset($_POST["Voto"]) && isset($_POST["testoRec"]) && $_POST["Voto"]!=0){
			$rec=$_GET["rec"];
			$voto=$_POST["Voto"];
			$testoRec=htmlspecialchars($_POST["testoRec"]);
			$oggi=date('Y-m-d');
				
			$sql=$db->prepare("UPDATE prenotazione
										SET datarecensionealloggio='$oggi', votorecensionealloggio=$voto, testorecensionealloggio='$testoRec'
										WHERE id=$rec;");

			$sql->execute();
		}

		// Op.24. - Lista delle Prenotazioni effettuate (come Ospite)
		$sql="SELECT DISTINCT p.stato, p.id, p.alloggio, alloggio.nome, p.host, utente.nome, p.datacheckin, p.datacheckout, p.nposti, p.prezzo, p.datacancellata, p.datarifiuto, p.dataannullata
					FROM prenotazione AS p
					INNER JOIN alloggio
						ON p.alloggio=alloggio.id
					INNER JOIN utente
						ON p.host=utente.id
					WHERE p.ospite=$idOspite;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$prenotazioni=array();
		while($row=$q->fetch()){
			$prenotazioni[]=$row;
		}

		// Op.26. - Lista delle Recensioni da scrivere (come Ospite)
		$sql="SELECT DISTINCT prenotazione.id, prenotazione.alloggio, alloggio.nome, prenotazione.host, utente.nome
					FROM prenotazione
					INNER JOIN alloggio
						ON prenotazione.alloggio=alloggio.id
					INNER JOIN utente
						ON prenotazione.host=utente.id
					WHERE prenotazione.ospite=$idOspite AND prenotazione.datarecensionealloggio IS NULL AND prenotazione.stato='Conclusa';";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$recensioni=array();
		while($row=$q->fetch()){
			$recensioni[]=$row;
		}


		


	}
?>

<div class="container mt-3">
  <div class="row">
    <div class="col-sm-3">
    	<nav class="nav nav-tabs flex-sm-column nav-pills" role="tablist">
			  <a class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#alloggi" role="tab">I tuoi viaggi</a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#recensionidaScrivere" role="tab">Recensioni da scrivere <?php if(count($recensioni)!=0){ ?><span class="badge badge-danger"><?php echo count($recensioni); ?> </span><?php } ?></a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#PrenotazioniPassate" role="tab">Prenotazioni passate</a>
			</nav>
    </div>

    <div class="col-sm-auto">
    	<!-- Tab panes -->
			<div class="tab-content">
				<!-- VIAGGI -->
	    	<div class="tab-pane active" id="alloggi" role="tabpanel">
			  	<h2 class="text-center">I tuoi viaggi</h2>
			  	<!-- Richieste inviate -->
			  	<div class="card mb-2">
						<h4 class="card-header">Richieste inviate</h4>
						<div class="card-block">
					  	<div class="col-auto">
					      <table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Costo</th>
								      <th>Annulla</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="Sospeso"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[9]; ?></td>
								    	<td>
								      	<a href="guestPanel.php?Annulla=<?php echo $p[1]; ?>"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php } } ?>
								  </tbody>
								</table>
					  	</div>
					  </div>
			  	</div>

			  	<!-- Prenotazioni accettate -->
			  	<div class="card mb-2">
						<h4 class="card-header">Prenotazioni accettate</h4>
						<div class="card-block">
					  	<div class="col-auto">
					  		<table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Costo</th>
								      <th>Disdici</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="Accettata"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[9]; ?></td>
								    	<td>
								      	<a href="guestPanel.php?Cancella=<?php echo $p[1]; ?>"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php } } ?>
								  </tbody>
								</table>
					  	</div>
					  </div>
			  	</div>
			  	<!-- Soggiorni in corso -->
			  	<div class="card mb-2">
						<h4 class="card-header">Soggiorni in corso</h4>
						<div class="card-block">
					  	<div class="col-auto">
					      <table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Costo</th>
								      <th>Cancella</th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="In Corso"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[9]; ?></td>
								    	<td>
								      	<a href="guestPanel.php?Cancella=<?php echo $p[1]; ?>"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php } } ?>
								  </tbody>
								</table>
					  	</div>
					  </div>
			  	</div>
			  </div>

			  <!-- RECENSIONI DA SCRIVERE -->
			  <div class="tab-pane" id="recensionidaScrivere" role="tabpanel">
			  	<h2 class="text-center">Recensioni da scrivere <?php if(count($recensioni)!=0){ ?><span class="badge badge-danger"><?php echo count($recensioni); ?></span><?php } ?></h2>
			  	<?php foreach ($recensioni as $r) { ?>
			  	<form action="guestPanel.php?rec=<?php echo $r[0]; ?>" method="post">
				  	<div class="card mb-2">
							<div class="card-block">
								<div class="col-auto">
							  	<div class="row align-items-center">
							  		<div class="col-auto"><strong><a href="infoPrenotazione.php?id=<?php echo $r[0]; ?>"><?php echo $r[0]; ?></a></strong></div>
							  		<div class="col-auto"><a href="alloggio.php?id=<?php echo $r[1]; ?>"><?php echo $r[2]; ?></a></div>
										<div class="col-auto"><a href="viewProfile.php?id=<?php echo $r[3]; ?>"><?php echo $r[4]; ?></a></div>
										<div class="col-auto">
											<select name="Voto" class="custom-select my-1 mr-sm-2">
												<option value="0" selected>Voto</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</div>
							  	</div>
							  	<div class="row">
							  		<div class="col-12">
							  			<textarea name="testoRec" rows="4" style="width:100%;" placeholder="Inserisci un commento qui..."></textarea>
							  		</div>
							  	</div>
							  	<div class="row justify-content-end">
							  		<div class="col-auto">
							  			<button type="submit" class="btn btn-success mb-2">Pubblica</button>
							  		</div>
							  	</div>
							  </div>
							</div>
						</div>
					</form>
					<?php } ?>
					

			  </div>

			  <!-- PRENOTAZIONI PASSATE -->
			  <div class="tab-pane" id="PrenotazioniPassate" role="tabpanel">
			  	<h2 class="text-center">Prenotazioni passate</h2>
			  	<!-- Soggiorni conlusi -->
			  	<div class="card mb-2">
						<h4 class="card-header">Soggiorni conclusi</h4>
						<div class="card-block">
					  	<div class="col-auto">
					      <table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Costo</th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="Conclusa"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[9]; ?></td>
								    </tr>
								    <?php } } ?>
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
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Data Canc</th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="Cancellata"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[10]; ?></td>
								    </tr>
								    <?php } } ?>
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
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Data Rif</th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="Rifiutata"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[11]; ?></td>
								    </tr>
								    <?php } } ?>
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
								      <th>Alloggio</th>
								      <th>Host</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Data Annul</th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($prenotazioni as $p) {
								  		if($p[0]=="Annullata"){ ?>
								    <tr>
								      <th scope="row"><a href="infoPrenotazione.php?id=<?php echo $p[1]; ?>"><?php echo $p[1]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $p[2]; ?>"><?php echo $p[3]; ?></a></td>
								      <td><a href="viewProfile.php?id=<?php echo $p[4]; ?>"><?php echo $p[5]; ?></a></td>
								      <td><?php echo $p[6]; ?></td>
								      <td><?php echo $p[7]; ?></td>
								      <td><?php echo $p[8]; ?></td>
								      <td><?php echo $p[12]; ?></td>
								    </tr>
								    <?php } } ?>
								  </tbody>
								</table>
					  	</div>
					  </div>
			  	</div>

			  </div>


    	</div>
  	</div>
  </div>
</div>


<?php include("footer.php"); ?>