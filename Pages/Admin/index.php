<?php
    session_start();
    $index = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <title>Accueil</title>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="content">
        <div class="dashboard">
            <div class="section1">
                <div class="users" title="Nombre d'utilisateurs du système">
                    <a href="utilisateur.php">
                    <?php
                        $reqnbuser= $connexion->query("SELECT COUNT(ID_UTIL) AS USER FROM utilisateurs");
                        $resnbuser= $reqnbuser->fetch();
                    ?>
                    <i class="fa-solid fa-users"></i>
                    <h3><?= $resnbuser["USER"] ?></h3></a>
                </div>
                <div class="fournisseurs" title="Nombre de fournisseurs">
                    <a href="fournisseur.php">
                    <?php
                        $reqnbfour= $connexion->query("SELECT COUNT(ID_FR) AS FOURNISSEUR FROM fournisseurs");
                        $resnbfour= $reqnbfour->fetch();
                    ?>
                    <i class="fa-solid fa-truck"></i>
                    <h3><?= $resnbfour["FOURNISSEUR"] ?></h3></a>
                </div>
                <div class="charges" title="Nombre de charges">
                    <a href="charge.php">
                    <?php
                        $reqnbchar= $connexion->query("SELECT COUNT(ID_CH) AS CHARGE FROM charges");
                        $resnbchar= $reqnbchar->fetch();
                    ?>
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <h3><?= $resnbchar["CHARGE"] ?></h3></a>
                </div>
                <div class="ristournes" title="Montant des ristournes">
                    <a href="ristourne.php">
                        <?php
                            $reqrist= $connexion->query("SELECT MONTANT_RIST, FOURNISSEUR 
                                                            FROM ristournes R, fournisseurs F
                                                            WHERE R.ID_FR=F.ID_FR");
                            $resrist= $reqrist->fetch();
                        ?>
                    <i class="fa-solid fa-code-branch"></i>
                    <span class="rist">
                        <h5><?= $resrist["FOURNISSEUR"] ?></h5>
                        <h3><?= $resrist["MONTANT_RIST"] ?></h3>
                    </span></a>
                </div>
                <div class="recettes-moy" title="Moyenne des ventes">
                    <a href="#">
                    <?php
                        $reqrecmoy= $connexion->query("SELECT AVG(MONTANT_REC) AS MOY FROM recettes");
                        $resrecmoy= $reqrecmoy->fetch();
                    ?>
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                    <h3><?= ceil($resrecmoy["MOY"]) ?><sup>FCFA</sup></h3></a>
                </div>
                <div class="reccettes-max" title="Record de vente">
                    <a href="#">
                    <?php
                        $reqrecmax= $connexion->query("SELECT MAX(MONTANT_REC) AS MAX, DATE_JR FROM recettes r, journees j WHERE j.id_rec=r.id_rec");
                        $resrecmax= $reqrecmax->fetch();
                    ?>
                    <i class="fa-solid fa-award"></i>
                    <span class="rist">
                        <h5><?= $resrecmax["DATE_JR"] ?></h5>
                        <h3><?= $resrecmax["MAX"] ?><sup>FCFA</sup></h3>
                    </span></a>
                </div>
                <div class="detail" title="Détails de la journée d'hier">
                    <?php 
                        $reqidmois= $connexion->query("SELECT MAX(ID_MOIS) AS ID_MOIS FROM journees");
                        $idmois= $reqidmois->fetch();
                    ?>
                    <a href="detail.php?idmois=<?= $idmois["ID_MOIS"] ?>">
                        <h5>La dernière journée</h5>
                        <table class="content_table_hier">
                            <thead>
                                <tr>
                                    <th>Recette</th>
                                    <th>Achat</th>
                                    <th>Dépense</th>
                                    <th>Solde</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $req_recap= $connexion->query("SELECT journees.date_jr as JOURNEE, mrec.R as RECETTE, mach.A as ACHAT, mdep.D AS DEPENSE, msld.S AS SOLDE 
                                                                        FROM (SELECT SUM(montant_ach) AS A, journees.date_jr as jr FROM journees LEFT JOIN achats ON journees.id_jr=achats.id_jr WHERE DATE_JR= (SELECT MAX(DATE_jr) FROM journees) GROUP BY jr) AS mach INNER JOIN 
                                                                        (SELECT montant_rec AS R, journees.date_jr as jr FROM journees LEFT JOIN recettes ON journees.id_rec=recettes.id_rec WHERE DATE_JR= (SELECT MAX(DATE_jr) FROM journees)) AS mrec ON mach.jr=mrec.jr INNER JOIN 
                                                                        (SELECT SUM(montant_dep) AS D, journees.date_jr as jr FROM journees LEFT JOIN depenses ON journees.id_jr=depenses.id_jr WHERE DATE_JR= (SELECT MAX(DATE_jr) FROM journees) GROUP BY jr) AS mdep ON mrec.jr=mdep.jr INNER JOIN journees ON mdep.jr=journees.date_jr INNER JOIN 
                                                                        (SELECT solde AS S, journees.date_jr as jr FROM journees LEFT JOIN soldes ON journees.id_sld=soldes.id_sld WHERE DATE_JR= (SELECT MAX(DATE_jr) FROM journees)) AS msld ON mdep.jr=msld.jr
                                                                        ORDER BY JOURNEE DESC");
                                    while ($aff= $req_recap->fetch()) {
                                        $recette= $aff["RECETTE"];
                                        $solde= $aff["SOLDE"];
                                        $achat = (empty($aff["ACHAT"])) ? 0 : $aff["ACHAT"];
                                        $depense = (empty($aff["DEPENSE"])) ? 0 : $aff["DEPENSE"];                            
                                ?>
                                <tr>
                                    <td><?= $recette; ?></td>
                                    <td><?= $achat; ?></td>
                                    <td><?= $depense; ?></td> 
                                    <td><?= $solde; ?></td>    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </a>
                </div>
            </div>
            <div class="section2">
                <div class="courbe-recette">
                    <h4>Evalution des ventes</h4>
                    <span class="graph"></span>
                </div>
                <div class="repartition-achat">
                    <h4>Répartition des achats</h4>
                    <span class="graph">
                        <?php echo "<img src='../Graph/repartition_achat.php'/>"; ?>                    
                    </span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>