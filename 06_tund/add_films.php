<?php

	date_default_timezone_set('Europe/Tallinn');
	$author_name = "Taavi Kamarik";
	$film_name = null;
	$film_year = date("Y");
	$film_duration = 60;
	$film_genre = null;
	$film_studio = null;
	$film_director = null;
	
	$name_missing = null;
	$year_missing = null;
	$duration_missing = null;
	$genre_missing = null;
	$studio_missing = null;
	$director_missing = null;
	
	
	
	
	require_once("../../../config.php");
	require_once("fnc_films.php");
	
	$film_store_notice = null;
	if(isset($_POST["film_submit"])){
		if(!empty($_POST["title_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"]) ){
			$film_store_notice = store_film($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"]);
		} else {
			$film_store_notice = "Osa andmeid on puudu.";
		}
	}
	

	if(isset($_POST["film_submit"])){
		
		
		if(!$_POST["title_input"]){
			$name_missing = "Filmi nimi puudu";
		}else{
			$film_name = filter_var($_POST["title_input"],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			//$film_name = $_POST["title_input"];
		}
		if(!$_POST["year_input"]){
			$year_missing = "Filmi aasta puudu";
		}else{
			$film_year = filter_var($_POST["year_input"], FILTER_VALIDATE_INT );
			//$film_year = $_POST["year_input"];
		}
		if(!$_POST["duration_input"]){
			$duration_missing = "Filmi kestvus puudu";
		}else{
			$film_duration = filter_var($_POST["duration_input"], FILTER_VALIDATE_INT);
			//$film_duration = $_POST["duration_input"];
		}
		if(!$_POST["genre_input"]){
			$genre_missing = "Filmi žanr puudu";
		}else{
			$film_genre = filter_var($_POST["film_genre"], FILTER_SANITIZE_SPECIAL_CHARS);
			//$film_genre = $_POST["genre_input"];
		}
		if(!$_POST["studio_input"]){
			$studio_missing = "Filmi tootja puudu";
		}else{
			$film_studio = filter_var($_POST["film_studio"], FILTER_SANITIZE_SPECIAL_CHARS);
			//$film_studio = $_POST["studio_input"];
		}
		if(!$_POST["director_input"]){
			$director_missing = "Filmi režissöör puudu";
		}else{
			$film_director = filter_var($_POST["film_director"], FILTER_SANITIZE_SPECIAL_CHARS);
			//$film_director = $_POST["director_input"];
		}
		
		
	}
	
	
	

	
	
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
	<h2>Eesti filmide lisamine</h2>
	    <form method="POST">
        <label for="title_input">Filmi pealkiri</label>
        <input type="text" name="title_input" id="title_input" placeholder="filmi pealkiri" value = "<?php echo $film_name?>">
		<span><?php echo $name_missing; ?></span>
        <br>
        <label for="year_input">Valmimisaasta</label>
        <input type="number" name="year_input" id="year_input" min="1912" value="<?php echo $film_year;?>">
		<span><?php echo $year_missing; ?></span>
        <br>
        <label for="duration_input">Kestus</label>
        <input type="number" name="duration_input" id="duration_input" min="1" value="<?php echo $film_duration;?>" max="600">
		<span><?php echo $duration_missing; ?></span>
        <br>
        <label for="genre_input">Filmi žanr</label>
        <input type="text" name="genre_input" id="genre_input" placeholder="žanr" value ="<?php echo $film_genre?>" >
		<span><?php echo $genre_missing; ?></span>
        <br>
        <label for="studio_input">Filmi tootja</label>
        <input type="text" name="studio_input" id="studio_input" placeholder="filmi tootja" value = "<?php echo $film_studio?>">
		<span><?php echo $studio_missing; ?></span>
        <br>
        <label for="director_input">Filmi režissöör</label>
        <input type="text" name="director_input" id="director_input" placeholder="filmi režissöör" value = "<?php echo $film_director?>">
		<span><?php echo $director_missing; ?></span>
        <br>
        <input type="submit" name="film_submit" value="Salvesta">
    </form>
    <span><?php echo $film_store_notice; ?></span>

	
	
	
	
</body>
</html>