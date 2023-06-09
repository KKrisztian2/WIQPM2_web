<?php
	session_start();
	if(isset($_SESSION["felhasznalo"])){
		$id=$_GET["torol"];
		$tabla=$_GET["tabla"];
		$oszlop=$_GET["oszlop"];
		$conn= new mysqli("localhost","root","","web2_wiqpm2");
		if($conn->connect_error){
			die($conn->connect_error);
		}
		//$sql="DELETE FROM $tabla WHERE id=$id";
		$sql="DELETE FROM $tabla WHERE $oszlop=$id";
		$result=$conn->query($sql);
		$conn->close();
		header("Location: index.php");
	}
	else
		header("Location: index.php");
?>