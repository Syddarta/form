<?php
if(isset($_POST['sesyndiquersubmit'])){
  extract($_POST);

  $erreur = [];


  if(empty($nom) or empty($prenom) or empty($email) or empty($_FILES['cv']['name']) or empty($_FILES['lettre']['name'])){
    $erreur['vide'] = "Tous les champs n'ont pas été remplit";
  }
  if(empty($nom)){
    $erreur['nom'] = [];
  }
  if(empty($prenom)){
    $erreur['prenom'] = [];
  }
  if(empty($email)){
    $erreur['email'] = [];
  }
  if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreur['emailinvalide'] = "l'adresse email saisie est invalide";
  }


  if(empty($_FILES['cv']['name'])){
    $erreur['cv'] = [];
  }

  if(empty($_FILES['lettre']['name'])){
    $erreur['lettre'] = [];
  }


  // traitement du champ CV
  if(!empty($_FILES['cv']['name'])){

    $warning = "En cas d'erreur, par sécurité, les champs CV et lettre de motivation ont été vidés, veuillez les soumettre de nouveau";

  }
  $file_name_cv = $_FILES['cv']['name'];
  $temp_name_cv = $_FILES['cv']['tmp_name'];
  $file_type_cv = $_FILES['cv']['type'];
  $base = basename($file_name_cv);
  $extension = substr($base, strlen($base)-4, strlen($base));

  $allowed_extensions = array(".doc", "docx", ".pdf");

  if(!empty($_FILES['cv']['name']) && !in_array($extension, $allowed_extensions)){
    $erreur['formatcv'] = "Mauvais format pour CV";
  }




  // traitement du champ lettre de motivation
  if(!empty($_FILES['lettre']['name'])){

    $warning = "En cas d'erreur, par sécurité, les champs CV et lettre de motivation ont été vidés, veuillez les soumettre de nouveau";

  }
  $file_name_lettre = $_FILES['lettre']['name'];
  $temp_name_lettre = $_FILES['lettre']['tmp_name'];
  $file_type_lettre = $_FILES['lettre']['type'];
  $base = basename($file_name_lettre);
  $extension = substr($base, strlen($base)-4, strlen($base));

  $allowed_extensions = array(".doc", "docx", ".pdf", ".png");

  if(!empty($_FILES['lettre']['name']) && !in_array($extension, $allowed_extensions)){
    $erreur['formatlettre'] = "Mauvais format pour la lettre de motivation";
  }




  if(!$erreur){
    unset($warning);

    require 'phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->addAddress('imbertsebastiendev@gmail.com', 'Service Pro Securite');
    $mail->setFrom( $email, 'Candidature');
    $mail->Subject = "Service Pro Securite - Candidature";
    $mail->isHTML(true);
    $mail->Body = "Bonjour, vous avez reçu une candidature de " . "<b>" . $civilite . "</b>". ' ' . "<b>" . $nom . "</b>" . ' ' . "<b>" . $prenom . "</b>.<br>";

    // ajout de la pièce jointe CV
    $mail->addAttachment( $_FILES['cv']['tmp_name'], $_FILES['cv']['name'], 'base64', $_FILES['cv']['type'] );

    // ajout de la pièce jointe lettre de motivation
    $mail->addAttachment( $_FILES['lettre']['tmp_name'], $_FILES['lettre']['name'], 'base64', $_FILES['lettre']['type'] );

    // envoi
    if($mail->send()){
      $mail2 = new PHPMailer();
      $mail2->CharSet = 'UTF-8';
      $mail2->addAddress($email, 'Service Pro Securite');
      $mail2->setFrom( 'iimbertsebastiendev@gmail.com', 'Service Pro Securite');
      $mail2->Subject = "Service Pro Securite - Candidature";
      $mail2->isHTML(true);
      $mail2->Body = "<img src='http://sebastien-imbert.fr/img/cgt_suez_eau_france.jpg'><h1>Nous y répondrons bientot</h1>";

      $mail2->send();
    }


    $success = "Votre candidature a bien été envoyée, vous allez recevoir sous peu un mail vous le confirmant.";



  }
}
