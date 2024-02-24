<?php
    session_start();
    $depense = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Dépense</title>
</head>
<body>
    <?php
        include("menu.php");
        if (isset($_GET["iddep"])) {
            $iddep= $_GET["iddep"];
            $req= $connexion->prepare("SELECT ID_DEP, C.ID_CH AS ID_CH, MONTANT_DEP, CHARGE
                                            FROM depenses D, charges C, journees J
                                            WHERE J.ID_JR=D.ID_JR
                                            AND C.ID_CH=D.ID_CH 
                                            AND ID_DEP= ?");
            $req->execute(array($iddep));
            $aff= $req->fetch();
        }
    ?>
    <div class="content">
        <a href="depense.php" class="ajouter">Annuler</a> 
        <div class="modif-form">
            <h2>Modifier la dépense</h2>
            <div class="erreur"></div>
            <form action="" method="">
                <input type="hidden" name="iddep" value="<?= $aff["ID_DEP"]; ?>">
                <select name="char" id="char">
                    <option value="">Choisir le fournisseur</option>
                    <?php
                        $req_fr= $connexion->query("SELECT * FROM charges ORDER BY CHARGE");
                        while ($res_fr= $req_fr->fetch()) {
                    ?>
                    <option value="<?= $res_fr["ID_CH"]; ?>" <?=  $retVal = ($aff["ID_CH"]==$res_fr["ID_CH"]) ? "selected" : "" ;?>><?= $res_fr["CHARGE"]; ?></option>
                    <?php } ?>
                </select>
                <input type="text" name="montant_dep" id="montant_dep" value="<?= $aff["MONTANT_DEP"]; ?>" placeholder="Montant dépense" autocomplete="off">
                <input type="submit" name="depense_mod" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>