<?php include("header.php"); ?>

<?php
	///////////////////////////////PULSANTE SALVA, CARICA FOTO, NUOVO ALLOGGIO
	if(isset($_GET["id"]) && isset($_COOKIE["idUtente"])){
		$idUtente=$_COOKIE["idUtente"];
		$idAlloggio=$_GET["id"];

		// Op.28 - Dati principali dell’Alloggio di id=1234
		$sql="SELECT DISTINCT id, nome, tipoalloggio, prezzoxnotte, nposti, citta, via, descrizione, proprietario
					FROM alloggio
					WHERE id=$idAlloggio;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$dati=array();
		while($row=$q->fetch()){
		  $dati=$row;
		}

		// Op.29 - Lista dei Servizi forniti dall’Alloggio di id=1234
		$sql="SELECT DISTINCT servizio
					FROM dotato
					WHERE alloggio=$idAlloggio;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$servizi=array();
		while($row=$q->fetch()){
		  $servizi[]=$row;
		}

		// Op.30 - Lista delle Foto dell’Alloggio di id=1234
		$sql="SELECT DISTINCT id, link
					FROM foto
					WHERE alloggio=$idAlloggio;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$foto=array();
		while($row=$q->fetch()){
		  $foto[]=$row;
		}

		// LIsta città
		$sql="SELECT DISTINCT nome
					FROM citta;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$citta=array();
		while($row=$q->fetch()){
		  $citta[]=$row;
		}
		// Lista tipialloggio
		$sql="SELECT DISTINCT nome
					FROM tipoalloggio;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$tipi=array();
		while($row=$q->fetch()){
		  $tipi[]=$row;
		}

		// LIsta servizi
		$sql="SELECT DISTINCT nome
					FROM servizio;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$serv=array();
		while($row=$q->fetch()){
		  $serv[]=$row;
		}

		// Op.31 - Inserire un nuovo Alloggio
		/*Per ogni servizio che si vuole mettere all'alloggio eseguire: OP33*/
		/*Per ogni foto che si vuole mettere all'alloggio eseguire: OP34*/
		
		// Op.32 - Aggiornare i dati dell’Alloggio di id=1234
		/*Per i servizi eseguire prima OP33 e poi per ogni servizio OP32 che si vuole mettere*/
		/*Per le foto eseguire prima OP35 e poi per ogni foto OP34 che si vuole mettere*/

		// Op.33 - Aggiungere un Servizio all’Alloggio di id=1234

		// Op.34 - Cancellare tutti i Servizi dell’Alloggio di id=1234

		// Op.35 - Aggiungere una Foto all’Alloggio di id=1234

		// Op.36 - Cancellare tutte le Foto dell’Alloggio di id=1234

	}


?>

<div class="conteiner-fluid mt-3">
	<div class="row justify-content-center">
		<div class="col-auto">
			<h2>Modifica/Aggiungi alloggio <a href="#"><span class="badge badge-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salva</span></a></h2>
		</div>
	</div>

	<div class="row justify-content-center">
		<div class="col-auto">
			<form>
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Nome</label>
				  <div class="col-10">
				    <input class="form-control" type="text" value="<?php echo $dati[1];?>" id="NomeAlloggio">
				  </div>
				</div>
				<div class="form-group row">
					<label for="example-text-input" class="col-2 col-form-label">Tipo</label>
			  	<div class="form-group col-md-3">
				  	<select class="custom-select my-1 mr-sm-2" id="Tipo">
							<?php foreach ($tipi as $t) { ?>
							<option value="<?php echo $t[0]; ?>" <?php if($t[0]==$dati[2]) echo "selected" ?>><?php echo $t[0]; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
				  <label for="example-tel-input" class="col-2 col-form-label">Prezzo per notte</label>
				  <div class="col-10">
				    <input class="form-control" type="number" value="<?php echo $dati[3];?>" id="Prezzonotte">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-tel-input" class="col-2 col-form-label">#Ospiti</label>
				  <div class="col-10">
				    <input class="form-control" type="number" value="<?php echo $dati[4];?>" id="nOspiti">
				  </div>
				</div>
				<div class="form-group row">
					<label for="example-text-input" class="col-2 col-form-label">Città</label>
			  	<div class="form-group col-md-3">
				  	<select class="custom-select my-1 mr-sm-2" id="Città">
							<?php foreach ($citta as $c) { ?>
							<option value="<?php echo $c[0]; ?>" <?php if($c[0]==$dati[5]) echo "selected" ?>><?php echo $c[0]; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Via</label>
				  <div class="col-10">
				    <input class="form-control" type="text" value="<?php echo $dati[6];?>" id="ViaAlloggio">
				  </div>
				</div>

				<div class="form-group row">
					<label for="example-text-input" class="col-2 col-form-label">Descrizione</label>
				  <div class="col-sm-10">
				  	<textarea class="form-control" rows="3" id="DescrizioneAlloggio"><?php echo $dati[7];?></textarea>
				  </div>
				</div>

				<div class="form-group row">
					<label for="example-text-input" class="col-2 col-form-label">Servizi</label>
				  <div class="col-sm-10">
				  	<?php foreach($serv as $s) { ?>
				  	<div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" id="<?php echo $s[0]; ?>" <?php 
						  foreach($servizi as $se) if($s[0]==$se[0]) echo "checked"; ?>>
						  <label name="servizi[]" value="<?php echo $s[0]; ?>" class="custom-control-label" for="<?php echo $s[0]; ?>"><?php echo $s[0]; ?></label>
						</div>
						<?php } ?>
				  </div>
				</div>

				<div class="form-group row">
					<label for="example-text-input" class="col-2 col-form-label">Foto</label>
				  <div class="col-sm-10">
				  	<?php foreach ($foto as $f) { ?>
				  	<img src="<?php echo $f[1];?>" width="150px" />
				  	<?php } ?>
				  	<input type="file" name="fileToUpload" id="fileToUpload">
				  </div>
				</div>

	  	</form>
		</div>
	</div>


</div>


<?php include("footer.php"); ?>