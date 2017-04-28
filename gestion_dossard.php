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
  <title>Gestion dossards</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
      <link rel="stylesheet" href="css1/style.css">

  
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
  <section>
  <!--for demo wrap-->
  
  <h1>Liste des participants  <?php switch($_GET['type'])
                    {
						case 1:  break;
						case 2: echo "-  Course"; break;
					    case 3: echo "-  Marche"; break; 
						default: break;} 
													
?></h1>

<p><?php switch($_GET['type'])
                    {
						case 4: ?><form method="post" action="gestion_dossard.php?type=4">
<input type="text" name="nom" id="nom" required value="Nom"/>
<input type="submit" name="envoi" id="envoie"  value="Rechercher" />	
</form><?php					break;
						case 5: ?><form method="post" action="gestion_dossard.php?type=5">
<input type="text" name="nom" id="nom" required value="Mail" />
<input type="submit" name="envoi" id="envoie"  value="Rechercher" />	
</form><?php break;
					    case 6: ?><form method="post" action="gestion_dossard.php?type=6">
<input type="text" name="nom" id="nom" required value="Short-tag" />
<input type="submit" name="envoi" id="envoie"  value="Rechercher" />	
					</form><?php break; } ?></p><br>
  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th>Shorttag</th>
          <th>Nom</th>
          <th>Prénom</th>
          <?php if($_SESSION['droits']&1)
    {?>
          <th>Mail</th>
          <?php } ?>
          <th>Date de naissance</th>
		  <th>Choix</th>
          <th>Objectif</th>
		  <?php if($_SESSION['droits']&1)
		{?><th></th><th></th><?php } ?>
        </tr>
      </thead>
    </table>
  </div>

  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
	  <?php switch($_GET['type'])
                    {
						case 1: $reponse = $db->query('SELECT * FROM participants WHERE (payment=1)'); break;
						case 2: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`choix`=1)'); break;
					    case 3: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`choix`=2)'); break; 
						case 4: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`nom`="'.$_POST['nom'].'")'); break;
					    case 5: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`mail`="'.$_POST['nom'].'")'); break;
						case 6: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`shortag`="'.$_POST['nom'].'")'); break;
						default:$reponse = $db->query('SELECT * FROM participants WHERE (payment=1)'); break;} 
													while ($donnees = $reponse->fetch())
{
?>
        <tr>
         <td><?php echo $donnees['shortag'];?></td>
         <td><?php echo $donnees['nom'];?></td>
         <td><?php echo $donnees['prenom'];?></td>
         <?php if($_SESSION['droits']&1)
    {?>
         <td><?php echo $donnees['mail'];?></td>
         <?php } ?>
		 <td style="text-align:center;"><?php echo $donnees['date_naissance'];?></td>
		 <td><?php switch($donnees['choix'])
                    {
                        case 1: echo "Course"; break;
                        case 2: echo "Marche"; break;
                    } ?></td>
         <td><?php switch($donnees['objectif'])
                    {
                        case 1: echo "1h-2h"; break;
                        case 2: echo "2h-3h"; break;
						case 3: echo "+3h"; break;
                    } ?></td>
 <?php if($_SESSION['droits']&1)
		{?><td align="center"><input type='button' value='Modifier' onclick='window.location="modif.php?shortag=<?php echo $donnees['shortag'];?>"'></td>		
        <td align="center"><input type='button' value='Place PDF' onclick='window.open("../billetterie/billet_inscription/<?php echo $donnees['shortag'];?>.pdf")'></td><?php } ?> 
        </tr>
		<?php }
														$reponse->closeCursor();?>
      </tbody>
    </table>
  </div>
</section>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js1/index.js"></script>

</body>
</html>
