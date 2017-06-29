<?php
if(isset($_POST['sesyndiquersubmit'])){
  extract($_POST);

  $erreur = [];


  if(empty($nom) or empty($prenom) or empty($email) or empty($_FILES['fiche']['name']) or empty($_FILES['rib']['name'])){
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


  if(empty($_FILES['fiche']['name'])){
    $erreur['fiche'] = [];
  }

  if(empty($_FILES['rib']['name'])){
    $erreur['rib'] = [];
  }


  // traitement du champ Fiche de paie
  if(!empty($_FILES['fiche']['name'])){

    $warning = "En cas d'erreur, par sécurité, les champs fiche de paie et RIB ont été vidés, veuillez les soumettre de nouveau";

  }
  $file_name_fiche = $_FILES['fiche']['name'];
  $temp_name_fiche = $_FILES['fiche']['tmp_name'];
  $file_type_fiche = $_FILES['fiche']['type'];
  $base = basename($file_name_fiche);
  $extension = substr($base, strlen($base)-4, strlen($base));

  $allowed_extensions = array(".doc", "docx", ".pdf", ".jpg"); // ici les format acceptés, si format de 4 lettres, ne pas mettre de "." devant

  if(!empty($_FILES['fiche']['name']) && !in_array($extension, $allowed_extensions)){
    $erreur['formatfiche'] = "Mauvais format pour le champ fiche de paie";
  }




  // traitement du champ RIB
  if(!empty($_FILES['rib']['name'])){

    $warning = "En cas d'erreur, par sécurité, les champs fiche de paie et RIB ont été vidés, veuillez les soumettre de nouveau";

  }
  $file_name_rib = $_FILES['rib']['name'];
  $temp_name_rib = $_FILES['rib']['tmp_name'];
  $file_type_rib = $_FILES['rib']['type'];
  $base = basename($file_name_rib);
  $extension = substr($base, strlen($base)-4, strlen($base));

  $allowed_extensions = array(".doc", "docx", ".pdf", ".jpg");

  if(!empty($_FILES['rib']['name']) && !in_array($extension, $allowed_extensions)){
    $erreur['formatrib'] = "Mauvais format pour le champ RIB";
  }




  if(!$erreur){
    unset($warning);

    require 'phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->addAddress('imbertsebastiendev@gmail.com', 'CGT Suez Eau France');
    $mail->setFrom( $email, 'Candidature');
    $mail->Subject = "Un utilisateur souhaite se syndiquer";
    $mail->isHTML(true);
    $mail->Body = "Bonjour, vous avez reçu une demande d'un utilisateur souhaitant se syndiquer.<br>" . "<b>" . $nom . "</b>" . ' ' . "<b>" . $prenom . "</b><br>";
    $mail->Body .= "<b>" . $email . "</b>";

    // ajout de la pièce jointe fiche de paie
    $mail->addAttachment( $_FILES['fiche']['tmp_name'], $_FILES['fiche']['name'], 'base64', $_FILES['fiche']['type'] );

    // ajout de la pièce jointe RIB
    $mail->addAttachment( $_FILES['rib']['tmp_name'], $_FILES['rib']['name'], 'base64', $_FILES['rib']['type'] );

    $mail->send();

    // envoi du mail chez l'utilisateur
    if($mail->send()){
      $mail2 = new PHPMailer();
      $mail2->CharSet = 'UTF-8';
      $mail2->addAddress($email, 'CGT Suez Eau France');
      $mail2->setFrom( 'imbertsebastiendev@gmail.com', 'CGT Suez Eau France'); // le mail devra être remplacer par le mail de l'admin de la région
      $mail2->Subject = "CGT Suez Eau France - Nous avons bien reçu votre demande";
      $mail2->isHTML(true);
      $mail2->Body = "Ici le texte du mail que l'utilisateur reçoit";

      $mail2->send();
    }


    $success = "Votre demande a bien été envoyée, vous allez recevoir sous peu un mail vous le confirmant.";

    unset($_POST);
    unset($_FILES);
  }
}
