<?php
	//print_r(PDO::getAvailableDrivers());
	
	$dbname='provahr';	//ivancichst
	$username='postgres';	//webdb
	$password='1111';		//webdb


// Connessione al database
	//Nuova istanza della classe PDO
	$db=new PDO("pgsql:dbname=$dbname",$username,$password);

	//Se ci sono errori li scrive
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connessione col DB OK";



	?>