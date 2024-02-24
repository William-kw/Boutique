<?php
    session_start();
    require_once("../connexion.php");

    if (isset($_SESSION['loged'])) {
        if ($_SESSION['priv'] != 1) {
            session_destroy();
            header("location:../../index.php?result=priv");
        }
    } else header("location:../../index.php?result=connect");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <title>RECAPITULATIF</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="content">
        <div class="tab">
            <h2>Le récapitulatif</h2>
            <table class="content_table">
                <thead>
                    <th>Années</th>
                    <th>Mois</th>
                    <th>Recettes</th>
                    <th>Achats</th>
                    <th>Dépenses</th>
                    <th>Bénéfices Brutes</th>
                    <th>Bénéfices Réels</th>
                </thead>
                <tbody>
                    <?php
                        $req_recap= $connexion->query("SELECT j.ID_MOIS, YEAR(DATE_JR) AS ANNEES, MONTH(DATE_JR) AS MOIS, SUM(MONTANT_REC) AS RECETTE, SUM(MONTANT_DEP) AS DEPENSE, SUM(MONTANT_ACH) AS ACHAT
                        FROM recettes r, journees j, depenses d, achats a 
                        WHERE j.ID_REC=r.ID_REC 
                        AND j.ID_JR=d.ID_JR 
                        AND j.ID_JR=a.ID_JR 
                        GROUP BY j.ID_MOIS ");
                        while ($aff= $req_recap->fetch()) {
                            $annee= $aff["ANNEES"];
                            $mois= $aff["MOIS"];
                            $recette= $aff["RECETTE"];
                            $achat= $aff["ACHAT"];
                            $depense= $aff["DEPENSE"];
                            $benefice_B= $recette * 0.8;
                            $benefice_R= $recette - $depense;
                    ?>
                    <tr>
                        <td><?= $annee; ?></td>
                        <td><?= mois($mois); ?></td>
                        <td><?= $recette; ?></td>
                        <td><?= $achat; ?></td>
                        <td><?= $depense; ?></td>
                        <td><?= $benefice_B; ?></td>
                        <td><?= $benefice_R; ?></td>                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<style>    
    .barre-verticale .menu ul li .recap{
        background-color: #112B4D;
        opacity: 1;
        transition: 0.8s;
        color: #FEEA06;
        border-left: 2px solid #FEEA06;
    }
</style>
</html>
<script type="text/javascript">
	function masquer() {
		var form = document.getElementById("form");
		if (form.style.display === "none") {
			form.style.display = "block";
		} else {
			form.style.display = "none";
		}
	}
</script>