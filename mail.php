<!DOCTYPE html>
<?php 
session_start();
include("../db.php"); 
if(!isset($_SESSION['user']) or ($_SESSION['autorisation']==false) or (!($_SESSION['droits']&4)))
{
    header('Location: login-etu2.php');
    exit();
	}
    ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Envoi de mail</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
	  <link rel="stylesheet" href="css1/index.css">
        <!-- Make sure the path to CKEditor is correct. -->
        <script src="./ckeditor/ckeditor.js"></script>
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
	<?php switch($_GET['type'])
                    {
						case 1: $user = $db->query('Select `mail` FROM participants WHERE (`payment`=1)'); break;
						case 2: $user = $db->query('Select `mail` FROM participants WHERE (`payment`=1) and (`choix`=1)'); break;
					    case 3: $user = $db->query('Select `mail` FROM participants WHERE (`payment`=1) and (`choix`=2)'); break; 
						/*case 4: $reponse = $db->query('Select `mail` FROM participants WHERE (`payment`=1) and (`nom`="'.$_POST['nom'].'")'); break;
					    case 5: $reponse = $db->query('Select `mail` FROM participants WHERE (`payment`=1) and (`mail`="'.$_POST['nom'].'")'); break;
						case 6: $reponse = $db->query('Select `mail` FROM participants WHERE (`payment`=1) and (`shortag`="'.$_POST['nom'].'")'); break;
						default:$reponse = $db->query('Select `mail` FROM participants WHERE (payment=1)'); break;*/} 
		
		if(isset($_POST['editor1'])){
		if(isset($_POST['objet'])) $sujet = $_POST['objet'];
			else			
			$sujet = "[La Voie du Houblon] Mail d'information";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: La Voie du Houblon <lavoieduhoublon@assos.utc.fr>' . "\r\n";


    //si le mail existe (= n'a pas été déjà traité)
        $destinataire = "obledaym@etu.utc.fr";
        $message = $_POST['editor1'];
		$message .='Ceci est un mail automatique, merci de ne pas répondre.';
        while($result = $user->fetch(PDO::FETCH_ASSOC)){
       	   mail($result['mail'], $sujet, $message, $headers);
        //	 mail($destinataire, $sujet, $message, $headers);

		}
		echo '<p style="padding-left:2em; color:white"> Le mail a bien ete envoye.</p>';
		}
		else{
	?>
<h1 class="title"> Envoi d'un mail a tous les <?php switch($_GET['type'])
                    {
						case 1:  echo "participants"; break;
						case 2: echo "coureurs"; break;
					    case 3: echo "marcheurs"; break; 
						default: break;} 
													
?> </h1>
<br><br>       
	 <form action = "mail.php?type=<?php echo $_GET['type']; ?>" method = "post">
	 <p style="padding-left:2em; color:white"> Objet du mail : <input type="text" name="objet" id ="objet" value = "[La Voie du Houblon]" style="width:30em;" > </p>
	 <br><br>
            <textarea name="editor1" id="editor1" rows="10" cols="80" style="width:75em;">
                
            </textarea>
            <script>
		CKEDITOR.config.skin = 'office2013';

                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
			<br><br>
<INPUT  TYPE = "Submit" Name = "Submit1" VALUE = "Envoyer le mail" style="margin-left:2em;">


        </form>
	<?php } ?>
	  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js1/index.js"></script>

    </body>
</html>
