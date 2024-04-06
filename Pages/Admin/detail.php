<?php
    session_start();
    $recapitulatif = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <title>Détail</title>
</head>
<body>
    <?php
        include("menu.php"); 
        $idmois= $_GET["idmois"];
		$req_m= $connexion->prepare('SELECT MONTH(DATE_JR) AS MOIS FROM journees WHERE ID_MOIS=?');
		$req_m->execute([$idmois]);
		$date=$req_m->fetch();
    ?>
    <div class="content">
        <a href="recapitulatif.php" class="ajouter">Retour</a> 
        <div class="tab">
            <h2>Détail de <b><?= mois($date["MOIS"]); ?></b></h2>
            <table class="content_table">
                <thead>
                    <th>Dates</th>
                    <th>Recettes</th>
                    <th>Achats</th>
                    <th>Dépenses</th>
                </thead>
                <tbody>
                    <?php
                        $req_recap= $connexion->query("SELECT journees.date_jr as JOURNEE, mrec.R as RECETTE, mach.A as ACHAT, mdep.D AS DEPENSE 
                                                            FROM (SELECT SUM(montant_ach) AS A, journees.date_jr as jr FROM journees LEFT JOIN achats ON journees.id_jr=achats.id_jr WHERE id_mois= '$idmois' GROUP BY jr) AS mach INNER JOIN 
                                                                (SELECT montant_rec AS R, journees.date_jr as jr FROM journees LEFT JOIN recettes ON journees.id_rec=recettes.id_rec WHERE id_mois= '$idmois') AS mrec ON mach.jr=mrec.jr INNER JOIN 
                                                                (SELECT SUM(montant_dep) AS D, journees.date_jr as jr FROM journees LEFT JOIN depenses ON journees.id_jr=depenses.id_jr WHERE id_mois= '$idmois' GROUP BY jr) AS mdep ON mrec.jr=mdep.jr INNER JOIN journees ON mdep.jr=journees.date_jr
                                                            ORDER BY JOURNEE DESC");
                        while ($aff= $req_recap->fetch()) {
                            $recette= $aff["RECETTE"];
                            $date_jr= $aff["JOURNEE"];
                            if(empty($aff["ACHAT"])){ $achat= "--"; } else { $achat= $aff["ACHAT"]; }
                            if(empty($aff["DEPENSE"])){ $depense= "--"; } else { $depense= $aff["DEPENSE"]; }                            
                    ?>
                    <tr>
                        <td><?= $date_jr; ?></td>
                        <td><?= $recette; ?></td>
                        <td><?= $achat; ?></td>
                        <td><?= $depense; ?></td> 
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>