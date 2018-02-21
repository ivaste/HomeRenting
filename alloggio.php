<?php include("header.php"); 

///////////////////SPOSTARE REVIEW IN review.php

$id=$_GET['id'];

// Op.49. - Inserire una Prenotazione
try{
	/*if(!isset($_COOKIE["idUtente"])) echo "non settato";
	else echo $_COOKIE["idUtente"];*/
	$idOspite=$_COOKIE["idUtente"];
	$nOspiti=$_POST["nOspiti"];
	/*echo $idOspite."<br>";
	echo $alloggio[8]."<br>";
	echo $id."<br>";
	echo date('Y-m-d',strtotime($_POST["dataCheckIn"]))."<br>";
	echo date('Y-m-d',strtotime($_POST["dataCheckOut"]))."<br>";
	echo ($alloggio[3]*$_POST["nOspiti"]*(strtotime($_POST["dataCheckOut"])-strtotime($_POST["dataCheckIn"]))/86400)."<br>";
	echo $nOspiti."<br>";
	echo date('Y-m-d')."<br>";*/

	if(isset($_COOKIE["idUtente"]) && isset($_POST["dataCheckIn"]) && isset($_POST["dataCheckOut"]) && isset($_POST["nOspiti"])){
		$ci=date('Y-m-d',strtotime($_POST["dataCheckIn"]));
		$co=date('Y-m-d',strtotime($_POST["dataCheckOut"]));
		$prz=$alloggio[3]*$_POST["nOspiti"]*(strtotime($_POST["dataCheckOut"])-strtotime($_POST["dataCheckIn"]))/86400;
		$oggi=date('Y-m-d');
		$sql=$db->prepare("
					INSERT INTO prenotazione
					(ospite, host, alloggio, datacheckin, datacheckout, prezzo, nposti, stato, datarichiesta)
					VALUES ($idOspite, $alloggio[8], $id, '$ci', '$co', $prz, $nOspiti, 'Sospeso', '$oggi');");
		$sql->execute();
	}

} catch (PDOException $e){
	echo $e->getMessage();
}


// Op.30. - Lista delle Foto dell’Alloggio di id=1234
	$sql="SELECT DISTINCT id, link
				FROM foto
				WHERE alloggio=$id;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$foto=array();
	while($row=$q->fetch()){
		$foto[]=$row;
	}

// Op.28. Dati principali dell’alloggio
	$sql="SELECT DISTINCT id, nome, tipoalloggio, prezzoxnotte, nposti, citta, via, descrizione, proprietario
				FROM alloggio
				WHERE id=$id;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$alloggio=array();
	while($row=$q->fetch()){
		$alloggio=$row;
	}

// Op.29. Lista dei servizi dell’alloggio
	$sql="SELECT DISTINCT servizio
				FROM dotato
				WHERE alloggio=$id;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$servizi=array();
	while($row=$q->fetch()){
		$servizi[]=$row;
	}

	// NOme utente e foto proprietario
	$sql="SELECT DISTINCT nome, fotoprofilo
				FROM utente
				WHERE id=$alloggio[8];";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$nome=array();
	while($row=$q->fetch()){
		$nome=$row;
	}


// Op.44. Lista delle Recensioni fatte dagli Ospiti sull’Alloggio di id=1234
	//DA SPOSTARE IN REVIEW
	$sql="SELECT DISTINCT u.id, u.nome, u.fotoprofilo, p.datarecensionealloggio, p.testorecensionealloggio, p.votorecensionealloggio
				FROM prenotazione AS p
				INNER JOIN utente AS u
					ON p.ospite=u.id
				WHERE p.alloggio=$id AND p.datarecensionealloggio IS NOT NULL;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$recensioni=array();
	while($row=$q->fetch()){
		$recensioni[]=$row;
	}

// Op.47. - Media delle valutazioni dell’Alloggio di id=1234
	$sql="SELECT DISTINCT AVG(votorecensionealloggio), COUNT(votorecensionealloggio)
				FROM prenotazione
				WHERE alloggio=$id
				GROUP BY alloggio;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$valutazioni=array();
	while($row=$q->fetch()){
		$valutazioni=$row;
	}

// Op.48. - Lista delle date in cui l’Alloggio di id=1234 non può essere prenotato
	$sql="SELECT DISTINCT datacheckin, datacheckout
				FROM prenotazione
				WHERE alloggio=$id AND (stato='Accettata' OR stato='In Corso');";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$dateOccupato=array();
	while($row=$q->fetch()){
		$dateOccupato[]=$row;
	}





?>

<div class="row justify-content-center">
	<div id="carouselExampleIndicators" class="carousel slide" style="width:100%;" data-ride="carousel">
	  <ol class="carousel-indicators">
	  <?php foreach ($foto as $i => $f) { ?>
	    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i;?>" class="<?php if($i==0) echo "active"; ?>"></li>
	  <?php } ?>
	  </ol>
	  
	  <div class="carousel-inner" role="listbox">
	  <?php foreach ($foto as $i => $f) { ?>
	    <div class="carousel-item <?php if($i==0) echo "active"; ?>" style="height:400px;">
	      <img class="d-block img-fluid" src="<?php echo $f[1]; ?>" style="width:100%; height:100%; object-fit: cover !important; object-position:center !important;" alt="First slide">
	    </div>
	  <?php } ?>
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

<div class="conteiner mt-3">
	<div class="row justify-content-center">

		<div class="col-sm-5">
			<div class="row justify-content-between">
				<div class="col-sm-auto" >
					<h2><?php echo $alloggio[1]; ?></h2>
					<p class="text-muted"><?php echo $alloggio[2]; ?> · 
						<i class="fa fa-home" aria-hidden="true"></i> <?php echo $alloggio[5]; ?> ·
						<i class="fa fa-users" aria-hidden="true"></i> <?php echo $alloggio[4]; ?> Ospiti
					</p>
				</div>
				<div class="col-sm-auto">
					<div class="row">
						<a class="mx-auto" href="viewProfile.php?id=<?php echo $alloggio[8]; ?>"><img src="<?php echo $nome[1]; ?>" class="rounded-circle mx-auto" width="50" height="50" /></a>
					</div>
					<div class="row">
						<a class="mx-auto text-muted" href="viewProfile.php?id=<?php echo $alloggio[8]; ?>"><?php echo $nome[0]; ?></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p><?php echo $alloggio[7]; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<h4>Servizi</h4>
					<p><?php foreach($servizi as $s) echo ' · '.$s[0].'<br>';?></p>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h4><?php echo $valutazioni[1]; ?> Recensioni 
						
			    	<?php $stelle=round($valutazioni[0]/2,1);
							for ($i=0; $i < floor($stelle); $i++) { ?>
								<i class="fa fa-star text-warning" aria-hidden="true"></i>
							<?php }
							if($stelle-ceil($stelle)!=0) { ?>							
				    	<i class="fa fa-star-half-o text-warning" aria-hidden="true"></i>
				    	<?php }
				    	for ($i=0; $i < 5-ceil($stelle); $i++) { ?>
				    	<i class="fa fa-star-o text-warning" aria-hidden="true"></i>
				    	<?php } ?>

			    	<?php echo round($valutazioni[0]/2,1); ?>
					</h4>
					
					<!-- RECENSIONI -->
				<?php foreach($recensioni as $r){ ?>
					<div class="row align-items-center">
						<!-- FotoPorfilo + Nome -->
						<div class="col-sm-2">
							<div class="row">
								<a class="mx-auto" href="viewProfile.php?id=<?php echo $r[0]; ?>"><img src="<?php echo $r[2]; ?>" class="rounded-circle mx-auto" width="50" height="50" /></a>
							</div>
							<div class="row">
								<a class="mx-auto text-muted" href="viewProfile.php?id=<?php echo $r[0]; ?>"><?php echo $r[1]; ?></a>
							</div>
						</div>
						<!-- Commento-->
						<div class="col ">
								<p class="mb-0"><?php echo $r[4]; ?></p>
						</div>
					</div>
					<!-- Data + Voto -->
					<div class="row">
						<div class="col-12 col-sm-3">
							<?php $stelle=$r[5]/2;
							for ($i=0; $i < floor($stelle); $i++) { ?>
								<i class="fa fa-star text-warning" aria-hidden="true"></i>
							<?php }
							if($stelle-ceil($stelle)!=0) { ?>							
				    	<i class="fa fa-star-half-o text-warning" aria-hidden="true"></i>
				    	<?php }
				    	for ($i=0; $i < 5-ceil($stelle); $i++) { ?>
				    	<i class="fa fa-star-o text-warning" aria-hidden="true"></i>
				    	<?php } ?>
						</div>
						<div class="col-6 col-sm-3">
								<p class="form-text text-muted mt-0 text-left"><?php echo date('F Y',strtotime($r[3])); ?></p>
						</div>
					</div>
				<?php } ?>

				</div>
			</div>

		</div>

		<!-- PRENOTA -->
		<div class="col-sm-auto">
			<div class="card">
				<h3 class="card-header"><?php echo ceil($alloggio[3]); ?>€ <small><strong>per notte</strong></small></h3>
				<div class="card-block">

					<form action="alloggio.php?id=<?php echo $id; ?>" method="post">
				  	<div class="col-auto">
				    Check-in: <input name="dataCheckIn" id="checkIn" width="276" /><br>
	        	Check-out: <input name="dataCheckOut" id="checkOut" width="276" /><br>
		        <script>
			        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
			        $('#checkIn').datepicker({
			            minDate: today,
			            disableDates: [new Date(2018,2,2), new Date(2018,2,3)],
			            maxDate: function () {
			                return $('#checkOut').val();
			            }
			        });
			        $('#checkOut').datepicker({
			            disableDates: [new Date(2018,2,2), new Date(2018,2,3)],
			            minDate: function () {
			                return $('#checkIn').val();
			            }
			        });
			      </script>
			      Ospiti: <input type="text" name="nOspiti" value="1"><br>
			      
				    <strong>Date non disponibili:</strong>
				    <p class="card-text"><?php foreach($dateOccupato as $d) echo 'Dal '.$d[0].' al '.$d[1].'<br>' ?>
				    	<?php if(count($dateOccupato)==0) echo'Sempre disponibile!';?>
				    </p>
				    <?php if(isset($_COOKIE["idUtente"]) && !($idOspite==$alloggio[8])) { ?>
				    <button type="submit" class="btn-lg btn-primary" style="width:100%;">Prenota</button>
				    <?php } ?>
				    <br><small class="text-muted">Non riceverai alcun addebito in questa fase</small>

				  	</div>
				  </form>

			  </div>
			</div>
		</div>

	</div>
</div>




<?php include("footer.php"); ?>