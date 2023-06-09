<?php
	session_start();
	unset($_SESSION["tabla"]);
	unset($_SESSION["felhasznalo"]);
	header("Location: login.php");
?>