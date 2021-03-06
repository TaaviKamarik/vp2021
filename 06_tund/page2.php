<?php
	session_start();

	// * Muutsin ajavööndit.
	date_default_timezone_set('Europe/Tallinn');
	require_once("../../../config.php");
	require_once("fnc_user.php");
	$author_name = "Taavi Kamarik";
	
	//kontrollin kas POST info jõuab kuhugi.
	//var_dump($_POST);
	
	//kontollime kas klikiti submiti
	$todays_adjective_html = null;
	$todays_adjective_error = null;
	$todays_adjective = null;
	$email = null;

	if(isset($_POST["adjective_submit"])){
		echo "Klikiti";
		//Kontrollime kas midagi kirjutati.
		if(!empty($_POST["todays_adjective_input"])){
		$todays_adjective_html = "<p>Tänane päev on ". $_POST["todays_adjective_input"].".</p>";
		$todays_adjective = $_POST["todays_adjective_input"];
		} else {
			$todays_adjective_error = "Palun sisesta tänase kohta sobiv omadussõne!";
		}
	}
	
	
	
	// juhusliku foto lisamine
	
	$photo_dir = "../Photos/";
	// loen kataloogi sisu
	
	$all_files = scandir($photo_dir);
	$all_real_files = array_slice($all_files, 2);
	
	// * Boonus
	//shuffle($all_real_files);
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
	
	//Määran foto vastavalt valikule.
	if(isset($_POST["photo_submit"])){
		//echo "Submitted";
		$photo_num = $_POST["photo_select"];
		//echo $photo_num;
		
	}
	
	//<img src="kataloog/fail" alt="Tallinna Ülikool">
	$photo_html = '<img src = "' . $photo_dir . $photo_files[$photo_num] . '" alt ="Tallinna Ülikool">';
	
	//tsükkel
	$photo_list_html = "\n <ul> \n";
	for($i = 0; $i < $file_count; $i++){
	
		$photo_list_html .= "<li>".$photo_files[$i]."</li> \n";
	}
	$photo_list_html .= "</ul> \n";
	
	
	$photo_select_html = "\n". '<select name ="photo_select">'."\n";
	for($i = 0; $i < $file_count; $i++){
		if(isset($_POST["photo_select"])){
		
			if($photo_files[$i] == $photo_files[$photo_num] ) {
				
				$photo_select_html .= '<option value ="'.$i .'" selected = "selected" >' .$photo_files[$i] . "</option> \n";
			}
			else{
				$photo_select_html .= '<option value ="'.$i .'">' .$photo_files[$i] . "</option> \n";
			}
		}else{
			$photo_select_html .= '<option value ="'.$i .'">' .$photo_files[$i] . "</option> \n";
		}
		
		
	}
	$photo_select_html .= "</select> \n";
	
	$notice = null;
	if(isset($_POST["login_submit"]) and $_POST["email_input"] != null and strlen($_POST["password_input"]) > 8){
		echo "Test";
		$notice = sign_in($_POST["email_input"], $_POST["password_input"]);
		$email = filter_var($_POST["email_input"],FILTER_VALIDATE_EMAIL);
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
	<p><?php 
		echo $photo_html; 
		//echo $photo_list_html;
	?></p>
	<p><?php echo $photo_files[$photo_num] ?></p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
		<input type="email" name="email_input"  placeholder="Kasutajatunnus e email" value = "<?php echo $email?>">
		<input type="password" name ="password_input" placeholder = "salasõna">
		<input type = "submit" name="login_submit" value= "Logi sisse"><span><?php echo $notice; ?></span>
	<p>Loo omale <a href="add_user.php">kasutajakonto</a></p>
	<hr>
	<form method = "POST">
		<input  type = "text" placeholder = "Omadussõna tänase päeva kohta" name="todays_adjective_input" value = "<?php echo $todays_adjective?>">
		<input type = "submit" name = "adjective_submit" value = "Saada">
		<span> <?php echo $todays_adjective_error ?></span>
	</form>
	<?php echo $todays_adjective_html; ?>
	
	<hr>
	<form method = "POST">
		<?php echo $photo_select_html;?>
		<input type = "submit" name = "photo_submit" value = "Vali foto">
	</form>
	<hr>
	
	
</body>
</html>