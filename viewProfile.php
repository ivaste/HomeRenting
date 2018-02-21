<?php include("header.php"); ?>

<?php
$id=$_GET['id'];
  if(isset($_GET['id'])){
    // Op.37 - Dati principali dell’Utente di id=1234
    $sql="SELECT DISTINCT id, email, password, nome, cognome, ntelefono, datanascita, sesso, descrizione, fotoprofilo
          FROM utente
          WHERE id=$id;";
    $q=$db->query($sql);
    $q->setFetchMode(PDO::FETCH_BOTH);

    $dati=array();
    while($row=$q->fetch()){
      $dati=$row;
    }

    // Op.38 - Lista delle Lingue parlate dall’Utente di id=1234
    $sql="SELECT DISTINCT lingua
          FROM parla
          WHERE utente=$id;";
      $q=$db->query($sql);
      $q->setFetchMode(PDO::FETCH_BOTH);

      $lingue=array();
      while($row=$q->fetch()){
        $lingue[]=$row;
      }

    // Op.42 - Lista delle Recensioni ricevute (come Host)
    $sql="SELECT DISTINCT prenotazione.ospite, utente.fotoprofilo, utente.nome, prenotazione.alloggio, alloggio.nome, prenotazione.datarecensionealloggio, prenotazione.votorecensionealloggio, prenotazione.testorecensionealloggio
          FROM prenotazione
          INNER JOIN utente
            ON prenotazione.ospite=utente.id
          INNER JOIN alloggio
            ON prenotazione.alloggio=alloggio.id
          WHERE prenotazione.host=$id AND datarecensionealloggio IS NOT NULL;";
    $q=$db->query($sql);
    $q->setFetchMode(PDO::FETCH_BOTH);

    $recensioniH=array();
    while($row=$q->fetch()){
      $recensioniH[]=$row;
    }

    // Media recensioni ospiti
    $sql="SELECT DISTINCT AVG(votorecensionealloggio), COUNT(votorecensionealloggio)
          FROM prenotazione
          WHERE host=$id
          GROUP BY host;";
    $q=$db->query($sql);
    $q->setFetchMode(PDO::FETCH_BOTH);

    $mediaH=array();
    while($row=$q->fetch()){
      $mediaH=$row;
    }
    



    // OP.43 - Lista delle Recensioni ricevute (come Ospite)
    $sql="SELECT DISTINCT prenotazione.host, utente.fotoprofilo, utente.nome, prenotazione.alloggio, alloggio.nome, prenotazione.datavalutaospite, prenotazione.votovalutaospite, prenotazione.testovalutaospite
          FROM prenotazione
          INNER JOIN utente
            ON prenotazione.host=utente.id
          INNER JOIN alloggio
            ON prenotazione.alloggio=alloggio.id
          WHERE prenotazione.ospite=$id AND datavalutaospite IS NOT NULL;";
    $q=$db->query($sql);
    $q->setFetchMode(PDO::FETCH_BOTH);

    $recensioniO=array();
    while($row=$q->fetch()){
      $recensioniO[]=$row;
    }

    // Media recensioni ospiti
    $sql="SELECT DISTINCT AVG(votovalutaospite), COUNT(votovalutaospite)
          FROM prenotazione
          WHERE ospite=$id
          GROUP BY ospite;";
    $q=$db->query($sql);
    $q->setFetchMode(PDO::FETCH_BOTH);

    $mediaO=array();
    while($row=$q->fetch()){
      $mediaO=$row;
    }

  }

?>

