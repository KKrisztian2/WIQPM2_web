<?php
	session_start();
	$username="";
	$password="";
	$hibak=[];
	if(isset($_POST["bejelentkezés"])){
		$username=megtisztit($_POST["username"]);
		$password=megtisztit($_POST["password"]);
		if(empty($username)){
			$hibak["username"]="Töltse ki a mezőt.";
		}
		if(!empty($username) && !preg_match("/^[^0-9][a-zA-Z|0-9|_]*$/",$username)){
			$hibak["username"]="Felhasználónév hibás.";
		}
		if(empty($password)){
			$hibak["password"]="Töltse ki a mezőt.";
		}
		if(count($hibak)==0){
			$conn= new mysqli("localhost","root","","web2_wiqpm2");
			if($conn->connect_error){
				die($conn->connect_error);
			}
			/*$sql="SELECT * FROM felhasznalok WHERE username='$username' and password='$password'";
			$result=$conn->query($sql);*/
			$stmt=$conn->prepare("SELECT * FROM felhasznalok WHERE username=? and password=?");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows>0){
				$_SESSION["felhasznalo"]=$username;
				$username="";
				$password="";
				header("Location: index.php");
			}
			else{
				$hibak["username"]="Ilyen felhasználó nem létezik vagy téves jelszót adott meg.";
			}
			$stmt->close();
			$conn->close();
		}
	}
	function megtisztit($adat){
		$adat=trim($adat);
		$adat=stripslashes($adat);
		$adat=htmlspecialchars($adat);
		return $adat;
	}	


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<link rel = "stylesheet" type = "text/css" href = "loginStyle.css">
	</head>
	<body>
		<form action="" method="post">
			<div class="hiba">
				<?php
					if(isset($hibak["username"]) && $hibak["username"]!="Töltse ki a mezőt.")
						echo $hibak["username"];
				?>
			</div>
			<h3>Bejelentkezés</h3>
			<div>
				<label for="username">Felhasználónév</label><br>
				<div class="ures"><?php
					if(isset($hibak["username"]) && $hibak["username"]=="Töltse ki a mezőt.")
						echo $hibak["username"];
				?></div>
			</div>
			<input type="text" name="username" value="<?php echo $username?>" autocomplete="off"><br>
			<div>
				<label for="password">Jelszó</label><br>
				<div class="ures"><?php
					if(isset($hibak["password"]) && $hibak["password"]=="Töltse ki a mezőt.")
						echo $hibak["password"];
				?></div>
			</div>
			<input type="password" name="password" value="<?php echo $password?>" autocomplete="off"><br>
			<input type="submit" name="bejelentkezés" value="Bejelentkezés">
		</form>
		<script src="login.js"></script>
	</body>
</html>