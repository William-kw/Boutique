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
    <title>Récapitulatif</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="content">
        <div class="tab">
            <h2>Le récapitulatif</h2>
            <?php
                $count= $connexion->query("SELECT COUNT(ID_MOIS) AS NB FROM mois");
                $tcount= $count->fetch();
                @$page= $_GET["page"];
                if (empty($page)) $page= 1;
                $nb_element= 10;
                $nb_page= ceil($tcount["NB"] / $nb_element);
                $debut= ($page - 1) * $nb_element;
            ?>
            <table class="content_table">
                <thead>
                    <th>Années</th>
                    <th>Mois</th>
                    <th>Recettes</th>
                    <th>Achats</th>
                    <th>Dépenses</th>
                    <th>Bénéfices Bruts</th>
                    <th>Bénéfices Réels</th>
                    <th>Détails</th>
                </thead>
                <tbody>
                    <?php
                        $req_recap= $connexion->query("SELECT ID_MOIS, YEAR(DATE_JR) as ANNEE, MONTH(DATE_JR) as MOIS, ACHAT, RECETTE, DEPENSE
                                                        FROM (SELECT SUM(montant_ach) AS ACHAT, journees.id_mois as numa FROM journees LEFT JOIN achats ON journees.id_jr=achats.id_jr GROUP BY id_mois) as mach INNER JOIN 
                                                            (SELECT SUM(montant_rec) AS RECETTE, journees.id_mois as numr FROM journees LEFT JOIN recettes ON journees.id_rec=recettes.id_rec GROUP BY id_mois) as mrec ON mach.numa=mrec.numr INNER JOIN
                                                            (SELECT SUM(montant_dep) AS DEPENSE, journees.id_mois as numd FROM journees LEFT JOIN depenses ON journees.id_jr=depenses.id_jr GROUP BY id_mois) as mdep On mrec.numr=mdep.numd INNER JOIN journees ON mdep.numd=journees.ID_MOIS
                                                        GROUP BY id_mois 
                                                        ORDER BY id_mois
                                                        LIMIT $debut, $nb_element");
                        if($req_recap -> rowCount() == 0) header("location: recapitulatif.php");
                        while ($aff= $req_recap->fetch()) {
                            $annee= $aff["ANNEE"];
                            $mois= $aff["MOIS"];
                            $recette= $aff["RECETTE"];
                            $achat = (empty($aff["ACHAT"])) ? 0 : $aff["ACHAT"];
                            $depense = (empty($aff["DEPENSE"])) ? 0 : $aff["DEPENSE"];    
                            $benefice_B= $recette * 0.08;
                            $benefice_R= $benefice_B - $depense;
                            $_SESSION["benefice"]= $benefice_R;
                    ?>
                    <tr>
                        <td><?= $annee; ?></td>
                        <td><?= mois($mois); ?></td>
                        <td><?= $recette; ?></td>
                        <td title="<?= $achat + $depense; ?>"><?= $achat; ?></td>
                        <td><?= $depense; ?></td>
                        <td><?= $benefice_B; ?></td>
                        <td><?= $benefice_R; ?></td>  
                        <td><a href="detail.php?idmois=<?= $aff["ID_MOIS"]; ?>-mois=<?= $aff["MOIS"]; ?>" title="Plus de détail"><i class="fa-solid fa-list"></i></a></td>                      
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                    $p= $page - 1;
                    $s= $page + 1;
                    echo "<a href='?page=$p' class='lien-fleche'><i class='fa-solid fa-arrow-left'></i></a>";
                    $point_point = true;
                    for ($i=1; $i <= $nb_page; $i++) {                        
                        if ($page != $i) {
                            if (($i < 3) || (($i > $page - 3) && ($i < $page)) || (($i < $page + 3) && ($i > $page)) || ($i > $nb_page - 2)) {
                                echo "<a href='?page=$i' class='lien'>$i</a>";
                                $point_point = true;
                            }
                            else {
                                if ($point_point) {
                                    echo "<a href='?page=$i' class='lien'>...</a>";
                                    $point_point = false;
                                }
                            }
                        }
                        else {
                            echo "<a href='?page=$i' class='lien-courant'>$i</a>";
                        }
                    }
                    echo "<a href='?page=$s' class='lien-fleche'><i class='fa-solid fa-arrow-right'></i></a>";
                ?>
            </div>
        </div>
    </div>
</body>
</html>