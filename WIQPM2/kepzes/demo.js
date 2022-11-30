var Tabla=document.getElementById("kepzesre_jelentkezok");
var Uj_sor_gomb=document.getElementById("uj_sor");
var options_inner=["Overall", "Landscape", "Wedding", "Portrait", "Retouching", "Wildlife"];
Uj_sor_gomb.addEventListener("click",Uj_sor_hozzaad);
var Sorok=document.getElementsByTagName("tr");


var adatok=new Array(100);
for(var i=0;i<100;i++){
	adatok[i]=new Array(4);
}
var Elso_sor_cellai=document.getElementsByTagName("th");
for(var i=0;i<4;i++){
	Elso_sor_cellai[i].children[0].addEventListener("keyup", Szures);
}
var Elso_options=[];
for(var i=0;i<6;i++){
	Elso_options[i]=document.createElement("option");
	Elso_options[i].innerHTML=options_inner[i];
}
for(var i=0;i<6;i++){
	Elso_sor_cellai[3].children[0].appendChild(Elso_options[i]);
}
Elso_sor_cellai[3].children[0].addEventListener("change", Szures);



function Uj_sor_hozzaad(){
	var sor=document.createElement("tr");
	var cella=[];
	var input=[];
	var options=[];
	for(var i=0;i<6;i++){
		cella[i]=document.createElement("td");
	}
	for(var i=0;i<3;i++){
		input[i]=document.createElement("input");
		input[i].setAttribute("required", "true");
		input[i].addEventListener("click", Keret);
	}
	var select1=document.createElement("select");
	for(var i=0;i<6;i++){
		options[i]=document.createElement("option");
		options[i].innerHTML=options_inner[i];
	}
	for(var i=0;i<6;i++){
		sor.appendChild(cella[i]);
	}
	for(var i=0;i<3;i++){
		cella[i].appendChild(input[i]);
	}
	cella[3].appendChild(select1);
	for(var i=0;i<6;i++){
		select1.appendChild(options[i]);
	}
	if(Sorok.length%2==0){
		for(var i=0;i<cella.length;i++){
			cella[i].style.backgroundColor="#f1f1f1";
		}
	}
	else{
		for(var i=0;i<cella.length;i++){
			cella[i].style.backgroundColor="#ffffff";
		}
	}
	Tabla.appendChild(sor);
	Ok(sor);
	Torles(sor);
}
function Ok(sor){
	var OK_gomb=document.createElement("button");
	OK_gomb.innerHTML="Ok <i></i>";
	OK_gomb.children[0].classList.add("fas", "fa-check");
	var style_OK_gomb="width: 75px; text-align: center; background-color: #00e600; color: #ffffff; outline: 0; border: 0; padding: 5px; margin :2px;";
	OK_gomb.setAttribute("style", style_OK_gomb);
	OK_gomb.addEventListener("click", Csere_OK_Szerk);
	var OK_cella=sor.getElementsByTagName("td")[4];
	var OK_cellak=sor.getElementsByTagName("td");
	for(var i=0; i<3;i++){
		OK_cellak[i].children[0].removeAttribute("readonly");
		OK_cellak[i].children[0].style.backgroundColor="#ffffff";
		OK_cellak[i].children[0].style.border="1px solid grey";
	}
	OK_cellak[3].children[0].style.webkitAppearance="button";
	OK_cellak[3].children[0].style.backgroundColor="#ffffff";
	OK_cellak[3].children[0].style.border="1px solid grey";
	OK_cellak[3].children[0].removeAttribute("disabled");
	OK_cella.appendChild(OK_gomb);
}
function Torles(sor){
	var Torles_gomb=document.createElement("button");
	Torles_gomb.innerHTML="Delete <i></i>";
	Torles_gomb.children[0].classList.add("fas","fa-trash-alt");
	var style_Torles_gomb="width: 75px; text-align: center; background-color: #ff0000; color: #ffffff; outline: 0; border: 0; padding: 5px; margin :2px;";
	Torles_gomb.setAttribute("style", style_Torles_gomb);
	var Torles_cella=sor.getElementsByTagName("td")[5];
	Torles_gomb.addEventListener("click", Torol);
	Torles_cella.appendChild(Torles_gomb);
}
function Szerkeszt(sor){
	var Szerkeszt_gomb=document.createElement("button");
	Szerkeszt_gomb.innerHTML="Edit <i></i>";
	Szerkeszt_gomb.children[0].classList.add("fas", "fa-edit");
	Szerkeszt_gomb.children[0].style.color="#ffffff";
	var style_Szerkeszt_gomb="width: 75px; text-align: center; background-color: #ffcc00; color: #ffffff; outline: 0; border: 0; padding: 5px; margin :2px;";
	Szerkeszt_gomb.setAttribute("style", style_Szerkeszt_gomb);
	var Szerkeszt_cella=sor.getElementsByTagName("td")[4];
	var Szerkeszt_cellak=sor.getElementsByTagName("td");
	
	for(var i=0; i<3;i++){
		Szerkeszt_cellak[i].children[0].setAttribute("readonly", "true");
		Szerkeszt_cellak[i].children[0].style.border="0";
		if(Szerkeszt_cellak[i].style.backgroundColor=="rgb(241, 241, 241)")
			Szerkeszt_cellak[i].children[0].style.backgroundColor="#f1f1f1";
		else
			Szerkeszt_cellak[i].children[0].style.backgroundColor="#ffffff";
	}
	Szerkeszt_gomb.addEventListener("click", Csere_OK_Szerk);
	Szerkeszt_cella.appendChild(Szerkeszt_gomb);
	Szerkeszt_cellak[3].children[0].style.webkitAppearance="none";
	if(Szerkeszt_cellak[3].style.backgroundColor=="rgb(241, 241, 241)")
		Szerkeszt_cellak[3].children[0].style.backgroundColor="#f1f1f1";
	else
		Szerkeszt_cellak[3].children[0].style.backgroundColor="#ffffff";
	Szerkeszt_cellak[3].children[0].style.border="0";
	Szerkeszt_cellak[3].children[0].setAttribute("disabled", "true");
}
function Megse1(sor){
	var Megse_gomb=document.createElement("button");
	Megse_gomb.innerHTML="Undo <i></i>";
	Megse_gomb.children[0].classList.add("fas", "fa-reply");
	var style_Megse_gomb="width: 75px; text-align: center; background-color: #ffffff; color: #000000; outline: 0; border: 0; padding: 5px; margin :2px;";
	Megse_gomb.setAttribute("style", style_Megse_gomb);
	var Megse_cella=sor.getElementsByTagName("td")[5];
	Megse_gomb.addEventListener("click", Megse);
	Megse_cella.appendChild(Megse_gomb);
}



