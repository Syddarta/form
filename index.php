<?php require 'traitement-se-syndiquer.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>

    <form class="container" action="" method="post" enctype="multipart/form-data">
      <?php if(!empty($erreur)) : ?>
        <?php echo "<div class='alert alert-danger'>" . "<p><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Votre candidature n'a pas pu être envoyée, car le formulaire contient l'erreur ou les erreurs suivantes :</p><ul>" ?>
            <?php if(isset($erreur['vide'])) echo "<li>" . $erreur['vide'] . "</li>"; ?>
            <?php if(isset($erreur['emailinvalide'])) echo "<li>" . $erreur['emailinvalide'] . "</li>"; ?>
            <?php if(isset($erreur['formatcv'])) echo "<li>" . $erreur['formatcv'] . "</li>"; ?>
            <?php if(isset($erreur['formatlettre'])) echo "<li>" . $erreur['formatlettre'] . "</li>"; ?>
            <?php if(isset($warning)) echo "<li>" . $warning . "</li>"; ?>
        <?php echo "</ul>" . "</div>"; ?>
      <?php endif; ?>

      <?php if(isset($success)) : ?>
        <?php echo "<div class='alert alert-success'>" ?>
          <?php if(isset($success)) echo $success; ?>
        <?php echo "</div>"; ?>
      <?php endif; ?>
      <div class="row">


        <div class="col-xs-12 col-sm-4 col-md-4 form-group">
          <label for="nom" class="<?php if(isset($erreur['nom'])) echo "has-error"; ?>">Nom :</label>
          <input type="text" class="form-control" id="nom" name="nom" value="<?php if(isset($nom)) echo $nom; ?>">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 form-group">
          <label for="prenom" class="<?php if(isset($erreur['prenom'])) echo "has-error"; ?>">Prénom :</label>
          <input type="text" class="form-control" id="prenom" name="prenom" value="<?php if(isset($prenom)) echo $prenom; ?>">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 form-group">
          <label for="email" class="<?php if(isset($erreur['email']) or isset($erreur['emailinvalide'])) echo "has-error"; ?>">Adresse mail :</label>
          <input type="mail" class="form-control" id="email" name="email" value="<?php if(isset($email)) echo $email; ?>">
        </div>


        <div class="col-xs-12 col-sm-12 col-md-6 form-group">
          <span class="fake-label <?php if(isset($erreur['cv']) or isset($erreur['formatcv'])) echo "has-error"; ?>">Veuillez joindre votre CV : (.pdf, .doc, .docx)</span>
          <input type="file" name="cv" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} fichiers sélectionnés" multiple>
          <label for="file-1"><i class="fa fa-upload" aria-hidden="true"></i> <span>Choisir un fichier</span></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 form-group">
          <span class="fake-label <?php if(isset($erreur['lettre']) or isset($erreur['formatlettre'])) echo "has-error"; ?>">Veuillez joindre votre lettre de motivation : (.pdf, .doc, .docx)</span>
          <input type="file" name="lettre" id="file-2" class="inputfile inputfile-1" data-multiple-caption="{count} fichiers sélectionnés" multiple>
          <label for="file-2"><i class="fa fa-upload" aria-hidden="true"></i> <span>Choisir un fichier</span></label>
        </div>
      </div>
      <input class="btn btn-red" type="submit" name="sesyndiquersubmit" value="se syndiquer">
    </form>
    <script type="text/javascript" src="js/file-input.js"></script>
  </body>
</html>
