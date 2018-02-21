<?php include("header.php"); ?>

<?php
/////////////////////LINGUE PARLATE, PULSANTE SALVA, CARICA FOTO, RECENSIONI
	$id=$_COOKIE["idUtente"];

	if(isset($_COOKIE["idUtente"])){
		// OP.37 - Dati principali dell’Utente di id=1234
		$sql="SELECT DISTINCT id, email, password, nome, cognome, ntelefono, datanascita, sesso, descrizione, fotoprofilo
		      FROM utente
		      WHERE id=$id;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$dati=array();
		while($row=$q->fetch()){
		  $dati=$row;
		}

		// OP.38 - Lista delle Lingue parlate dall’Utente di id=1234
		$sql="SELECT DISTINCT lingua
		    FROM parla
		    WHERE utente=$id;";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);

		$lingue=array();
		while($row=$q->fetch()){
		  $lingue[]=$row;
		}

		// OP.39 - Aggiornare i dati dell’Utente di id=1234
		/*Per le lingue usare prima OP39, poi per ogni lingua parlata OP38*/

		// OP.40 - Aggiungere una Lingua parlata all’Utente di id=1234

		// OP.41 - Cancellare tutte le Lingue parlate dall’Utente di id=1234

		}

?>

<div class="container mt-3">
  <div class="row">
    <div class="col-sm-3">
    	<nav class="nav nav-tabs flex-sm-column nav-pills" role="tablist">
			  <a class="flex-sm-fill text-sm-center nav-link active" data-toggle="tab" href="#editProfile" role="tab">Modifica profilo</a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#recensioniRicevute" role="tab">Recensioni ricevute</a>
			  <a class="flex-sm-fill text-sm-center nav-link" data-toggle="tab" href="#recensioniScritte" role="tab">Recensioni scritte</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="viewProfile.php?id=<?php echo $id; ?>">Visualizza profilo</a>
			</nav>
    </div>

    <div class="col-sm-8" >
    	<!-- Tab panes -->
			<div class="tab-content">
			<!-- MODIFICA PROFILO -->
			  <div class="tab-pane active" id="editProfile" role="tabpanel">
			  	<h2>Modifica profilo <a href="#"><span class="badge badge-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salva</span></a></h2>
			  	<form>
			  		<div class="form-group row">
						  <label for="example-email-input" class="col-2 col-form-label">Email</label>
						  <div class="col-10">
						    <input class="form-control" type="email" value="<?php echo $dati[1]; ?>" id="example-email-input">
						  </div>
						</div>
						<div class="form-group row">
						  <label for="example-password-input" class="col-2 col-form-label">Password</label>
						  <div class="col-10">
						    <input class="form-control" type="password" value="<?php echo $dati[2]; ?>" id="example-password-input">
						  </div>
						</div>
						<div class="form-group row">
						  <label for="example-text-input" class="col-2 col-form-label">Nome</label>
						  <div class="col-10">
						    <input class="form-control" type="text" value="<?php echo $dati[3]; ?>" id="example-text-input">
						  </div>
						</div>
						<div class="form-group row">
						  <label for="example-text-input" class="col-2 col-form-label">Cognome</label>
						  <div class="col-10">
						    <input class="form-control" type="text" value="<?php echo $dati[4]; ?>" id="example-text-input">
						  </div>
						</div>
						<div class="form-group row">
						  <small class="form-text text-muted mt-0">Sul tuo profilo pubblico viene visualizzato solo il tuo nome. Quando invii una richiesta di prenotazione, il tuo host potrà vedere il tuo nome e cognome.</small>
						</div>
						<div class="form-group row">
						  <label for="example-tel-input" class="col-2 col-form-label">Telefono</label>
						  <div class="col-10">
						    <input class="form-control" type="tel" value="<?php echo $dati[5]; ?>" id="example-tel-input">
						  </div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-2 col-form-label">Data di nascita</label>
					  	<div class="form-group col-md-3">
						  	<select class="custom-select my-1 mr-sm-2" id="Giorno">
									<option value="0" selected>Giorno</option>
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
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
							</div>
							<div class="form-group col-md-4">
						  	<select class="custom-select my-1 mr-sm-2" id="Mese">
									<option value="0" selected>Mese</option>
									<option value="1">Gennaio</option>
									<option value="2">Febbraio</option>
									<option value="3">Marzo</option>
									<option value="4">Aprile</option>
									<option value="5">Maggio</option>
									<option value="6">Giugno</option>
									<option value="7">Luglio</option>
									<option value="8">Agosto</option>
									<option value="9">Settembre</option>
									<option value="10">Ottobre</option>
									<option value="11">Novembre</option>
									<option value="12">Dicembre</option>
								</select>
							</div>
							<div class="form-group col-md-3">
						  	<select class="custom-select my-1 mr-sm-2" id="Anno">
									<option value="0" selected>Anno</option>
									<option value="2000">2000</option>
									<option value="1999">1999</option>
									<option value="1998">1998</option>
									<option value="1997">1997</option>
									<option value="1996">1996</option>
									<option value="1995">1995</option>
									<option value="1994">1994</option>
									<option value="1993">1993</option>
									<option value="1992">1992</option>
									<option value="1991">1991</option>
									<option value="1990">1990</option>
									<option value="1989">1989</option>
									<option value="1988">1988</option>
									<option value="1987">1987</option>
									<option value="1986">1986</option>
									<option value="1985">1985</option>
									<option value="1984">1984</option>
									<option value="1983">1983</option>
									<option value="1982">1982</option>
									<option value="1981">1981</option>
									<option value="1980">1980</option>
									<option value="1979">1979</option>
									<option value="1978">1978</option>
									<option value="1977">1977</option>
									<option value="1976">1976</option>
									<option value="1975">1975</option>
									<option value="1974">1974</option>
									<option value="1973">1973</option>
									<option value="1972">1972</option>
									<option value="1971">1971</option>
									<option value="1970">1970</option>
									<option value="1969">1969</option>
									<option value="1968">1968</option>
									<option value="1967">1967</option>
									<option value="1966">1966</option>
									<option value="1965">1965</option>
									<option value="1964">1964</option>
									<option value="1963">1963</option>
									<option value="1962">1962</option>
									<option value="1961">1961</option>
									<option value="1960">1960</option>
									<option value="1959">1959</option>
									<option value="1958">1958</option>
									<option value="1957">1957</option>
									<option value="1956">1956</option>
									<option value="1955">1955</option>
									<option value="1954">1954</option>
									<option value="1953">1953</option>
									<option value="1952">1952</option>
									<option value="1951">1951</option>
									<option value="1950">1950</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-sm-2 col-form-label">Sesso</label>
						  <div class="col-sm-10">
						  	<div class="custom-control custom-radio custom-control-inline mx-auto">
								  <input type="radio" id="M2" name="Sesso2" class="custom-control-input" <?php if(!$dati[7]) echo "checked='checked'"; ?>>
								  <label class="custom-control-label" for="M2">Maschio</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline mx-auto">
								  <input type="radio" id="F2" name="Sesso2" class="custom-control-input" <?php if($dati[7]) echo "checked='checked'"; ?>>
								  <label class="custom-control-label" for="F2">Femmina</label>
								</div>
						  </div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-2 col-form-label">Descrizione</label>
						  <div class="col-sm-10">
						  	<textarea class="form-control" rows="3" id="textarea"><?php echo $dati[8]; ?></textarea>
						  </div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-2 col-form-label">Lingue parlate</label>
						  <div class="col-sm-10">
						  	Lista lingue,
						  	Bottone Aggiungi/togli che apre un modal con una checkbox list
						  </div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-2 col-form-label">Foto</label>
						  <div class="col-sm-10">
						  	<img src="<?php echo $dati[9]; ?>" width="150px" />
						  	<input type="file" name="fileToUpload" id="fileToUpload">
						  	<input class="form-control" name="fotoprofilo" type="text" value="<?php echo $dati[9]; ?>" id="example-text-input">
						  </div>
						</div>

			  	</form>
			  </div>

			  <div class="tab-pane" id="recensioniRicevute" role="tabpanel">
			  	<h2>Recensioni ricevute (numero)</h2>
			  	<?php include("review.php"); ?>
			  </div>
			  <div class="tab-pane" id="recensioniScritte" role="tabpanel">
			  <h2>Recensioni scritte (numero)</h2>
			  	<?php include("review.php"); ?>
			  </div>
			</div>
    </div>

  </div>
</div>



<?php include("footer.php"); ?>