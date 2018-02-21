<?php
// Op.42...........

// Op.43................

// Op.44. Lista delle Recensioni fatte dagli Ospiti sull’Alloggio di id=1234
	if(isset($_GET['alloggio'])){
		$sql="SELECT DISTINCT u.id, u.nome, u.fotoprofilo, p.datarecensionealloggio, p.testorecensionealloggio, p.votorecensionealloggio
					FROM prenotazione AS p
					INNER JOIN utente AS u
						ON p.ospite=u.id
					WHERE p.alloggio=$_GET['alloggio'] AND p.datarecensionealloggio IS NOT NULL;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$recensioni=array();
		while($row=$q->fetch()){
			$recensioni[]=$row;
		}
	}

?>

<!--- SINGOLA RECENSIONE -->

<div class="row align-items-center">
	<!-- FotoPorfilo + Nome -->
	<div class="col-sm-2">
		<div class="row">
			<a class="mx-auto" href="viewProfile.php"><img src="utente.png" class="rounded-circle mx-auto" width="50" height="50" /></a>
		</div>
		<div class="row">
			<a class="mx-auto text-muted" href="viewProfile.php">NomeUtente</a>
		</div>
	</div>
	<!-- Commento-->
	<div class="col ">
			<p class="mb-0">Max's place is a very good base for a quick stop-over in Milan. Most importantly, communication was tip top all the way through, if you are anything like me and reliability and organization is top of the agenda, you'll understand why I recommend it!</p>
	</div>
</div>
<!-- Data + Voto -->
<div class="row">
	<div class="col-12 col-sm-3">
			<i class="fa fa-star text-warning" aria-hidden="true"></i>
    	<i class="fa fa-star text-warning" aria-hidden="true"></i>
    	<i class="fa fa-star text-warning" aria-hidden="true"></i>
    	<i class="fa fa-star-half-o text-warning" aria-hidden="true"></i>
    	<i class="fa fa-star-o text-warning" aria-hidden="true"></i>
	</div>
	<div class="col-6 col-sm-3">
			<p class="form-text text-muted mt-0 text-left">Mese Anno</p>
	</div>
	<div class="col-6 col-sm-6">
			<a class="form-text text-muted mt-0 text-right" href="alloggio.php">NomeAlloggio</a>
	</div>
</div>




