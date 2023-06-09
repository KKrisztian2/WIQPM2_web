var tabla=document.getElementsByTagName("table");
var sorok=tabla[0].children[0].children;

for(var i=1;i<sorok.length;i++){
	Torles(sorok[i]);
}

function Torles(sor){
	var Torles_gomb=document.createElement("button");
	Torles_gomb.innerHTML="Törlés";
	var style_Torles_gomb="width: 75px; text-align: center; background-color: #ff0000; color: #ffffff; outline: 0; border: 0; padding: 5px; margin :2px;";
	Torles_gomb.setAttribute("style", style_Torles_gomb);
	var Torles_cella=sor.lastChild;
	Torles_cella.appendChild(Torles_gomb);
}