function Csere_OK_Szerk(){
	if(this.innerHTML=='Ok <i class="fas fa-check" aria-hidden="true"></i>'){
		var megfelel=true;
		var sor=this.parentElement.parentElement;
		for(var i=0;i<3;i++){
			sor.children[i].children[0].value=sor.children[i].children[0].value.trim()
			if(sor.children[i].children[0].value==""){
				sor.children[i].children[0].style.border="1px solid red";
				megfelel=false;
			}
		}
		if(megfelel){
			var index=1;
			for(var i=1;i<Sorok.length;i++){
				if(sor!=Sorok[i])
					index++;
				else
					break;
			}
			for(var i=0;i<4;i++){
				adatok[index][i]=sor.children[i].children[0].value;
			}
			var torles_gomb=this.parentElement.parentElement.children[5].children[0];
			this.parentElement.removeChild(this);
			torles_gomb.parentElement.removeChild(torles_gomb);
			Szerkeszt(sor);
			Torles(sor);
		}
	}	
	else{
		var sor=this.parentElement.parentElement;
		var megse_gomb=this.parentElement.parentElement.children[5].children[0];
		this.parentElement.removeChild(this);
		megse_gomb.parentElement.removeChild(megse_gomb);
		Ok(sor);
		Megse1(sor);
	}
}
function Torol(){
	sor=this.parentElement.parentElement;
	var index=1;
	for(var i=1;i<Sorok.length;i++){
		if(sor!=Sorok[i])
			index++;
		else
			break;
	}
	for(var i=index;i<Sorok.length-1;i++){
		adatok[i]=adatok[i+1];
	}
	adatok.pop();
	sor.parentElement.removeChild(sor);
}
function Megse(){
	var sor=this.parentElement.parentElement;
	var index=1;
	for(var i=1;i<Sorok.length;i++){
		if(sor!=Sorok[i])
			index++;
		else
			break;
	}
	for(var i=0;i<4;i++){
		sor.children[i].children[0].value=adatok[index][i];
	}
	var torles_gomb=this.parentElement.parentElement.children[4].children[0];
	this.parentElement.removeChild(this);
	torles_gomb.parentElement.removeChild(torles_gomb);
	Szerkeszt(sor);
	Torles(sor);
}
function Keret(){
	this.style.border="1px solid grey";
}

function Szures(){
	for(var i=1;i<Sorok.length;i++){
		for(var j=0;j<4;j++){
			if(adatok[i][j].toLowerCase().startsWith(Elso_sor_cellai[j].children[0].value.toLowerCase())){
				Sorok[i].style.display="table-row";
			}
			else{
				Sorok[i].style.display="none";
				break;
			}
		}
	}
}