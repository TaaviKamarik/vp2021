<?php

	$database = "if21_taavi_ka";
	
	function sign_up($firstname,$surname,$email,$gender,$birth_date,$password){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vprg_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = "Kasutaja on juba olemas";
		}else{
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vprg_users (firstname, lastname, birthdate, gender, email, password) values(?,?,?,?,?,?)");
			echo $conn->error;
			//krüpteerime passwordi
			$option = ["cost" => 12];
			$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
			$stmt -> bind_param("sssiss", $firstname,$surname,$birth_date,$gender,$email,$pwd_hash);
			if($stmt->execute()){
				$notice = "Uus kasutaja edukalt loodud!";
			} else {
				$notice = "Uue kasutaja loomisel tekkis viga: ".$stmt->error;
			}
		}
		
		
		
		
		
		
		
		
		
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function load_info(){
		$info = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT description FROM vprg_userprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->bind_result($description_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$info = $description_from_db;
	
		}
		
		$stmt->close();
		$conn->close();
		return $info;
	}
	
	function populate_info($description,$bgcolor,$txtcolor){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vprg_userprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->execute();
		if($stmt->fetch()){
			$stmt->close();
			$stmt = $conn->prepare("UPDATE vprg_userprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["user_id"]);
			if($stmt->execute()){
				$notice = "Andmed on muudetud.";
			}else{
				$notice = "Andmete muutmisel tekkis probleem: ". $stmt->error;
			}
			
		}else{
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vprg_userprofiles (userid, description, bgcolor, txtcolor) values (?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_SESSION["user_id"], $description, $bgcolor, $txtcolor);
			if($stmt->execute()){
				$notice = "Andmed on lisatud";
			}else{
				$notice = "Anmdete lisamisel tekkis probleem: " .$stmt->error;
			}
			
		}
		
		
	
		
		
		
		
		
		
		
		
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function sign_in($email, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT password, id, firstname, lastname FROM vprg_users WHERE email = ?");
		
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($password_from_db, $id_from_db, $firstname_from_db, $lastname_from_db );
		$stmt->execute();
		if($stmt->fetch()){
			//parool tuli
			if(password_verify($password, $password_from_db)){
			
				//parool õige, oleme sees
				$stmt->close();
				$conn->close();
				$_SESSION["user_id"] = $id_from_db;
				$_SESSION["user_firstname"] = $firstname_from_db;
				$_SESSION["user_lastname"] = $lastname_from_db;
				//========================================
				
				//edaspidi loeme kasutajaprofiili, kui see on olemas.
				
				$_SESSION["bg_color"] = "#FFFFBB";
				$_SESSION["text_color"] = "#FFCC00";
				
				//==========================================
				header("Location: home.php");
				exit();
			}else{
				$notice = "Kasutajatunnus või salasõna oli vale!";
			}
		}else{
			$notice = "Kasutajatunnus või salasõna oli vale!";
		}
		
		
		$stmt->close();
		$conn->close();
		return $notice;
	}