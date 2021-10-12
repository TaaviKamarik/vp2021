<?php
	session_start();
	if(!isset($_SESSION["user_id"])){
		header("Location: page2.php");
	}
	
	if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page2.php");}
	require_once("../../../config.php");
	require_once("fnc_user.php");
	

	
	$description = load_info();

	

	
	
	
	
	
	
	if($_SERVER["REQUEST_METHOD"] === "POST"){
		if(isset($_POST["profile_submit"])){
			$description = $_POST["description_input"];
			$bgcolor = $_POST["bg_color_input"];
			$txtcolor = $_POST["text_color_input"];
			$_SESSION["bg_color"] = $_POST["bg_color_input"];
			$_SESSION["text_color"] = $_POST["text_color_input"];
 		
		$notice = populate_info($description, $bgcolor, $txtcolor);
		}
	
	}
	
	$notice = null;
	
	$author_name = $_SESSION["user_firstname"]. " " . $_SESSION["user_lastname"];
	

	require("page_header.php");
	
?>


	<h1><?php echo $author_name; ?></h1>
	<p>Tegin selle muutuse</p>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a></p>
	<hr>
	<h2>Kasutajaprofiil</h2>
	<form method="POST">
		<label for = "description_input">Lühikirjeldus</label>
		<br>
		<textarea name = "description_input" id = "description_input" rows = "10" cols = "80" placeholder = "Minu lühikirjeldus..."><?php echo $description; ?></textarea>
		<br>
		<label for = "bg_color_input">Taustavärv</label>
		<br>
		<input type = "color" name="bg_color_input" id="bg_color_input" value = "<?php echo $_SESSION["bg_color"]; ?>" >
		<br>
		<label for = "text_color_input">Tekstivärv</label>
		<br>
		<input type = "color" name="text_color_input" id="text_color_input" value = "<?php echo $_SESSION["text_color"]; ?>" >
        <br>
        <input type="submit" name="profile_submit" value="Salvesta">
    </form>
    <span><?php echo $notice;?></span>

</body>
</html>