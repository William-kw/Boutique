<?php
    session_start();
    $recette = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Recette</title>
</head>
<body>
    <?php
        include("menu.php");

        if (isset($_GET["idrec"])) {
            $idrec= $_GET["idrec"];
            $req= $connexion->prepare("SELECT R.ID_REC AS ID_REC, ID_JR, MONTANT_REC, DATE_JR FROM recettes R, journees J WHERE R.ID_REC=J.ID_REC AND R.ID_REC= ?");
            $req->execute(array($idrec));
            $aff= $req->fetch();
        }
    ?>
    <div class="content">
        <a href="recette.php" class="ajouter">Annuler</a> 
        <div class="modif-form">
            <h2>Modifier la recette</h2>
            <div class="erreur"></div>
            <form action="" method="">
                <input type="hidden" value="<?= $aff["ID_JR"]; ?>" name="idjr">
                <input type="hidden" value="<?= $aff["ID_REC"]; ?>" name="idrec">
                <input type="date" name="date_rec" id="date_rec" placeholder="date_rec" value="<?= $aff["DATE_JR"]; ?>" autocomplete="off">
                <input type="text" name="montant_rec" id="montant_rec" placeholder="montant_rec" value="<?= $aff["MONTANT_REC"]; ?>" autocomplete="off">
                <input type="submit" name="recette_mod" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>