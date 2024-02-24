<?php
    session_start();
    $fournisseur = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../IMG/Boutique.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des achats</title>
</head>
<body>
    <?php
        include("menu.php");
        $idfr= $_GET["idfr"];
        $req= $connexion->prepare("SELECT FOURNISSEUR FROM fournisseurs WHERE ID_FR= ?");
        $req->execute(array($idfr));
        $four= $req->fetch();
    ?>
    <div class="content">
        <a href="fournisseur.php" class="ajouter">Retour</a> 
        <div class="tab">
            <h2>Les achats chez <b><i><?= $four["FOURNISSEUR"]; ?></i></b></h2>
            <table class="content_table">
                <thead>
                    <th>Dates</th>
                    <th>Montants</th>
                </thead>
                <tbody>
                    <?php
                        $req= $connexion->prepare("SELECT DATE_JR, MONTANT_ACH
                                                    FROM achats A, fournisseurs F, journees J
                                                    WHERE J.ID_JR=A.ID_JR
                                                    AND F.ID_FR=A.ID_FR
                                                    AND F.ID_FR= ?
                                                    ORDER BY DATE_JR DESC");
                        $req->execute(array($idfr));
                        while ($aff= $req->fetch()) {
                    ?>
                    <tr>
                        <td><?= $aff['DATE_JR']; ?></td>
                        <td><?= $aff['MONTANT_ACH']; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>