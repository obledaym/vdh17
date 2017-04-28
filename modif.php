<?php session_start();
include("../db.php"); 
if(!isset($_SESSION['user']) and ($_SESSION['autorisation']==false) and (!($_SESSION['droits']&1)))
{
    header('Location: login-etu2.php');
    exit();
	}
    
$reponse = $db->query('SELECT * FROM participants WHERE shortag = "' . $_GET['shortag'] . '" ');
$user=$reponse->fetch();
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Modification </title>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  
  
      <link rel="stylesheet" href="css/style.css">

  
</head>
<body>
  <body>
  <form method="post" action="update.php">
	    <h1>Informations de la personne à modifier :</h1>
    <div class="contentform">


    	<div class="leftcontact">
			      <div class="form-group">
			        <p>Nom<span>*</span></p>
			        <span class="icon-case"><i class="fa fa-user"></i></span>
				        <input type="text" name="nom" id="nom" data-rule="required" value="<?php echo $user['nom'];?>" data-msg="Vérifiez votre saisie sur les champs : Le champ 'Nom' doit être renseigné." required />
			<div class="validation"></div>
       </div> 

            <div class="form-group">
            <p>Prénom <span>*</span></p>
            <span class="icon-case"><i class="fa fa-user"></i></span>
				<input type="text" name="prenom" id="prenom" data-rule="required" value="<?php echo $user['prenom'];?>" data-msg="Vérifiez votre saisie sur les champs : Le champ 'Prénom' doit être renseigné." required />
                <div class="validation"></div>
			</div>

			<div class="form-group">
			<p>Login :</p>
			<span class="icon-case"><i class="fa fa-user"></i></span>
				<input type="text" name="login" id="login"  value="<?php echo $user['login'];?>"data-msg="Vérifiez votre saisie sur les champs : Le champ 'login' doit être renseigné." required />
                <div class="validation"></div>
			</div>
			
			<div class="form-group">
			<p>E-mail <span>*</span></p>	
			<span class="icon-case"><i class="fa fa-envelope-o"></i></span>
                <input type="email" name="email" id="email"  value="<?php echo $user['mail'];?>" data-msg="Vérifiez votre saisie sur les champs : Le champ 'E-mail' est obligatoire." required />
                <div class="validation"></div>
			</div>	
			<input type="hidden" id="old_mail" name="old_mail" value="<?php echo $user['mail'];?>" />
			



	</div>

	<div class="rightcontact">	

			<div class="form-group">
			<p>Course <span>*</span></p>
			<span class="icon-case"><i class="fa fa-building-o"></i></span>
			<select class="select" name="choix" id="choix">
           <option <?php if ($user['choix']==1){echo 'selected="selected"';} ?> value="1">Course</option>
           <option <?php if ($user['choix']==2){echo 'selected="selected"';} ?> value="2">Marche</option>
       </select>
                <div class="validation"></div>
			</div>	

			<div class="form-group">
			<p>Objectif <span>*</span></p>	
			<span class="icon-case"><i class="fa fa-building-o"></i></span>
			<select class="select" name="objectif" id="objectif">
           <option <?php if ($user['objectif']==1){echo 'selected="selected"';} ?> value="1">1h-2h</option>
           <option <?php if ($user['objectif']==2){echo 'selected="selected"';} ?> value="2">2h-3h</option>
		   <option <?php if ($user['objectif']==3){echo 'selected="selected"';} ?> value="3">Plus de 3h</option>
       </select>
            
				<div class="validation"></div>
			</div>
			<div class="form-group">
			<p>Date de naissance <span>*</span></p>
			<span class="icon-case"><i class="fa fa-home"></i></span>
				<input type="text" name="date" id="date"  value="<?php echo $user['date_naissance'];?>"data-msg="Vérifiez votre saisie sur les champs : Le champ 'date de naissance' doit être renseigné." required />
                <div class="validation"></div>
			</div>
			<div class="form-group">
			<p>Sexe <span>*</span></p>	
			<span class="icon-case"><i class="fa fa-user"></i></span>
			<select class="select" name="sexe" id="sexe">
           <option <?php if ($user['sexe']==1){echo 'selected="selected"';} ?> value="1">Homme</option>
           <option <?php if ($user['sexe']==2){echo 'selected="selected"';} ?> value="2">Femme</option>
       </select>
            
				<div class="validation"></div>
			</div>
			<input type="hidden" name="shortag" id="shortag"  value="<?php echo $user['shortag'];?>" />
			<!--<div class="form-group">
			<p>Short-tag :</p>
			<span class="icon-case"><i class="fa fa-id-card"></i></span>
				<span class="select" ><p><?php echo $user['shortag'];?></p></span>
				
                <div class="validation"></div>
			</div>!-->
			
		
	</div>
	</div>
	<?php 
														$reponse->closeCursor();?>
<button type="submit" class="bouton-contact">Modifier</button>
	
</form>	

  
</body>
</html>
  
    <script src="js/index.js"></script>

</body>
</html>
