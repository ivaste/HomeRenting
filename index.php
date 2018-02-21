<?php include("header.php"); ?>


<?php
	//////////////////////RICERCA CON FILTRO

	
	if(!isset($_POST["Citta"])&& !isset($_POST["RicercaCitta"])){
		// Op. 52 - Lista dei 20 Alloggi (non Archiviati) che hanno la media delle recensioni più alta
		$sql="SELECT DISTINCT p.alloggio, AVG(p.votorecensionealloggio) AS mediavoti, COUNT(p.votorecensionealloggio), a.nome, a.tipoalloggio, a.nposti, a.prezzoxnotte
					FROM prenotazione AS p
					RIGHT JOIN alloggio AS a
						ON p.alloggio=a.id
					WHERE a.archiviato = FALSE
					GROUP BY p.alloggio, a.nome, a.tipoalloggio, a.nposti, a.prezzoxnotte
					ORDER BY mediavoti DESC
					LIMIT 20;";
			$q=$db->query($sql);
			$q->setFetchMode(PDO::FETCH_BOTH);

			$alloggi=array();
			while($row=$q->fetch()){
				$alloggi[]=$row;
			}
	}
	if(isset($_POST["Citta"]) && isset($_POST["RicercaCitta"])){
		$citta=$_POST["Citta"];
		// Op. 53 - Lista dei 20 Alloggi (non Archiviati) di una determinata Città in ordine di media delle recensioni decrescente
		$sql="SELECT DISTINCT p.alloggio, AVG(p.votorecensionealloggio) AS mediavoti, COUNT(p.votorecensionealloggio), a.nome, a.tipoalloggio, a.nposti, a.prezzoxnotte
					FROM prenotazione AS p
					RIGHT JOIN alloggio AS a
						ON p.alloggio=a.id
					WHERE a.archiviato = FALSE AND a.citta='$citta'
					GROUP BY p.alloggio, a.nome, a.tipoalloggio, a.nposti, a.prezzoxnotte
					ORDER BY mediavoti DESC
					LIMIT 20;";
			$q=$db->query($sql);
			$q->setFetchMode(PDO::FETCH_BOTH);

			$alloggi=array();
			while($row=$q->fetch()){
				$alloggi[]=$row;
			}
	}


	if(isset($_POST["filtro"])
		&& isset($_POST["Citta"])
		&& isset($_POST["FnOspiti"])){
		$citta=$_POST["Citta"];
		$filtroNospiti=$_POST["FnOspiti"];
		$filtroServizi=$_POST["servizi[]"];
		$filtroTipo=$_POST["filtroTipo"];
		// Op. 54 -  filtri
		$sql="SELECT DISTINCT p.alloggio, AVG(p.votorecensionealloggio) AS mediavoti, COUNT(p.votorecensionealloggio), a.nome, a.tipoalloggio, a.nposti, a.prezzoxnotte
					FROM prenotazione AS p
					RIGHT JOIN alloggio AS a
						ON p.alloggio=a.id
					INNER JOIN dotato ON a.id = dotato.alloggio
					WHERE a.archiviato = FALSE AND a.citta='$citta' AND a.nposti>=$filtroNospiti";
		if(!empty($_POST["filtroTipo"])) $sql.=" AND a.tipoalloggio = '$filtroTipo'";
		if(!empty($_POST["servizi[]"])){
			foreach ($_POST["servizi[]"] as $s) {
				$sql .= " AND dotato.servizio = '$s'";
			}
		}
		$sql .=" GROUP BY p.alloggio, a.nome, a.tipoalloggio, a.nposti, a.prezzoxnotte
					ORDER BY mediavoti DESC
					LIMIT 20;";
		
			$q=$db->query($sql);
			$q->setFetchMode(PDO::FETCH_BOTH);

			$alloggi=array();
			while($row=$q->fetch()){
				$alloggi[]=$row;
			}


	}
if(empty($alloggi)) echo "Nessun risultato trovato";


	// foto
	$sql="SELECT DISTINCT alloggio, link
				FROM foto;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$foto=array();
	while($row=$q->fetch()){
		$foto[]=$row;
	}



?>

<!--- RIULTATO DELLA RICERCA -->
<div class="container mt-3">
  <div class="row align-items-center">
		
		<?php foreach ($alloggi as $a) { ?>
		<div class="col-sm-6 col-lg-4">
			<div class="card m-2" style="
		    max-width: 300px;
		    height: auto !important;">
			  <a href="alloggio.php?id=<?php echo $a[0]; ?>"><img class="card-img-top" src="
			  	<?php 
			  		foreach($foto as $f){
			  			if($f[0]==$a[0]){
			  				echo $f[1];
			  				break;
			  			}
			  		}
			  	?>

			  	" alt="Card image cap"></a>
			  <div class="card-body">
			  	<h6 class="card-subtitle text-muted"><?php echo $a[4]; ?> · <?php echo $a[5]; ?> Letti</h6>
			  	<h5 class="card-title mb-0"><a href="alloggio.php?id=<?php echo $a[0]; ?>"><?php echo $a[3]; ?></a></h5>
		    	<h7 class="card-subtitle text-muted">Da <?php echo ceil($a[6]); ?>€ per notte</h7>
			    <h6 class="card-subtitle text-muted">

			    	<?php $stelle=$a[1]/2;
            for ($i=0; $i < floor($stelle); $i++) { ?>
              <i class="fa fa-star text-warning" aria-hidden="true"></i>
            <?php }
            if($stelle-ceil($stelle)!=0) { ?>             
            <i class="fa fa-star-half-o text-warning" aria-hidden="true"></i>
            <?php }
            for ($i=0; $i < 5-ceil($stelle); $i++) { ?>
            <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
            <?php } ?>

			    	<?php echo $a[2]; ?>
			    </h6>
			  </div>
			</div>
		</div>
		<?php } ?>

	</div>
</div>





<?php include("footer.php"); ?>



