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
    <link rel="icon" href="../IMG/Boutique.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACHAT</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter un achat" onclick="masquer()"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" onclick="masquer()" id="fermer"></i>
                <h2>Ajouter un achat</h2>
                <form action="insertion.php" method="POST">
                    <select name="four" id="four" required="">
                        <option value="">Choisir le fournisseur</option>
                        <?php
                            $req_fr= $connexion->query("SELECT * FROM fournisseurs ORDER BY FOURNISSEUR");
                            while ($res_fr= $req_fr->fetch()) {
                        ?>
                        <option value="<?= $res_fr["ID_FR"]; ?>"><?= $res_fr["FOURNISSEUR"]; ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="montant_ach" id="montant_ach" placeholder="Montant achat" autocomplete="off" required="">
                    <input type="submit" name="achat" id="sub_montant" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les achats</h2>
                <?php
                    $count= $connexion->query("SELECT COUNT(ID_ACH) AS NB FROM achats");
                    $tcount= $count->fetch();
                    @$page= $_GET["page"];
                    if (empty($page)) $page= 1;
                    $nb_el= 10;
                    $nb_pa= ceil($tcount["NB"] / $nb_el);
                    $debut= ($page - 1) * $nb_el;
                ?>
            <table class="content_table">
                <thead>
                    <th>Dates</th>
                    <th>Fournisseurs</th>
                    <th>Dépenses</th>
                </thead>
                <tbody>
                    <?php
                        $req= $connexion->query("SELECT ID_ACH, DATE_JR, MONTANT_ACH, FOURNISSEUR
                                                    FROM achats A, fournisseurs F, journees J
                                                    WHERE J.ID_JR=A.ID_JR
                                                    AND F.ID_FR=A.ID_FR
                                                    ORDER BY DATE_JR DESC LIMIT $debut, $nb_el");
                        if($req_fr -> rowCount() == 0) header("location: achat.php");
                        while ($aff= $req->fetch()) {
                    ?>
                    <tr>
                        <td><?= $aff['DATE_JR']; ?></td>
                        <td><?= $aff['FOURNISSEUR']; ?></td>
                        <td><?= $aff['MONTANT_ACH']; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                    for ($i=1; $i <= $nb_pa; $i++) { 
                        if ($page != $i)
                            echo "<a href='?page=$i' class='lien'>$i</a>";
                        else
                            echo "<a href='?page=$i' class='lien-courant'>$i</a>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
<style>    
    .barre-verticale .menu ul li .achat{
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
		if (form.style.display === "block") {
			form.style.display = "none";
		} else {
			form.style.display = "block";
		}
	}
</script>