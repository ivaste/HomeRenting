<?php include("connetti.php"); ?>


<?php

if(isset($_COOKIE["idUtente"])){
	$hid=$_COOKIE["idUtente"];
// NOme utente e foto utente loggato
	$sql="SELECT DISTINCT nome, fotoprofilo
				FROM utente
				WHERE id=$hid;";
	$q=$db->query($sql);
	$q->setFetchMode(PDO::FETCH_BOTH);

	$Hnome=array();
	while($row=$q->fetch()){
		$Hnome=$row;
	}

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



?>

<!DOCTYPE html>
<html>
<head>
	<title>Home renting</title>	<!--Titolo-->
	<meta charset="UTF-8"/>				<!--Tipo codifica caratteri (serve per visualizzare lettere accentate)-->
	<meta name="viewport" content="width=device-width, initial-scale=1">	<!--Utilizzare la grandezza del dispositivo-->

	<!--Stili di bootstrap-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<!--Javascript necessario per far funzionare bootstrap-->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<!--Icone-->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<!--DatePicker  http://gijgo.com/datepicker/example/daterangepicker -->
	<script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.7.3/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.7.3/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />


</head>
<body>


<!-- NAVIGAZIONE -->
<form action="index.php" method="post">
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <a class="navbar-brand" href="index.php">HomeRenting</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<div  class="form-inline my-2 my-lg-0 w-100">
      <input name="Citta" class="form-control mr-sm-2 w-50" type="search" placeholder="Città" aria-label="Cerca">
      <button name="RicercaCitta" class="btn btn-outline-success my-2 my-sm-0" type="submit">Cerca</button>
    </div>
    
    <ul class="navbar-nav mr-auto">
    <!-- Accedi/Registrati, nascosti se l'utente è loggato -->
    	<?php if(!isset($_COOKIE["idUtente"])){ ?>
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#ModalRegistrati">Registrati</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#ModalAccedi">Accedi</a>
      </li>
      <?php } ?>
    <!-- Host/Viaggi, nascosti se l'utente non è loggato -->
    	<?php if(isset($_COOKIE["idUtente"])){ ?>
    	<li class="nav-item">
        <a class="nav-link" href="hostPanel.php">Host</a>
      </li>
      <li class="nav-item mr-2">
        <a class="nav-link" href="guestPanel.php">Viaggi</a>
      </li>
    <!-- Menu utente, nascosto se l'utente non è loggato -->
			<li class="nav-item">
				<div class="btn-group" role="group">
				  <a id="MenuUtente" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <img src="<?php echo $Hnome[1]; ?>" class="rounded-circle" width="30" />
				  </a>
				  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="MenuUtente">
				  	<h6 class="dropdown-header"><?php echo $Hnome[0]; ?></h6>
				    <a class="dropdown-item" href="editProfile.php">Modifica profilo</a>
				    <div class="dropdown-divider"></div>
				    <a class="dropdown-item" href="logOut.php?out=1">Esci</a>
				  </div>
				</div>
			</li>

      <?php } ?>

    </ul>
  </div>

</nav>



<!-- FILTRI -->
<div class="pos-f-t">
	<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="collapse" data-target="#e1" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      Filtri
    </button>
  </nav>
  <div class="collapse" id="e1" style="background-color: #e3f2fd;">
    <div class="container-fluid">
    	<div class="row align-items-middle">
	    	
	    	<!-- DATE -->
					<!-- <div class="col-sm">
						<h4>Date</h4>
						Check-in: <input id="startDate" width="276" />
	        	Check-out: <input id="endDate" width="276" />
		        <script>
			        /*var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
			        $('#startDate').datepicker({
			            minDate: today,
			            maxDate: function () {
			                return $('#endDate').val();
			            }
			        });
			        $('#endDate').datepicker({
			            minDate: function () {
			                return $('#startDate').val();
			            }
			        });*/
		    		</script>
					</div>-->

					<!-- N° OSPITI -->
					<div class="col-sm">
						<h4>Ospiti</h4>
						<div class="custom-control custom-radio">
						  <input value="1" type="radio" id="customRadio1" name="FnOspiti" class="custom-control-input">
						  <label class="custom-control-label" for="customRadio1">1</label>
						</div>
						<div class="custom-control custom-radio">
						  <input value="2" type="radio" id="customRadio2" name="FnOspiti" class="custom-control-input" checked>
						  <label class="custom-control-label" for="customRadio2">2</label>
						</div>
						<div class="custom-control custom-radio">
						  <input value="3" type="radio" id="customRadio3" name="FnOspiti" class="custom-control-input">
						  <label class="custom-control-label" for="customRadio3">3</label>
						</div>
						<div class="custom-control custom-radio">
						  <input value="4" type="radio" id="customRadio4" name="FnOspiti" class="custom-control-input">
						  <label class="custom-control-label" for="customRadio4">4</label>
						</div>
						<div class="custom-control custom-radio">
						  <input value="5" type="radio" id="customRadio5" name="FnOspiti" class="custom-control-input">
						  <label class="custom-control-label" for="customRadio5">5 o più</label>
						</div>
					</div>

				<!-- SERVIZI -->
					<div class="col-sm">
						<h4>Servizi</h4>
						<?php foreach($serv as $s) { ?>
						<div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" id="<?php echo $s[0]; ?>">
						  <label name="servizi[]" value="<?php echo $s[0]; ?>" class="custom-control-label" for="<?php echo $s[0]; ?>"><?php echo $s[0]; ?></label>
						</div>
						<?php } ?>
					</div>


				<!-- TIPO ALLOGGIO -->
					<div class="col-sm">
						<h4>Tipo di Alloggio</h4>

						<?php foreach($tipi as $i => $t) { ?>
						<div class="custom-control custom-radio">
						  <input value="<?php echo $t[0]; ?>" type="radio" id="cr<?php echo $i;?>" name="filtroTipo" class="custom-control-input">
						  <label class="custom-control-label" for="cr<?php echo $i;?>"><?php echo $t[0]; ?></label>
						</div>
						<?php } ?>
					</div>
					<div class="col-sm">
						<button name="filtro" class="btn btn-outline-success my-2 my-sm-0" type="submit">Applica filtri</button>
					</div>
    	</div>	
    </div>
  </div>
</div>
</form>






<!-- ACCEDI -->
<div class="modal fade" id="ModalAccedi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Accedi per proseguire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	      <form action="log.php?in=1" method="post">
					<div class="form-group">
				    <label for="exampleInputEmail1">Email address</label>
				    <input type="email" name="logInEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email@example.com">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" name="logInPassword" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>
				  <hr/>
					<button type="submit" class="btn-lg btn-primary" style="width:100%;">Accedi</button>
				</form>
				
      </div>
      <div class="modal-footer">
        <p class="mx-auto">Non hai un account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#ModalRegistrati">Registrati</a>
      </div>
    </div>
  </div>
</div>



<!-- REGISTRARSI -->
<div class="modal fade" id="ModalRegistrati" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registrati per proseguire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	      
				<form action="reg.php" method="post">
				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputEmail">Email</label>
				      <input type="email" name="regEmail" class="form-control" id="inputEmail" placeholder="email@example.com">
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPassword">Password</label>
				      <input type="password" name="regPass" class="form-control" id="inputPassword" placeholder="Password">
				    </div>
				  </div>
				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputNome">Nome</label>
				      <input type="text" name="regNome" class="form-control" id="inputNome" placeholder="Nome">
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputCognome">Cognome</label>
				      <input type="text" name="regCognome" class="form-control" id="inputCognome" placeholder="Cognome">
				    </div>
				  </div>
				  <label class="mb-0">Data di nascita</label>
				  <small class="form-text text-muted mt-0">Per registrarti devi aver compiuto almeno 18 anni. La data del tuo compleanno non sarà visibile per altre persone.</small>
				  <div class="form-row">
				  	<div class="form-group col-md-4">
					  	<select name="regGiorno" class="custom-select my-1 mr-sm-2" id="Giorno">
								<option value="0" selected>Giorno</option>
								<option value="01">1</option>
								<option value="02">2</option>
								<option value="03">3</option>
								<option value="04">4</option>
								<option value="05">5</option>
								<option value="06">6</option>
								<option value="07">7</option>
								<option value="08">8</option>
								<option value="09">9</option>
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
					  	<select name="regMese" class="custom-select my-1 mr-sm-2" id="Mese">
								<option value="0" selected>Mese</option>
								<option value="01">Gennaio</option>
								<option value="02">Febbraio</option>
								<option value="03">Marzo</option>
								<option value="04">Aprile</option>
								<option value="05">Maggio</option>
								<option value="06">Giugno</option>
								<option value="07">Luglio</option>
								<option value="08">Agosto</option>
								<option value="09">Settembre</option>
								<option value="10">Ottobre</option>
								<option value="11">Novembre</option>
								<option value="12">Dicembre</option>
							</select>
						</div>
						<div class="form-group col-md-4">
					  	<select name="regAnno" class="custom-select my-1 mr-sm-2" id="Anno">
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

				  <div class="form-row">
				  	<label>Sesso:</label>
					  <div class="custom-control custom-radio custom-control-inline mx-auto">
						  <input type="radio" id="M" name="Sesso" value="M" class="custom-control-input">
						  <label class="custom-control-label" for="M">Maschio</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline mx-auto">
						  <input type="radio" id="F" name="Sesso" value="F" class="custom-control-input">
						  <label class="custom-control-label" for="F">Femmina</label>
						</div>
					</div>

				  <div class="form-group">
				    <label for="inputNumero">Numero di telefono</label>
				    <input type="text" name="regNtel" class="form-control" id="inputNumero" placeholder="">
				  </div>
				  
				  <hr/>
					<button type="submit" class="btn-lg btn-primary" style="width:100%;">Registrati</button>
				</form>
				
      </div>
      <div class="modal-footer">
        <p class="mx-auto">Hai già un account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#ModalAccedi">Accedi</a>
      </div>
    </div>
  </div>
</div>



