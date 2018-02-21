<?php include("header.php"); ?>

<!-- PANNELLO DI CONTROLLO HOST -->
<?php
	$idHost=$_COOKIE["idUtente"];

	if(isset($_COOKIE["idUtente"])){
		// OP.17 - Inserire una Recensione (come Host) per la Prenotazione di id=1234
		////////////////PROVAREEEEEEEEEEEEEEEEEEEEEEE?
		if(isset($_GET["rec"]) && isset($_POST["Voto"]) && isset($_POST["testoRec"]) && $_POST["Voto"]!=0){
			$rec=$_GET["rec"];
			$voto=$_POST["Voto"];
			$testoRec=htmlspecialchars($_POST["testoRec"]);
			$oggi=date('Y-m-d');
				
			$sql=$db->prepare("UPDATE prenotazione
										SET datavalutaospite='$oggi', votovalutaospite=$voto, testovalutaospite='$testoRec'
										WHERE id=$rec;");

			$sql->execute();
		}

		// OP.13 - Archiviare l’Alloggio di id=1234
		if(isset($_GET["Archivia"])){
			$idA=$_GET["Archivia"];
			$sql=$db->prepare("UPDATE alloggio
												SET archiviato=TRUE
												WHERE id=$idA;");
			$sql->execute();
		}

		// OP.14 - Dis-Archiviare l’Alloggio di id=1234
		if(isset($_GET["DisArchivia"])){
			$idA=$_GET["DisArchivia"];
			$sql=$db->prepare("UPDATE alloggio
												SET archiviato=FALSE
												WHERE id=$idA;");
			$sql->execute();
		}

		// OP.15 - Cancellare l’Alloggio di id=1234 !!!!!!!!!!!!!!NON PUO ESSERE ELIMINATO SE C'È ALMENO UNA PRENOTAZIONE
		if(isset($_GET["Elimina"])){
			$idA=$_GET["Elimina"];
			$sql=$db->prepare("DELETE FROM alloggio
												WHERE id=$idA;");
			$sql->execute();
		}

		// OP.19 - Accettare Prenotazione di id=1234
		if(isset($_GET["Accetta"])){
			$idP=$_GET["Accetta"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET dataaccettata='$oggi', stato='Accettata'
										WHERE id=$idP;");
			$sql->execute();
		}

		// OP.20 - Rifiutare Prenotazione di id=1234
		if(isset($_GET["Rifiuta"])){
			$idP=$_GET["Rifiuta"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET datarifiuto='$oggi', stato='Rifiutata'
										WHERE id=$idP;");
			$sql->execute();
		}

		// OP.21 - Iniziare il Soggiorno di id=1234
		if(isset($_GET["Inizia"])){
			$idP=$_GET["Inizia"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET stato='In Corso'
										WHERE id=$idP;");
			$sql->execute();
		}

		// OP.22 - Cancellare la Prenotazione di id=1234
		if(isset($_GET["Cancella"])){
			$idP=$_GET["Cancella"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET datacancellata='$oggi', stato='Cancellata
										WHERE id=$idP;");
			$sql->execute();
		}

		// OP.23 - Concludere la Prenotazione di id=1234
		if(isset($_GET["Concludi"])){
			$idP=$_GET["Concludi"];
			$oggi=date('Y-m-d');
			$sql=$db->prepare("UPDATE prenotazione
										SET stato='Conclusa'
										WHERE id=$idP;");
			$sql->execute();
		}


		// OP.11 - Lista degli Alloggi non archiviati dell’Utente con id=1234
		$sql="SELECT DISTINCT id, nome, nposti, prezzoxnotte
					FROM alloggio
					WHERE proprietario=$idHost AND archiviato=FALSE;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$alloggi=array();
		while($row=$q->fetch()){
			$alloggi[]=$row;
		}

		// OP.12 - Lista degli Alloggi archiviati dell’Utente con id=1234
		$sql="SELECT DISTINCT id, nome, nposti, prezzoxnotte
					FROM alloggio
					WHERE proprietario=$idHost AND archiviato=TRUE;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$alloggiA=array();
		while($row=$q->fetch()){
			$alloggiA[]=$row;
		}

		// OP.16 - Lista delle Recensioni da scrivere (come Host)
		$sql="SELECT DISTINCT prenotazione.id, prenotazione.alloggio, alloggio.nome, prenotazione.ospite, utente.nome
					FROM prenotazione
					INNER JOIN alloggio
						ON prenotazione.alloggio=alloggio.id
					INNER JOIN utente
						ON prenotazione.ospite=utente.id
					WHERE prenotazione.host=$idHost AND prenotazione.datavalutaospite IS NULL AND prenotazione.stato='Conclusa';";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$recensioni=array();
		while($row=$q->fetch()){
			$recensioni[]=$row;
		}

		// OP.18 - Lista delle Prenotazioni ricevute (come Host)
		$sql="SELECT DISTINCT p.stato, p.id, p.alloggio, alloggio.nome, p.ospite, utente.nome, p.datacheckin, p.datacheckout, p.nposti, p.prezzo, p.datacancellata, p.datarifiuto, p.dataannullata
					FROM prenotazione AS p
					INNER JOIN alloggio
						ON p.alloggio=alloggio.id
					INNER JOIN utente
						ON p.ospite=utente.id
					WHERE p.host=$idHost;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$prenotazioni=array();
		while($row=$q->fetch()){
			$prenotazioni[]=$row;
		}



	}

?>


<div class="container mt-3">
  <div class="row">
    <div class="col-sm-3">
    	<nav class="nav nav-tabs flex-sm-column nav-pills" role="tablist">
			  <a class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#alloggi" role="tab">I tuoi alloggi</a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#recensionidaScrivere" role="tab">Recensioni da scrivere <?php if(count($recensioni)!=0){ ?><span class="badge badge-danger"><?php echo count($recensioni); ?> </span><?php } ?></a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#Prenotazioni" role="tab">Prenotazioni <span class="badge badge-danger">2</span></a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#PrenotazioniPassate" role="tab">Prenotazioni passate</a>
			</nav>
    </div>

    <div class="col-sm-auto">
    	<!-- Tab panes -->
			<div class="tab-content">
				<!-- ALLOGGI-->
	    	<div class="tab-pane active" id="alloggi" role="tabpanel">
			  	<h2 class="text-center">I tuoi alloggi <a href="editAlloggio.php?Nuovo=1"><span class="badge badge-primary"><i class="fa fa-plus" aria-hidden="true"></i> Crea nuovo</span></a></h2>
			  	<!-- Alloggi prenotabili -->
			  	<div class="card mb-2">
						<h4 class="card-header">Alloggi prenotabili</h4>
						<div class="card-block">
					  	<div class="col-auto">
					      <table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>#Posti</th>
								      <th>Prezzo</th>
								      <th></th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($alloggi as $a) { ?>
								    <tr>
								      <th scope="row"><a href="infoAlloggio.php?id=<?php echo $a[0]; ?>"><?php echo $a[0]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $a[0]; ?>"><?php echo $a[1]; ?></a></td>
								      <td><?php echo $a[2]; ?></td>
								      <td><?php echo $a[3]; ?>€</td>
								    	<td>
								      	<a href="editAlloggio.php?id=<?php echo $a[0]; ?>"><span class="badge badge-success"><i class="fa fa-pencil" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?Archivia=<?php echo $a[0]; ?>"><span class="badge badge-info"><i class="fa fa-download" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?Elimina=<?php echo $a[0]; ?>"><span class="badge badge-danger"><i class="fa fa-trash" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php }?>
								  </tbody>
								</table>
					  	</div>
					  </div>
			  	</div>

			  	<!-- Alloggi  archiviati -->
			  	<div class="card mb-2">
						<h4 class="card-header">Alloggi archiviati</h4>
						<div class="card-block">
					  	<div class="col-auto">
					      <table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>#Posti</th>
								      <th>Prezzo</th>
								      <th></th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($alloggiA as $a) { ?>
								    <tr>
								      <th scope="row"><a href="infoAlloggio.php?id=<?php echo $a[0]; ?>"><?php echo $a[0]; ?></a></th>
								      <td><a href="alloggio.php?id=<?php echo $a[0]; ?>"><?php echo $a[1]; ?></a></td>
								      <td><?php echo $a[2]; ?></td>
								      <td><?php echo $a[3]; ?>€</td>
								    	<td>
								      	<a href="editAlloggio.php?id=<?php echo $a[0]; ?>"><span class="badge badge-success"><i class="fa fa-pencil" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?DisArchivia=<?php echo $a[0]; ?>"><span class="badge badge-info"><i class="fa fa-upload" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?Elimina=<?php echo $a[0]; ?>"><span class="badge badge-danger"><i class="fa fa-trash" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php }?>
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
			  	<form action="hostPanel.php?rec=<?php echo $r[0]; ?>" method="post">
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

			  <!-- PRENOTAZIONI -->
			  <div class="tab-pane" id="Prenotazioni" role="tabpanel">
			  	<h2 class="text-center">Prenotazioni</h2>
			  	<!-- Richieste in sospeso -->
			  	<div class="card mb-2">
						<h4 class="card-header">Richieste in sospeso <span class="badge badge-danger">2</span></h4>
						<div class="card-block">
					  	<div class="col-auto">
					      <table class="table table-responsive text-center">
								  <thead>
								    <tr>
								      <th>#id</th>
								      <th>Alloggio</th>
								      <th>Ospite</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Guadagno</th>
								      <th>Accetta</th>
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
								      <td><?php echo $p[9]; ?>€</td>
								    	<td>
								      	<a href="hostPanel.php?Accetta=<?php echo $p[1]; ?>"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?Rifiuta=<?php echo $p[1]; ?>"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php } } ?>
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
								      <th>Alloggio</th>
								      <th>Ospite</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Guadagno</th>
								      <th>Inizia</th>
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
								      <td><?php echo $p[9]; ?>€</td>
								    	<td>
								      	<a href="hostPanel.php?Inizia=<?php echo $p[1]; ?>"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?Cancella=<?php echo $p[1]; ?>"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
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
								      <th>Ospite</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Guadagno</th>
								      <th>Finito</th>
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
								      <td><?php echo $p[9]; ?>€</td>
								    	<td>
								      	<a href="hostPanel.php?Concludi=<?php echo $p[1]; ?>"><span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i></span></a>
								      	<a href="hostPanel.php?Cancella=<?php echo $p[1]; ?>"><span class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a>
								      </td>
								    </tr>
								    <?php } } ?>
								  </tbody>
								</table>
					  	</div>
					  </div>
			  	</div>

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
								      <th>Ospite</th>
								      <th>Check-in</th>
								      <th>Check-out</th>
								      <th>#Ospiti</th>
								      <th>Guadagno</th>
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
								      <td><?php echo $p[9]; ?>€</td>
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
								      <th>Ospite</th>
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
								      <th>Ospite</th>
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
								      <th>Ospite</th>
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