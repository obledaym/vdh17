<?php session_start();
include("../db.php"); 

if(!isset($_SESSION['user']) or ($_SESSION['autorisation']==false) or (!($_SESSION['droits']&2)))
{
    header('Location: login-etu2.php');
    exit();
	}?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Gestion des ventes</title>
  
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
  
  <h1>Liste des ventes  <?php switch($_GET['type'])
                    {
						case 1:  break;
						case 2: echo "-  Etudiants"; break;
					    case 3: echo "-  Exterieurs"; break; 
						default: break;} 
													
?></h1>

<p><?php switch($_GET['type'])
                    {
						case 4: ?><form method="post" action="trezo.php?type=4">
<input type="text" name="nom" id="nom" required value="Nom"/>
<input type="submit" name="envoi" id="envoie"  value="Rechercher" />	
</form><?php					break;
						case 5: ?><form method="post" action="trezo.php?type=5">
<input type="text" name="nom" id="nom" required value="Mail" />
<input type="submit" name="envoi" id="envoie"  value="Rechercher" />	
</form><?php break;
					    case 6: ?><form method="post" action="trezo.php?type=6">
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
          <th>Mail</th>
		  <th>Date d'achat</th>
          <th>Montant</th>
		  <th>ID transaction</th>
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
						case 2: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`login`!="exterieur")'); break;
					    case 3: $reponse = $db->query('SELECT * FROM participants WHERE (`payment`=1) and (`login`="exterieur")'); break; 
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
         <td><?php echo $donnees['mail'];?></td>
		 <td><?php echo $donnees['date'];?></td>
		 <td><?php echo $donnees['price']." €"; ?></td>
		 <td><?php echo $donnees['tra_id']; ?></td>
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
