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
  <title>Stand</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
      <link rel="stylesheet" href="css1/style.css">

  
</head>
<script>function UserAction() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://vdh.crichard.fr/api/courses/", false);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send();
	var response = JSON.parse(xhttp.responseText)[1];
	var formatted = new Date(response.starttime).toISOString().slice(11, 19).replace('T',' ');
	document.getElementById("chrono2").innerHTML = formatted2;
	var response2 = JSON.parse(xhttp.responseText)[2];
	var formatted2 = new Date(response2.starttime).toISOString().slice(11, 19).replace('T',' ');
	
	document.getElementById("chrono1").innerHTML = setInterval(difheure(formatted), 3000);
}
</script>
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
						<li><a href="live_dossard.php?type=6">Short-tag</a></li>
                    </ul>
                </li>
            </ul>
        </li>
		<li class="dropdown">
            <a href="#">STANDS</a>
            <ul class="sub-menu">
                <li><a href="stand.php?type=1">STAND 1</a></li>
				<li><a href="trezo.php?type=1">STAND 2</a></li>
				<li><a href="trezo.php?type=1">STAND 3</a></li>
				<li><a href="trezo.php?type=1">ARRIVÉE</a></li>
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
<section>
  <!--for demo wrap-->
  
  <h1>Liste des participants</h1>


  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th>Place</th>
          <th>Nom</th>
          <th>Prénom</th>
        </tr>
      </thead>
    </table>
  </div>

  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
        <tr>
         <td>a</td>
         <td>a</td>
         <td>a</td>
        </tr>
    
      </tbody>
    </table>
  </div>
</section>
<div id="chrono1"><script>UserAction();</script></div><br>
<div id="chrono2"><script>UserAction();</script></div>

 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js1/index.js"></script>

</body>
</html>