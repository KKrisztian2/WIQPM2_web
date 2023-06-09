<?php
	session_start();
	if(isset($_SESSION["felhasznalo"])){
		session_start();
		$oszlop_sz=$_GET["oszlop_sz"];
		$tabla=$_GET["tabla"];
		$adatok=[];
		for($i=0;$i<$oszlop_sz;$i++){
			$seged="var".$i;
			$adatok[$i]=$_GET[$seged];
		}
		$conn= new mysqli("localhost","root","","web2_wiqpm2");
		if($conn->connect_error){
			die($conn->connect_error);
		}
		$sql="SHOW FIELDS FROM $tabla";
		$result=$conn->query($sql);
		$s="(";
		for($i=0;$i<$oszlop_sz-1;$i++){
			$oszlop=$result->fetch_assoc();
			if(preg_match("/^int/", $oszlop["Type"])){
				$s=$s.$adatok[$i].", ";
			}
			else{
				$s=$s."'".$adatok[$i]."'".", ";
			}
		}
		$oszlop=$result->fetch_assoc();
		if(preg_match("/^int/", $oszlop["Type"])){
			$s=$s.$adatok[$oszlop_sz-1].");";
		}
		else{
			$s=$s."'".$adatok[$oszlop_sz-1]."'".");";;
		}
		$sql="INSERT INTO $tabla VALUES ".$s;
		$result=$conn->query($sql);
		if($conn->error){
			$_SESSION["error"]=$conn->error;
			header("Location: index.php");
		}
		$conn->close();
		header("Location: index.php");
	}
	else
		header("Location: index.php");
?>