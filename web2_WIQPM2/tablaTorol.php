<?php
	session_start();
	if(isset($_SESSION["felhasznalo"])){
		$tabla=$_GET["tabla"];
		$conn= new mysqli("localhost","root","","web2_wiqpm2");
		if($conn->connect_error){
			die($conn->connect_error);
		}
		$sql="DROP TABLE $tabla";
		$result=$conn->query($sql);
		$conn->close();
		unset($_SESSION["tabla"]);
		header("Location: index.php");
	}
	else
		header("Location: index.php");
?>