var ures=document.getElementsByClassName("ures");
for(x of ures){
	var input=x.parentElement.nextElementSibling;
	if(x.innerHTML!=""){
		input.classList.add("hiba_input");
	}
	input.addEventListener("change", hibaStyleRemove);
}
function hibaStyleRemove(){
	if(this.classList.contains("hiba_input")){
		this.classList.remove("hiba_input");
		var ures=this.previousElementSibling.children[2];
		ures.innerHTML="";
	}
}