<!DOCTYPE html>
<html>
<head>
	<title>Tábla létrehozása</title>
	<meta charset="utf-8">
</head>
<body>
<?php
	session_start();
	if(isset($_SESSION["felhasznalo"])){
		echo "<a href='logout.php' id='kijelentkezes'>Kijelentkezés</a>";
		echo "<h2>Tábla létrehozása</h2>";
		
		if(!isset($_POST["indit"]) && !isset($_POST["letrehoz"])){
			echo "<a href='index.php' id='megse'>Mégse</a>";
			echo "<form action='' method='post'>";
			echo "<div id='elso'>";
			echo "<label for='tabla' id='label1'>Tábla neve</label>";
			echo "<input type='text' name='tabla' class='input1' required><br>";
			echo "<label for='oszlopok' id='label2'>Oszlopszám</label>";
			echo "<input type='number' name='oszlopok' class='input1' value='1' min='1'><br>";
			echo "</div>";
			echo "<input type='submit' name='indit' id='indit' value='Indít'>";
			echo "</form>";
		}
		
		if(isset($_POST["letrehoz"])){
			for($i=0;$i<$_SESSION["oszlopSzam"];$i++){
				$name="adat0".$i;
				$nev=$_POST["$name"];
				if($nev=="" || !preg_match("/[a-zA-Z]/",$nev)){
					$_SESSION["hiba_nev"]="Minden Név mezőt ki kell tölteni! A mező nevében csak angol ABC betűi szerepelhetnek!";
				}
				$name="adat2".$i;
				$hossz=$_POST["$name"];
				if($hossz=="" || $hossz<1 || $hossz>1001){
					$_SESSION["hiba_hossz"]="A Hossz értékét ki kell tölteni! Értéke 1-től 1000-ig terjedhet!";
				}
			}
			if(!isset($_SESSION["hiba_nev"]) && !isset($_SESSION["hiba_hossz"])){
				echo "<a href='index.php' id='megse'>Vissza</a>";
				$conn= new mysqli("localhost","root","","web2_wiqpm2");
				if($conn->connect_error){
					die($conn->connect_error);
				}
				$sql="CREATE TABLE ";
				$sql=$sql.$_SESSION['ujTabla'];
				$sql=$sql." (";
				for($i=0;$i<$_SESSION["oszlopSzam"];$i++){
					$name="adat0".$i;
					$sql=$sql.$_POST["$name"]." ";
					$name="adat1".$i;
					$sql=$sql.$_POST["$name"];
					$name="adat2".$i;
					$sql=$sql."(".$_POST["$name"].") ";
					$name="adat3".$i;
					if($_POST["$name"]=="UNSIGNED")
						$sql=$sql.$_POST["$name"]." ";
					$name="adat4".$i;
					if(isset($_POST["$name"]) && $_POST["$name"]=="on")
						$sql=$sql."NOT NULL"." ";
					else
						$sql=$sql."NULL"." ";
					$name="adat5".$i;
					if($_POST["$name"]=="NULL")
						$sql=$sql."DEFAULT NULL"." ";
					$name="adat6".$i;
					if(isset($_POST["$name"]) && $_POST["$name"]=="on")
						$sql=$sql."AUTO_INCREMENT"." ";
					$name="adat7".$i;
					if($_POST["$name"]=="PRIMARY")
						$sql=$sql."PRIMARY KEY";
					else if($_POST["$name"]=="UNIQUE")
						$sql=$sql."UNIQUE";
					if($i<$_SESSION["oszlopSzam"]-1)
						$sql=$sql.", ";
				}
				$sql=$sql.");";
				$result=$conn->query($sql);
				if($conn->error){
					echo "<div class='hiba'>";
					print_r($conn->error);
					echo "</div>";
				}
				else{
					echo "<div id='sikeres'>";
					echo "Tábla sikeresen létrehozva!";
					echo "</div>";
				}
				$conn->close();
			}
		}
		if(isset($_POST["indit"]) || (isset($_SESSION["hiba_hossz"]) || isset($_SESSION["hiba_nev"]))){
			if(isset($_SESSION["hiba_nev"])){
				echo "<div class='hiba'>";
				echo $_SESSION["hiba_nev"];
				echo "</div>";
			}
			if(isset($_SESSION["hiba_hossz"])){
				echo "<div class='hiba'>";
				echo $_SESSION["hiba_hossz"];
				echo "</div>";
			}
			if(!isset($_SESSION["hiba_hossz"]) && !isset($_SESSION["hiba_nev"])){
				$_SESSION["ujTabla"]=$_POST["tabla"];
				$_SESSION["oszlopSzam"]=$_POST["oszlopok"];
			}
			echo "<a href='index.php' id='megse'>Mégse</a>";
			echo "<h3>Tábla neve: "; 
			print_r($_SESSION['ujTabla']);
			echo "</h3>";
			$oszlopNev=["Név", "Típus", "Hossz", "Tulajdonság", "Not NULL", "Alapértelmezett", "Auto Inc.", "Index"];
			echo "<form action='' method='post'>";
			echo "<table>";
			echo "<tr>";
			for($i=0;$i<8;$i++){
				echo "<th>";
				echo $oszlopNev[$i];
				echo "</th>";
			}
			echo "</tr>";
			for($i=0;$i<$_SESSION["oszlopSzam"];$i++){
				echo "<tr>";
				echo "<td>";
				$name="adat0".$i;
				echo "<input type='text' name='$name'>";
				echo "</td>";
				echo "<td>";
				$name="adat1".$i;
				echo "<select name='$name'>";
				echo "<option selected>INT</option>";
				echo "<option>VARCHAR</option>";
				echo "</select>";
				echo "</td>";
				echo "<td>";
				$name="adat2".$i;
				echo "<input type='number' name='$name' min='1' max='1000'>";
				echo "</td>";
				echo "<td>";
				$name="adat3".$i;
				echo "<select name='$name'>";
				echo "<option selected></option>";
				echo "<option>UNSIGNED</option>";
				echo "</select>";
				echo "</td>";
				echo "<td>";
				$name="adat4".$i;
				echo "<input type='checkbox' name=$name>";
				echo "</td>";
				echo "<td>";
				$name="adat5".$i;
				echo "<select name='$name'>";
				echo "<option selected></option>";
				echo "<option>NULL</option>";
				echo "</select>";
				echo "</td>";
				echo "<td>";
				$name="adat6".$i;
				echo "<input type='checkbox' name=$name>";
				echo "</td>";
				echo "<td>";
				$name="adat7".$i;
				echo "<select name='$name'>";
				echo "<option selected></option>";
				echo "<option>PRIMARY</option>";
				echo "<option>UNIQUE</option>";
				echo "</select>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<input type='submit' id='letrehoz' name='letrehoz' value='Mentés'>";
			unset($_SESSION["hiba_nev"]);
			unset($_SESSION["hiba_hossz"]);
			echo "</form>";
		}
	}
	else
		header("Location: index.php");
?>
<style>
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}
	html{
		background-color: #f1f1f1;
	}
	body{
		width: 70%;
		margin: 0 auto;
		background-color: white;
		padding: 20px;
		position: relative;
		height: fit-content;
	}
	h2{
		padding-top: 35px;
		padding-bottom: 15px;
	}
	h3{
		margin-bottom: 10px;
	}
	#elso{
		width: 300px;
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-end;
	}
	label{
		margin-top: 10px;
		margin-right: 10px;
	}
	.input1{
		margin-top: 10px;
	}
	#indit{
		background-color: #009900;
		color: #ffffff;
		padding: 5px 15px;
		border: none;
		margin-top: 10px;
		margin-left: 0!important;
		outline: 0;
		text-decoration: none;
	}
	#indit:hover{
		opacity: 0.5;
		cursor: pointer;
		color: black;
	}
	#megse{
	position: absolute;
	top: 25px;
	right: 125px;
	}
	#kijelentkezes{
		position: absolute;
		top: 25px;
		right: 25px;
	}
	table{
		width: 100%;
		margin-bottom: 25px;
	}
	table, td, th{
		border: 1px solid grey;
		border-collapse: collapse;
	}
	td{
		padding: 5px;
	}
	th{
		background-color: #009900;
		padding-left: 10px;
		color: white;
		text-align: left;
		font-weight: normal;
	}
	table input{
		width: 100%;
		padding: 5px;
	}
	table select{
		width: 100%;
		padding: 5px;
	}
	table input[type="checkbox"]{
		margin: 0 auto;
	}
	.hiba{
		background-color: red;
		color: white;
		padding: 10px;
		width: 100%;
	}
	#sikeres{
		background-color: #009900;
		color: white;
		padding: 10px;
		width: 100%;
	}
	#letrehoz{
		background-color: #009900;
		color: #ffffff;
		padding: 5px 15px;
		border: none;
		outline: 0;
		text-decoration: none;
	}
	#letrehoz:hover{
		opacity: 0.5;
		cursor: pointer;
	}
</style>
</body>
</html>