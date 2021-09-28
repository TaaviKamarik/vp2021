<?php
	//loon andmebaasiühenduse: server, kasutaja, parool ja andmebaas
	
	$database = "if21_taavi_ka";
	
	function read_all_films(){

	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		//määrame korrektse kooditabeli
		$conn->set_charset("utf8");
		
		//valmistan ette SQL käsu
		$stmt = $conn->prepare("SELECT * FROM film");
		echo $conn->error;
		//seome tulemused muutujatega
		$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db);
		//annamer käsu täitmiseks
		$stmt->execute();
		
		$film_html = null;
		//võtan andmed
		while($stmt->fetch()){
			$film_html .= "\n <h3>" .$title_from_db. "</h3> \n <ul> \n";
			$film_html .= "<li>Valmimisaasta: " . $year_from_db ."</li> \n";
			$film_html .= "<li>Kestvus: " . $duration_from_db ."</li> \n";
			$film_html .= "<li>Žanr: " . $genre_from_db ."</li> \n";
			$film_html .= "<li>Tootja: " . $studio_from_db ."</li> \n";
			$film_html .= "<li>Lavastaja: " . $director_from_db ."</li> \n";
			$film_html .= "</ul> \n";
		}
		
		//Sulgeme käsu
		$stmt->close();
		//Sulgeme andmebaasiühenduse
		$conn->close();
		return $film_html;
	
	}
	
	function store_film($title_input, $year_input, $duration_input, $gernre_input, $studio_input, $director_input){
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		// INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES ()
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES (?,?,?,?,?,?)");
		echo $conn->error;
		//seome SQL käsud päris andmetega
		//andmetüübi: i - integer, d - decimal, s - string
		$stmt->bind_param("siisss", $title_input, $year_input, $duration_input, $gernre_input, $studio_input, $director_input);
		$success = null;
		if($stmt->execute()){
			$success = "Salvestamine õnnestus.";
		}else{
			$success = "Salvestamisel tekkis viga: " .$stmt->error;
		}
		
		
		$stmt->close();
		$conn->close();
		return $success;
		
	}
	
