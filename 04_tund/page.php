<?php

	// * Muutsin ajavööndit.
	date_default_timezone_set('Europe/Tallinn');
	$author_name = "Taavi Kamarik";
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_now = date("N");
	// * Määrasin praegused tunnid.
	$hours_now = date("H");
	$time_of_day = "";
	$day_category = "lihtsalt päev";
	// echo $weekday_now;
	
	// võrdub == 
	if($weekday_now < 6){
		$day_category = "koolipäev";
	} else {
		$day_category = "puhkepäev";
	}
	$weekday_names_et = ["Esmaspäev","teisipäev","Kolmapäev","Neljapäev","Reede","Laupäev","Pühapäev"];
	
	// if($hour_now < 7 or $hour_now >23)
	if($hours_now < 8 or $hours_now >= 23 and $day_category == "koolipäev"){
		$time_of_day = "Uneaeg";
	}else if($hours_now >= 8 or $hours_now <= 18 and $day_category == "koolipäev"){
		$time_of_day = "Tundide aeg";
	}else{
		$time_of_day = "Vaba aeg";
	}
	
	// juhusliku foto lisamine
	
	$photo_dir = "../Photos/";
	// loen kataloogi sisu
	
	$all_files = scandir($photo_dir);
	$all_real_files = array_slice($all_files, 2);
	
	// * Boonus
	shuffle($all_real_files);
	$all_real_files = array_slice($all_real_files, 0, 3);

	
	// sõelume välja päris pildid
	
	$photo_files = [];
	$allowed_photo_types = ["image/jpeg", "image/png"];
	foreach($all_real_files as $file_name){
		$file_info = getimagesize($photo_dir . $file_name);
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push($photo_files, $file_name);
			}
		}
		
	}
	
	
	//var_dump($all_real_files);
	
	// loen massiivi elemendid kokku
	$file_count = count($photo_files);
	//loosin juhsliku arvu (min = 0, max = count()-1)
	
	$photo_num = mt_rand(0, $file_count - 1);
	//<img src="kataloog/fail" alt="Tallinna Ülikool">
	$photo_html = '<img src = "' . $photo_dir . $photo_files[$photo_num] . '" alt ="Tallinna Ülikool">';
	

	
	

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
	<p>Lehe avamise hetk: <?php echo $weekday_names_et[$weekday_now - 1].", " .$full_time_now .", ".$day_category.": Praegu on ".$time_of_day; ?>.</p>
	<?php echo $photo_html; ?>
	<!-- <?php echo $hours_now; ?> -->
	
	
	
</body>
</html>