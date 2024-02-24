<?php
    session_start();
    $ristourne = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Ristourne</title>
</head>
<body>
    <?php
        include("menu.php");

        if (isset($_GET["idrist"])) {
            $idrist= $_GET["idrist"];
            $req= $connexion->prepare("SELECT ID_RIST, R.ID_FR AS ID_FR, MONTANT_RIST, FOURNISSEUR
                                            FROM ristournes R, fournisseurs F, journees J
                                            WHERE J.ID_JR=R.ID_JR
                                            AND F.ID_FR=R.ID_FR 
                                            AND ID_RIST= ?");
            $req->execute(array($idrist));
            $aff= $req->fetch();
        }
    ?>
    <div class="content">
        <a href="ristourne.php" class="ajouter">Annuler</a> 
        <div class="modif-form">
            <h2>Modifier la ristourne</h2>
            <div class="erreur"></div>
            <form action="" method="">
                <input type="hidden" name="idrist" value="<?= $aff["ID_RIST"]; ?>">
                <select name="four" id="four">
                    <option value="">Choisir le fournisseur</option>
                    <?php
                        $req_fr= $connexion->query("SELECT * FROM fournisseurs ORDER BY FOURNISSEUR");
                        while ($res_fr= $req_fr->fetch()) {
                    ?>
                    <option value="<?= $res_fr["ID_FR"]; ?>" <?=  $retVal = ($aff["ID_FR"]==$res_fr["ID_FR"]) ? "selected" : "" ;?>><?= $res_fr["FOURNISSEUR"]; ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="montant_rist" id="montant_rist" value="<?= $aff["MONTANT_RIST"]; ?>" placeholder="Montant ristourne" autocomplete="off">
                <input type="submit" name="ristourne_mod" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>