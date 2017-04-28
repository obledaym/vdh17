<?php session_start();
include("../db.php"); 

if(!isset($_SESSION['user']) and ($_SESSION['autorisation']==false))
{
    header('Location: login-etu2.php');
    exit();
	}?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Accueil</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
	  <link rel="stylesheet" href="css1/index.css">
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  
</head>
<script>function UserAction() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://vdh.crichard.fr/api/courses/", false);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send();
	var response = JSON.parse(xhttp.responseText)[1];
	var formatted = new Date(response.starttime).toISOString().slice(11, 19).replace('T',' ');
	
	var response2 = JSON.parse(xhttp.responseText)[2];
	var formatted2 = new Date(response2.starttime).toISOString().slice(11, 19).replace('T',' ');
	document.getElementById("chrono2").innerHTML = formatted2;
	document.getElementById("chrono1").innerHTML = setInterval(difheure(formatted), 3000);
}
//---------------------------------
 	//Difference heures
	function difheure(heuredeb)
	{
		var heurefin =new Date(heure, minute, seconde)
	   hd=heuredeb.split(":");
	   hf=heurefin.split(":");
	   hd[0]=eval(hd[0]);hd[1]=eval(hd[1]);hd[2]=eval(hd[2]);
	   hf[0]=eval(hf[0]);hf[1]=eval(hf[1]);hf[2]=eval(hf[2]);
	   if(hf[2]<hd[2]){hf[1]=hf[1]-1;hf[2]=hf[2]+60;}
	   if(hf[1]<hd[1]){hf[0]=hf[0]-1;hf[1]=hf[1]+60;}
	   if(hf[0]<hd[0]){hf[0]=hf[0]+24;}
	   //return((hf[0]-hd[0]) + ":" + (hf[1]-hd[1])); // + ":" + (hf[2]-hd[2]));
	   return((hf[0]-hd[0])*60 + (hf[1]-hd[1]));
	}
/*function loadXMLDoc() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      myFunction(this);
    }
  };
  xmlhttp.open("GET", "cd_catalog.xml", true);
  xmlhttp.send();
}
function myFunction(xml) {
  var i;
  var response = JSON.parse(xhttp.responseText);
  var table="<tr><th>id</th><th>starttime</th></tr>";
  var x = xmlDoc.getElementsByTagName("id");
  for (i = 0; i <x.length; i++) { 
    table += "<tr><td>" +
    x[i].getElementsByTagName("id")[0].childNodes[0].nodeValue +
    "</td><td>" +
    x[i].getElementsByTagName("starttime")[0].childNodes[0].nodeValue +
    "</td></tr>";
  }
  document.getElementById("test").innerHTML = table;
}
$.get( 'http://vdh.crichard.fr/api/users', function(data) { //faisCeQueTuEnVeux });*/</script>
<body>
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="gestion_dossard.php">Affichage Arrivée</a></li>
      <li class="dropdown">
            <a href="#">Gestion des participants</a>
            <ul class="sub-menu">
                <li><a href="live_gestion_dossard.php?type=1">Vue générale</a></li>
                <li class="dropdown">
                    <a href="#">Par type</a>
                    <ul class="sub-menu">
                        <li><a href="live_gestion_dossard.php?type=2">Course</a></li>
						<li><a href="live_gestion_dossard.php?type=3">Marche</a></li>
                    </ul>
                </li>
				<li class="dropdown">
                    <a href="#">Par personne</a>
                    <ul class="sub-menu">
                        <li><a href="live-gestion_dossard.php?type=4">Nom</a></li>
						<li><a href="live_gestion_dossard.php?type=5">Mail</a></li>
						<li><a href="live_gestion_dossard.php?type=6">Short-tag</a></li>
                    </ul>
                </li>
            </ul>
        </li>
		<li class="dropdown">
            <a href="#">STANDS</a>
            <ul class="sub-menu">
                <li><a href="stand.php">STAND 1</a></li>
				<li><a href="stand.php?type=1">STAND 2</a></li>
				<li><a href="stand.php?type=1">STAND 3</a></li>
				<li><a href="stand.php?type=1">ARRIVÉE</a></li>
                <!--<li class="dropdown">
                    <a href="#">Par type</a>
                    <ul class="sub-menu">
                        <li><a href="trezo.php?type=2">Course</a></li>
						<li><a href="trezo.php?type=3">Marche</a></li>
                    </ul>
                </li>
				<li class="dropdown">
                    <a href="#">Par personne</a>
                    <ul class="sub-menu">
                        <li><a href="trezo.php?type=4">Nom</a></li>
						<li><a href="trezo.php?type=5">Mail</a></li>
						<li><a href="trezo.php?type=6">Short-tag</a></li>
                    </ul>
                </li>!-->
            </ul>
        </li>
		<li><a href="logout.php" >Deconnexion</a></li>
    </ul>
</nav>
<!--<button type="submit" onclick="UserAction()">Search</button>!-->

<div id="chrono1"><script>UserAction();</script></div><br>
<div id="chrono2"><script>UserAction();</script></div>

<?php
$h1=strtotime("12:30:33");
$h2=strtotime(Date('H:i:s'));
echo gmdate('H:i:s',$h1-$h2);
?>

 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js1/index.js"></script>

</body>
</html>
