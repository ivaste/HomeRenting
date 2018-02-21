

<?php

if(isset($_GET['out'])){
	//echo "out";
	setcookie("idUtente","",time() - 600);
	header("Location: index.php");
}




?>