var napok_div=document.getElementById("napok");
var napok_span=napok_div.getElementsByTagName("span");

var honapNev_div=document.getElementById("honapNev");
var honapNev_span=honapNev_div.getElementsByClassName("honap");
for(x of honapNev_span){
	x.addEventListener("click", honapValtas);
}
var esemenyAblak=document.getElementById("esemeny");
var hozzaad=document.getElementById("hozzaad");
hozzaad.addEventListener("click", EsemenyHozzaad);
var kilep=document.getElementById("kilep");
var datumEsemeny=document.getElementById("datum");
var esemenyLeiras=document.getElementById("esemenyLeiras");
kilep.addEventListener("click", kilepAblak);
var esemenyMentes=document.getElementById("mentes");
esemenyMentes.addEventListener("click", esemenyMent);
datumEsemeny.addEventListener("change", datumValtas);


var esEvek=[];
var esHonapok=[];
var esNapok=[];
var esLeirasok=[];
var esLeirasokDB=0;

var d=new Date();
var aktEv=d.getFullYear();
var aktHo=d.getMonth();
var aktNap=d.getDate();
var aktNapAhetben=d.getDay();

var Ev=aktEv;
var Ho=aktHo;

var aktElsoNap=new Date(Ev, Ho, 1);
var aktE=aktElsoNap.getDay();
if(aktE==0)
	aktE=6;
else
	aktE--;

var jobbNyil=document.getElementById("jobbNyil");
var balNyil=document.getElementById("balNyil");
var evNaptaron=document.getElementById("ev");
jobbNyil.addEventListener("click", evPlusz);
balNyil.addEventListener("click", evMinusz);

naptarKiir();
honapNev_span[aktHo].classList.add("jelenleg_honap");

function naptarKiir(){
	var elsoNap=new Date(Ev, Ho, 1);
	var utolsoNap=new Date(Ev, Ho+1, 0);
	var e=elsoNap.getDay();
	if(e==0)
		e=6;
	else
		e--;
	var v=utolsoNap.getDate();
	var a=1;
	for(var i=0;i<e;i++){
		napok_span[i].innerHTML="";
		napok_span[i].classList.remove("van_esemeny");
		napok_span[i].removeEventListener("click", esemenyMegjelen);
	}
	for(var i=e;i<v+e;i++){
		napok_span[i].innerHTML=a;
		napok_span[i].classList.remove("van_esemeny");
		napok_span[i].removeEventListener("click", esemenyMegjelen);
		a++;
	}
	for(var i=e+v;i<42;i++){
		napok_span[i].innerHTML="";
		napok_span[i].classList.remove("van_esemeny");
		napok_span[i].removeEventListener("click", esemenyMegjelen);
	}
	if(Ho==aktHo && Ev==aktEv)
		napok_span[aktNap+aktE-1].classList.add("jelenleg_nap");
	else
		napok_span[aktNap+aktE-1].classList.remove("jelenleg_nap");
	for(var i=0; i<esEvek.length;i++){
		if(esEvek[i]==Ev && esHonapok[i]==Ho+1){
			napok_span[Number(esNapok[i])-1+e].classList.add("van_esemeny");
			napok_span[Number(esNapok[i])-1+e].addEventListener("click", esemenyMegjelen);
		}
	}
}
function honapValtas(){
	var a=0;
	for(x of honapNev_span){
		if(x==this){
			break;
		}
		a++;
	}
	honapNev_span[Ho].classList.remove("jelenleg_honap");
	Ho=a;
	honapNev_span[Ho].classList.add("jelenleg_honap");
	naptarKiir();
}
function evMinusz(){
	Ev--;
	evNaptaron.innerHTML=Ev;
	if(Ev==aktEv){
		honapNev_span[Ho].classList.remove("jelenleg_honap");
		Ho=aktHo;
		honapNev_span[Ho].classList.add("jelenleg_honap");
	}
	else{
		honapNev_span[Ho].classList.remove("jelenleg_honap");
		Ho=0;
		honapNev_span[Ho].classList.add("jelenleg_honap");
	}
	naptarKiir()
}
function evPlusz(){
	Ev++;
	evNaptaron.innerHTML=Ev;
	if(Ev==aktEv){
		honapNev_span[Ho].classList.remove("jelenleg_honap");
		Ho=aktHo;
		honapNev_span[Ho].classList.add("jelenleg_honap");
	}
	else{
		honapNev_span[Ho].classList.remove("jelenleg_honap");
		Ho=0;
		honapNev_span[Ho].classList.add("jelenleg_honap");
	}
	naptarKiir()
}

function EsemenyHozzaad(){
	esemenyAblak.style.display="block";
}
function kilepAblak(){
	datumEsemeny.value="";
	esemenyLeiras.value="";
	esemenyAblak.style.display="none";
}
function esemenyMent(){
	var esemenyLeiras1=esemenyLeiras.value.trim();
	esemenyLeiras.value=esemenyLeiras1;
	if(esemenyLeiras1!="" && datumEsemeny.value!=""){
		var esemenyDate=datumEsemeny.value;
		var esemenyEv="";
		var esemenyHonap="";
		var esemenyNap="";
		for(var i=0;i<4;i++){
			esemenyEv+=esemenyDate[i];
		}
		for(var i=5;i<7;i++){
			esemenyHonap+=esemenyDate[i];
		}
		for(var i=8;i<10;i++){
			esemenyNap+=esemenyDate[i];
		}
		var elsoNap=new Date(esemenyEv, esemenyHonap-1, 1);
		var utolsoNap=new Date(esemenyEv, esemenyHonap, 0);
		var e=elsoNap.getDay();
		if(e==0)
			e=6;
		else
			e--;
		var v=utolsoNap.getDate();
		esEvek[esEvek.length]=esemenyEv;
		esHonapok[esHonapok.length]=esemenyHonap;
		esNapok[esNapok.length]=esemenyNap;
		if(esEvek[esEvek.length-1]==Ev && esHonapok[esHonapok.length-1]==Ho+1){
			napok_span[Number(esemenyNap)-1+e].classList.add("van_esemeny");
			napok_span[Number(esemenyNap)-1+e].addEventListener("click", esemenyMegjelen);
		}
		esLeirasok[esLeirasokDB]=esemenyLeiras1;
		esLeirasok[esLeirasokDB+1]=datumEsemeny.value;
		esLeirasokDB+=2;
		kilepAblak();
	}
}

function esemenyMegjelen(){
	if(Ho<9 && this.innerHTML<9)
		datumErtek=Ev+"-0"+(Ho+1)+"-0"+this.innerHTML;
	else if(Ho<9 && this.innerHTML>9)
		datumErtek=Ev+"-0"+(Ho+1)+"-"+this.innerHTML;
	else if(Ho>8 && this.innerHTML<9)
		datumErtek=Ev+"-"+(Ho+1)+"-0"+this.innerHTML;
	else
		datumErtek=Ev+"-"+(Ho+1)+"-"+this.innerHTML;
	datumEsemeny.value=datumErtek;
	for(var i=0;i<esLeirasokDB;i++){
		if(i%2==1){
			if(esLeirasok[i]==datumErtek){
				esemenyLeiras.value=esLeirasok[i-1];
			}
		}
	}
	esemenyAblak.style.display="block";
}

function datumValtas(){
	var van=false;
	for(var i=0;i<esLeirasokDB;i++){
		if(i%2==1){
			if(esLeirasok[i]==this.value){
				esemenyLeiras.value=esLeirasok[i-1];
				van=true;
			}
		}
	}
	if(van==false){
		esemenyLeiras.value="";
	}
}
