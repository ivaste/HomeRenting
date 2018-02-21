<?php
include("connetti.php");

if(isset($_POST["regEmail"]) &&
	isset($_POST["regPass"]) &&
	isset($_POST["regNome"]) &&
	isset($_POST["regCognome"]) &&
	isset($_POST["regGiorno"]) &&
	isset($_POST["regMese"]) &&
	isset($_POST["regAnno"]) &&
	isset($_POST["Sesso"]) &&
	isset($_POST["regNtel"]) &&
	$_POST["regGiorno"]!=0 &&
	$_POST["regMese"]!=0 &&
	$_POST["regAnno"]!=0){


	//Op.50 - Inserire un Utente
	$email=$_POST["regEmail"];
	$pass=$_POST["regPass"];
	$nome=$_POST["regNome"];
	$cogn=$_POST["regCognome"];
	$nascita=$_POST["regAnno"]."-".$_POST["regMese"]."-".$_POST["regGiorno"];
	$sesso="TRUE";
	if($_POST["Sesso"]=="M") $sesso="FALSE";
	$tel=$_POST["regNtel"];
	$sql=$db->prepare("INSERT INTO utente
					(email, password, nome, cognome, datanascita, sesso, ntelefono)
					VALUES ('$email', '$pass', '$nome', '$cogn', '$nascita', $sesso, $tel);");
	$sql->execute();
		
	header("Location: index.php");

}





include("footer.php");


?>