<?php
    session_start();
    $achat = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Achat</title>
</head>
<body>
    <?php
        include("menu.php");
        if (isset($_GET["idach"])) {
            $idach= $_GET["idach"];
            $req= $connexion->prepare("SELECT ID_ACH, A.ID_FR AS ID_FR, MONTANT_ACH, FOURNISSEUR
                                            FROM achats A, fournisseurs F, journees J
                                            WHERE J.ID_JR=A.ID_JR
                                            AND F.ID_FR=A.ID_FR 
                                            AND ID_ACH= ?");
            $req->execute(array($idach));
            $aff= $req->fetch();
        }
    ?>
    <div class="content">
        <a href="achat.php" class="ajouter">Annuler</a> 
        <div class="modif-form">
            <h2>Modifier l'achat</h2>
            <div class="erreur"></div>
            <form action="" method="">
                <input type="hidden" name="idach" value="<?= $aff["ID_ACH"]; ?>">
                <select name="four" id="four">
                    <option value="">Choisir le fournisseur</option>
                    <?php
                        $req_fr= $connexion->query("SELECT * FROM fournisseurs ORDER BY FOURNISSEUR");
                        while ($res_fr= $req_fr->fetch()) {
                    ?>
                    <option value="<?= $res_fr["ID_FR"]; ?>" <?= $retVal= ($aff["ID_FR"] == $res_fr["ID_FR"]) ? "selected" : "" ;?>><?= $res_fr["FOURNISSEUR"]; ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="montant_ach" id="montant_ach" value="<?= $aff["MONTANT_ACH"]; ?>" placeholder="Montant achat" autocomplete="off">
                <input type="submit" name="achat_mod" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>