<div class="container-fluid mt-3">
  <!--Foto profilo, informazioni -->
  <div class="row justify-content-center">
    <div class="col-sm-4 col-md-3 col-xl-2">
    	<div class="card">
				<img class="card-img-top" src="<?php echo $dati[9]; ?>">
			  <div class="card-header">Informazioni</div>
			  <div class="card-block">
			  		
			    <strong>Lingue parlate:</strong>
			    <p class="card-text"><?php foreach ($lingue as $l) echo $l[0]."<br>"; ?></p>
			  </div>
			</div>
    </div>

    <!--Descrizione, recensioni -->
    <div class="col-sm-12 col-md-8 col-lg-6">
    	<h1>Ciao, sono <?php echo $dati[3]; ?></h1>
    	<!--<strong>Membro dal MESE ANNO</strong>-->
    	<p><?php echo $dati[8]; ?></p>

    	<h4>Recensioni degli ospiti (<?php echo $mediaH[1]; ?>)
				
        <?php $stelle=round($mediaH[0]/2,1);
          for ($i=0; $i < floor($stelle); $i++) { ?>
            <i class="fa fa-star text-warning" aria-hidden="true"></i>
          <?php }
          if($stelle-ceil($stelle)!=0) { ?>             
          <i class="fa fa-star-half-o text-warning" aria-hidden="true"></i>
          <?php }
          for ($i=0; $i < 5-ceil($stelle); $i++) { ?>
          <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
          <?php } ?>

	    	<?php echo round($mediaH[0]/2,1); ?>
    	</h4>

      <?php foreach($recensioniH as $r){ ?>
          <div class="row align-items-center">
            <!-- FotoPorfilo + Nome -->
            <div class="col-sm-2">
              <div class="row">
                <a class="mx-auto" href="viewProfile.php?id=<?php echo $r[0]; ?>"><img src="<?php echo $r[1]; ?>" class="rounded-circle mx-auto" width="50" height="50" /></a>
              </div>
              <div class="row">
                <a class="mx-auto text-muted" href="viewProfile.php?id=<?php echo $r[0]; ?>"><?php echo $r[2]; ?></a>
              </div>
            </div>
            <!-- Commento-->
            <div class="col ">
                <p class="mb-0"><?php echo $r[7]; ?></p>
            </div>
          </div>
          <!-- Data + Voto -->
          <div class="row">
            <div class="col-12 col-sm-3">
              <?php $stelle=$r[6]/2;
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
              <p class="form-text text-muted mt-0 text-left"><?php echo date('F Y',strtotime($r[5])); ?></p>
            </div>
            <div class="col-6 col-sm-6">
              <a class="form-text text-muted mt-0 text-right" href="alloggio.php?id=<?php echo $r[3]; ?>"><?php echo $r[4]; ?></a>
            </div>
          </div>
        <?php } ?>

    	
    	<h4 class="mt-2">Recensioni degli host (<?php echo $mediaO[1]; ?>)
        
        <?php $stelle=round($mediaO[0]/2,1);
          for ($i=0; $i < floor($stelle); $i++) { ?>
            <i class="fa fa-star text-warning" aria-hidden="true"></i>
          <?php }
          if($stelle-ceil($stelle)!=0) { ?>             
          <i class="fa fa-star-half-o text-warning" aria-hidden="true"></i>
          <?php }
          for ($i=0; $i < 5-ceil($stelle); $i++) { ?>
          <i class="fa fa-star-o text-warning" aria-hidden="true"></i>
          <?php } ?>

        <?php echo round($mediaO[0]/2,1); ?>
    	</h4>

      <?php foreach($recensioniO as $r){ ?>
          <div class="row align-items-center">
            <!-- FotoPorfilo + Nome -->
            <div class="col-sm-2">
              <div class="row">
                <a class="mx-auto" href="viewProfile.php?id=<?php echo $r[0]; ?>"><img src="<?php echo $r[1]; ?>" class="rounded-circle mx-auto" width="50" height="50" /></a>
              </div>
              <div class="row">
                <a class="mx-auto text-muted" href="viewProfile.php?id=<?php echo $r[0]; ?>"><?php echo $r[2]; ?></a>
              </div>
            </div>
            <!-- Commento-->
            <div class="col ">
                <p class="mb-0"><?php echo $r[7]; ?></p>
            </div>
          </div>
          <!-- Data + Voto -->
          <div class="row">
            <div class="col-12 col-sm-3">
              <?php $stelle=$r[6]/2;
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
              <p class="form-text text-muted mt-0 text-left"><?php echo date('F Y',strtotime($r[5])); ?></p>
            </div>
            <div class="col-6 col-sm-6">
              <a class="form-text text-muted mt-0 text-right" href="alloggio.php?id=<?php echo $r[3]; ?>"><?php echo $r[4]; ?></a>
            </div>
          </div>
        <?php } ?>
    	
    </div>

  </div>
</div>






<?php include("footer.php"); ?>