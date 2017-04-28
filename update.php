<?php
session_start();
include("../db.php"); 
if(!isset($_SESSION['user']) and ($_SESSION['autorisation']==false) and (!($_SESSION['droits']&1)))
{
    header('Location: login-etu2.php');
    exit();
	}

if ($_GET['mail']==1 )
{
  //On envoie la place par mail au nouveau coureur
$file = "../billetterie/billet_inscription"."/".$_SESSION['shortag'].".pdf";
    $filename = $_SESSION['shortag'].'.pdf';
    $mailto = $_SESSION['mail'];
    $subject = 'Votre place pour la Voie du Houblon';
$message = "Veuillez trouver ci-joint votre place pour la Voie du Houblon.\r\n";
    $message .= "Cette place devra être présentée le jour de la course pour faciliter la remise du dossard.\r\n Pensez à l'enregistrer sur votre téléphone ou à l'imprimer.";
    $message .= "\r\nLa voie du Houblon.\r\n \r\n \r\n-------------------Ceci est un mail automatique, merci de ne pas répondre-------------------\r\n \r\n En cas de problème merci de contacter : lavoieduhoublon-inscription@assos.utc.fr";
    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: La Voie du Houblon <lavoieduhoublon@assos.utc.fr>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        echo "mail send ... OK"; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
        print_r( error_get_last() );
    }  
//On envoie un mail à l'ancien pour lui dire qu'il n'a plus sa place

    $destinataire = $_SESSION['old_mail'];
                    $sujet = "Confirmation échange de place." ;
                    
                    //Headers pour faire passer du html en utf-8 + spécifier envoyeur
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'From: La Voie du Houblon <lavoieduhoublon-inscription@assos.utc.fr>' . "\r\n";
         
                    // Le lien d'activation est composé du login(log) et de la clé(cle)
                    $message = 'Bonjour,<br /><br />

                    Votre place pour la 3ème édition de la Voie du Houblon a bien été échangée.<br />
                    Le nouveau propriétaire de la place est '.$_SESSION['prenom'].' '.$_SESSION['nom'].'<br />
                    Il a normalement reçu un mail avec sa place.<br />
                    En cas de problème merci de répondre à ce mail<br />
                    La Voie du Houblon 2017';
         
         
                    mail($destinataire, $sujet, $message, $headers) ; // Envoi du mail 
                    unset($_SESSION['shortag']);
unset($_SESSION['mail']);
unset($_SESSION['old_mail']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
}
else {
        $_SESSION['shortag']=$_POST['shortag'];
    $_SESSION['mail']=$_POST['email'];
    $_SESSION['old_mail']=$_POST['old_mail'];
    $_SESSION['nom']=$_POST['nom'];
    $_SESSION['prenom']=$_POST['prenom'];
$update = $db->prepare('
            UPDATE `participants` 
            SET `nom`=:nom,`prenom`=:prenom,`login`=:login,`sexe`=:sexe, `mail`=:mail,`date_naissance`=:date_naissance,`choix`=:choix,`objectif`=:objectif WHERE `shortag`=:shortag
            ');
		$update->bindParam(':shortag',$_POST['shortag'],PDO::PARAM_STR);
		$update->bindParam(':nom',$_POST['nom'],PDO::PARAM_STR);
        $update->bindParam(':prenom',$_POST['prenom'],PDO::PARAM_STR);
        $update->bindParam(':login',$_POST['login'],PDO::PARAM_STR);
		$update->bindParam(':sexe',$_POST['sexe'],PDO::PARAM_INT);
        $update->bindParam(':mail',$_POST['email'],PDO::PARAM_STR);
        $update->bindParam(':date_naissance',$_POST['date'],PDO::PARAM_STR);
        $update->bindParam(':choix',$_POST['choix'],PDO::PARAM_INT);
        $update->bindParam(':objectif',$_POST['objectif'],PDO::PARAM_INT);
		$update->execute();

		}
        $shortag=$_POST['shortag'];
        //On crée la place en pdf
        $info = $db->query('SELECT * FROM `participants` WHERE `shortag`="' . $shortag . '"');
    $coureur=$info->fetch();
    $nom=$coureur['nom'];
    $prenom=$coureur['prenom'];
    if ($coureur['choix']==1)
    {$type="Course";
    $heure="14h30";}
    else
    {$type="Marche";
    $heure="13h30";}
    //On crée le pdf
require('../billetterie/fpdf/src/fpdf/FPDF.php');
$pdf = new \fpdf\FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->Image('../images/place.jpg', 0, 0, 210, 297);
$pdf->SetFont('Arial','B',16);
$pdf->Text(108, 42,$nom );
$pdf->Text(108, 58,$prenom );
$pdf->Text(108, 73,$type );
$pdf->Text(150, 73,$heure );
$pdf->SetFontSize(28);
$pdf->Text(130, 95,$shortag );
//$pdf->Output($shortag.".pdf",'I');
$pdf->Output("../billetterie/billet_inscription/".$shortag.".pdf",'F');

//
		
?>
<p>Changement validé.</p>
<input type='button' value='Envoyer un mail' onclick='window.location="update.php?mail=1"'></td>
<br><a href="gestion_dossard.php">Retour</a>