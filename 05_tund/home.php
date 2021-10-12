<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page2.php");
	}
	
	if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page2.php");
}

	// * Muutsin ajavööndit.
	date_default_timezone_set('Europe/Tallinn');
	$author_name = $_SESSION["user_firstname"]. " " . $_SESSION["user_lastname"];
	
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?></title>
</head>
<body>
	<img src="TLU.jpg" alt="Tallinna Ülikooli Mare hoone" width="600">
	<h1><?php echo $author_name; ?></h1>
	<p>Tegin selle muutuse</p>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Olemegi sisse loginud</p>
	<p><a href="?logout=1">Logi välja</a></p>
	

</body>
</html>