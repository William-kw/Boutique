<?php
    session_start();
    $fournisseur = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Fournisseur</title>
</head>
<body>
    <?php
        include("menu.php");

        if (isset($_GET["idfr"])) {
            $idfr= $_GET["idfr"];
            $req= $connexion->prepare("SELECT * FROM fournisseurs WHERE ID_FR= ?");
            $req->execute(array($idfr));
            $aff= $req->fetch();
        }
    ?>
    <div class="content">
        <a href="fournisseur.php" class="ajouter">Annuler</a> 
        <div class="modif-form">
            <h2>Modifier le fournisseur</h2>
            <div class="erreur"></div>
            <form action="" method="">
                <input type="hidden" value="<?= $aff["ID_FR"]; ?>" name="idfr">
                <input type="text" name="fournisseur" id="fournisseur" placeholder="Fournisseur" value="<?= $aff["FOURNISSEUR"]; ?>" autocomplete="off">
                <input type="submit" name="fournisseur_mod" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>