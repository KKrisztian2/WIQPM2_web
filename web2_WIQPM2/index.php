<?php
	session_start();
	if(!isset($_SESSION["felhasznalo"])){
		header("Location: login.php");
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tábla</title>
		<meta charset="UTF-8">
		<link rel = "stylesheet" type = "text/css" href = "indexStyle.css">
	</head>
	<body>
		<h2>Beadandó</h2>
		<?php
			if(isset($_SESSION["error"])){
				echo "<div id='sikertelen'>";
				print_r($_SESSION['error']);
				echo "<button id='x' onclick='bezar()'>x</button>";
				echo "</div>";
				unset($_SESSION["error"]);
			}
			if(isset($_SESSION["ujTabla"])){
				unset($_SESSION["ujTabla"]);
				unset($_SESSION["oszlopSzam"]);
			}
		?>
		<a href="logout.php" id="kijelentkezes">Kijelentkezés</a>
			<?php
				echo "<form action='' method='post'>";
				$conn= new mysqli("localhost","root","","web2_wiqpm2");
				if($conn->connect_error){
					die($conn->connect_error);
				}
				$sql="SHOW TABLES FROM web2_wiqpm2";
				$result=$conn->query($sql);
				echo "<label for='tabla'>Tábla</label>";
				echo "<select name='tabla' id='select'>";
				for($i=0;$i<$result->num_rows;$i++){
					$row=$result->fetch_array();
					if(isset($_SESSION["tabla"])){
						if(isset($_POST["megnyitas"])){
							$_SESSION["tabla"]=$_POST["tabla"];
						}
						if($row[0]==$_SESSION["tabla"])
							echo "<option selected>$row[0]</option>";
						else
							echo "<option>$row[0]</option>";
					}
					else
						echo "<option>$row[0]</option>";
				}
				echo "</select><br>";
				echo "<input type='submit' id='megnyitas' name='megnyitas' value='Tábla megnyitása'>";
				echo "</form>";
				
				
			
				if(isset($_POST["megnyitas"]) || isset($_SESSION["tabla"])){
					if(isset($_POST["megnyitas"])){
						$_SESSION["tabla"]=$_POST["tabla"];
					}
					if(isset($_POST["megnyitas"])){
						$tabla_neve=$_POST["tabla"];
					}
					else{
						$tabla_neve=$_SESSION["tabla"];
					}
					$conn=new mysqli("localhost", "root", "", "web2_wiqpm2");	
					$sql="SELECT * from $tabla_neve";
					$result=$conn->query($sql);
					$tabla="<table>";
					$tabla.="<tr>";
					for($i=0;$i<$result->field_count;$i++){
						$tabla.="<th>";
						if($i==0){
							$id=mysqli_fetch_field($result)->name;
							$tabla.=$id;
						}
						else{
							$tabla.=mysqli_fetch_field($result)->name;
						}
						$tabla.="</th>";
					}
					$tabla.="<th>";
					$tabla.="</th>";
					$tabla.="</tr>";
					$collumns=$result->field_count;
					for($i=0;$i<$result->num_rows;$i++){
						$row=$result->fetch_array();
						$tabla.="<tr>";
						for($j=0;$j<$result->field_count;$j++){
							$tabla.="<td>";
							$tabla.=$row[$j];
							$tabla.="</td>";
						}
						$tabla.="<td>";
						$tabla.="<a class='torol' href='sorTorol.php?torol=$row[0]&tabla=$tabla_neve&oszlop=$id'>Törlés</a>";
						$tabla.="</td>";
						$tabla.="</tr>";
					}
					$tabla.="</table>";
					echo "<a href='tablaTorol.php?tabla=$tabla_neve' id='tablaTorol'>Tábla törlése</a>";
					echo "<a href='tablaLetrehoz.php' id='tablaLetrehoz'>Tábla létrehozása</a>";
					echo "<h3>Tábla: <strong>$tabla_neve</strong></h3>";
					print "$tabla";
					$conn->close();
					echo "<a id='hozzad' onclick='beolvas($collumns)'>Új sor</a>";
				}
			?>
			<script>
				function beolvas(oszlopok){
					var uj_sor=document.getElementById("hozzad");
					uj_sor.style.pointerEvents="none";
					var tabla=document.getElementsByTagName("table");
					var sor=document.createElement("tr");
					for(var i=0;i<oszlopok;i++){
						var cella=document.createElement("td");
						var input=document.createElement("input");
						input.classList.add("adatok");
						cella.appendChild(input);
						sor.appendChild(cella);
					}
					var ok=document.createElement("a");
					var cella=document.createElement("td");
					ok.classList.add("veglegesit");
					ok.onclick=href_meghataroz;
					ok.innerHTML="Ok";
					cella.appendChild(ok);
					sor.appendChild(cella);
					tabla[0].children[0].appendChild(sor);
				}
				function href_meghataroz(){
					var oszlop_sz=this.parentElement.parentElement.children;
					var input=[];
					var href="sorHozzaad.php?";
					var sikeres=true;
					for(var i=0;i<oszlop_sz.length-1;i++){
						input[i]=oszlop_sz[i].firstChild.value;
						href+="var"+i+"="+input[i]+"&";
						if(input[i] == ""){
							sikeres = false;
							oszlop_sz[i].firstChild.style.border = "1px solid red";
						}
						else{oszlop_sz[i].firstChild.style.border = "1px solid black";}
					}
					if(sikeres==true){
						var tnev=document.getElementsByTagName("strong")[0].innerHTML;
						var gomb=oszlop_sz[oszlop_sz.length-1].firstChild;
						var s=oszlop_sz.length-1;
						href+="oszlop_sz="+s+"&"+"tabla="+tnev;
						gomb.href=href;
						console.log(gomb);
					}
				}
				function bezar(){
					var div=document.getElementById("sikertelen");
					div.style.display="none";
				}
			</script>
	</body>
</html>