<?php

	// * Muutsin ajavööndit.
	date_default_timezone_set('Europe/Tallinn');
	$author_name = "Taavi Kamarik";
	$film_html = null;
	
	require_once("../../../config.php");
	require_once("fnc_films.php");
	$film_html = read_all_films();
	
	
	//echo $server_host;
	
	
	//paneme andmed meile sobivasse vormi
	
	
	
	

	
	
	

	
	
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?></title>
</head>
<body>
	<h1><?php echo $author_name; ?></h1>
	<p>Tegin selle muutuse</p>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $film_html ?>
	
	
	
	
</body>
</html>