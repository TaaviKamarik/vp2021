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