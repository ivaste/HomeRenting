<?php

include("connetti.php");

if(isset($_GET['in'])){
	// ACCEDERE
// Op.51. - Id dell’Utente che ha una determinata email e password
	$em=$_POST["logInEmail"];
	$psw= $_POST["logInPassword"];
	if(isset($_POST["logInEmail"]) && isset($_POST["logInPassword"])){
		$sql="SELECT DISTINCT id
					FROM utente 
					WHERE email = '$em' AND password = '$psw';";
		$q=$db->query($sql);
		$q->setFetchMode(PDO::FETCH_BOTH);
		$utente=array();
		while($row=$q->fetch()){
			$utente=$row;
		}

		if(isset($utente[0])){
			setcookie("idUtente",$utente[0],time() + 600,"/");
			header("Location: index.php");
		}
		else echo "utente non trovato";

	}
}

include("footer.php");

?>