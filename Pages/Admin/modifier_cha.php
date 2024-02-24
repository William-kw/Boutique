<?php
    session_start();
    $charge = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Charge</title>
</head>
<body>
    <?php
        include("menu.php");
        if (isset($_GET["idch"])) {
            $idch= $_GET["idch"];
            $req= $connexion->prepare("SELECT * FROM charges WHERE ID_CH= ?");
            $req->execute(array($idch));
            $aff= $req->fetch();
        }
    ?>
    <div class="content">
        <a href="charge.php" class="ajouter">Annuler</a> 
        <div class="modif-form">
            <h2>Modifier la charge</h2>
            <div class="erreur"></div>
            <form action="" method="">
                <input type="hidden" value="<?= $aff["ID_CH"]; ?>" name="idch">
                <input type="text" name="charge" id="charge" placeholder="charge" value="<?= $aff["CHARGE"]; ?>" autocomplete="off">
                <input type="submit" name="charge_mod" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>