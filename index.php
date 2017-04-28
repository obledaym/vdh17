<?php session_start();
include("../db.php"); 

if(!isset($_SESSION['user']) or ($_SESSION['autorisation']==false) or (!isset($_SESSION['droits'])))
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

<body>
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="gestion_dossard.php">Inscriptions</a></li>
        <?php if($_SESSION['droits']&1)
		{?><li class="dropdown">
            <a href="#">Gestion des dossards</a>
            <ul class="sub-menu">
                <li><a href="gestion_dossard.php?type=1">Vue générale</a></li>
                <li class="dropdown">
                    <a href="#">Par type</a>
                    <ul class="sub-menu">
                        <li><a href="gestion_dossard.php?type=2">Course</a></li>
						<li><a href="gestion_dossard.php?type=3">Marche</a></li>
                    </ul>
                </li>
				<li class="dropdown">
                    <a href="#">Par personne</a>
                    <ul class="sub-menu">
                        <li><a href="gestion_dossard.php?type=4">Nom</a></li>
						<li><a href="gestion_dossard.php?type=5">Mail</a></li>
						<li><a href="gestion_dossard.php?type=6">Short-tag</a></li>
                    </ul>
                </li>
            </ul>
        </li><?php } ?>
		<?php if($_SESSION['droits']&2)
		{?><li class="dropdown">
            <a href="#">Gestion des ventes</a>
            <ul class="sub-menu">
                <li><a href="trezo.php?type=1">Vue générale</a></li>
                <li class="dropdown">
                    <a href="#">Par type</a>
                    <ul class="sub-menu">
                        <li><a href="trezo.php?type=2">Etudiants</a></li>
						<li><a href="trezo.php?type=3">Exterieurs</a></li>
                    </ul>
                </li>
				<li class="dropdown">
                    <a href="#">Par personne</a>
                    <ul class="sub-menu">
                        <li><a href="trezo.php?type=4">Nom</a></li>
						<li><a href="trezo.php?type=5">Mail</a></li>
						<li><a href="trezo.php?type=6">Short-tag</a></li>
                    </ul>
                </li>
            </ul>
        </li><?php } ?>
		<?php if($_SESSION['droits']&4)
		{?>
	<li class="dropdown">
            <a href="#">Envoi d'un mail</a>
            <ul class="sub-menu">
                <li><a href="mail.php?type=1">Vue générale</a></li>
                <li class="dropdown">
                    <a href="#">Par type</a>
                    <ul class="sub-menu">
                        <li><a href="mail.php?type=2">Course</a></li>
						<li><a href="mail.php?type=3">Marche</a></li>
                    </ul>
                </li>
            </ul>
        </li><?php } ?>
		<li><a href="logout.php">Deconnexion</a></li>
    </ul>
</nav>
 <h1 class="title"> Récapitulatif des ventes </h1>
  <div id="container">
    <div class="pricetab">
      <h1> MARCHEURS </h1>
      <div class="price"> 
	  
        <h2 style="padding-top:0.8em;"><?php $reponse = $db->query('SELECT COUNT(*) AS nbmarcheurs FROM participants WHERE ((choix=2) and (payment=1)) ');
												$donnees = $reponse->fetch(); echo $donnees['nbmarcheurs'];$reponse->closeCursor();?>  </h2> 
      </div>
      <div class="infos">
        <!--<h3> Premium Profile Listing </h3>
        <h3> Unlimited File Access </h3>
        <h3> Free Appointments </h3>
        <h3> 0 Bonus Points every month</h3>
        <h3> Customizable Profile Page</h3>
        <h3> 1 month support</h3>!-->
      </div>
    </div>
    <div class="pricetab">
      <h1> COUREURS </h1>
      <div class="price"> 
	  <?php $reponse = $db->query('SELECT COUNT(*) AS nbcoureurs FROM participants WHERE ((choix=1) and (payment=1))');
												$donnees = $reponse->fetch();?>
        <h2 style="padding-top:0.8em;"> <?php echo $donnees['nbcoureurs'];$reponse->closeCursor();?></h2> 
      </div>
      <div class="infos">
         <!--<h3> Premium Profile Listing </h3>
        <h3> Unlimited File Access </h3>
        <h3> Free Appointments </h3>
        <h3> 0 Bonus Points every month</h3>
        <h3> Customizable Profile Page</h3>
        <h3> 1 month support</h3>!-->
      </div>
    </div>
    <div class="pricetabmid">
      <h1> PLACES VENDUES </h1>
      <div class="pricemid"> 
        <h2 style="padding-top:0.8em;"> <?php $reponse = $db->query('SELECT COUNT(*) AS nbtot FROM participants WHERE (payment=1)');
												$donnees = $reponse->fetch(); echo $donnees['nbtot'];$reponse->closeCursor();?> </h2> 
      </div>
      <div class="infos">
         <!--<h3> Premium Profile Listing </h3>
        <h3> Unlimited File Access </h3>
        <h3> Free Appointments </h3>
        <h3> 0 Bonus Points every month</h3>
        <h3> Customizable Profile Page</h3>
        <h3> 1 month support</h3>!-->
      </div>
      
    </div>
    <div class="pricetab">
      <h1> UTCEENS </h1>
      <div class="price"> 
        <h2 style="padding-top:0.8em;"> <?php $reponse = $db->query('SELECT COUNT(*) AS nbutc FROM participants WHERE ((login!="exterieur") and (payment=1))');
												$donnees = $reponse->fetch(); echo $donnees['nbutc'];$reponse->closeCursor();?> </h2> 
      </div>
      <div class="infos">
         <!--<h3> Premium Profile Listing </h3>
        <h3> Unlimited File Access </h3>
        <h3> Free Appointments </h3>
        <h3> 0 Bonus Points every month</h3>
        <h3> Customizable Profile Page</h3>
        <h3> 1 month support</h3>!-->
      </div>
      
    </div>
    <div class="pricetab">
      <h1> EXTERIEURS </h1>
      <div class="price"> 
        <h2 style="padding-top:0.8em;"> <?php $reponse = $db->query('SELECT COUNT(*) AS nbext FROM participants WHERE ((login="exterieur") and (payment=1))');
												$donnees = $reponse->fetch(); echo $donnees['nbext'];$reponse->closeCursor();?> </h2> 
      </div>
      <div class="infos">
         <!--<h3> Premium Profile Listing </h3>
        <h3> Unlimited File Access </h3>
        <h3> Free Appointments </h3>
        <h3> 0 Bonus Points every month</h3>
        <h3> Customizable Profile Page</h3>
        <h3> 1 month support</h3>!-->
      </div>
      
    </div>
  </div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js1/index.js"></script>

</body>
</html>