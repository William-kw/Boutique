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
    <title>RECETTE</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une recette" onclick="masquer()"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" onclick="masquer()" id="fermer"></i>
                <h2>Ajouter une recette</h2>
                <form action="insertion.php" method="post">
                    <input type="date" name="date" id="date" placeholder="Dates">
                    <input type="text" name="montant_rec" id="montant_rec" placeholder="Montant recette" autocomplete="off" required="">
                    <input type="submit" name="recette" id="sub_montant" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les recettes</h2>
                <?php
                    $count= $connexion->query("SELECT COUNT(ID_REC) AS NB FROM recettes");
                    $tcount= $count->fetch();
                    @$page= $_GET["page"];
                    if (empty($page)) $page= 1;
                    $nb_el= 10;
                    $nb_pa= ceil($tcount["NB"] / $nb_el);
                    $debut= ($page - 1) * $nb_el;
                ?>
            <table class="content_table">
                <thead>
                    <tr>
                        <th>Dates</th>
                        <th>Recettes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $req= $connexion->query("SELECT R.ID_REC AS ID_REC, J.DATE_JR AS DATES, R.MONTANT_REC AS MONTANT 
                                                    FROM journees J, recettes R
                                                    WHERE J.ID_REC=R.ID_REC
                                                    ORDER BY J.DATE_JR DESC LIMIT $debut, $nb_el");
                        if($req -> rowCount() == 0) header("location:index.php");
                        while ($aff= $req->fetch()) {
                    ?>
                    <tr>
                        <td><?= $aff['DATES']; ?></td>
                        <td><?= $aff['MONTANT']; ?></td>
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
    .barre-verticale .menu ul li .recette{
        background-color: #112B4D;
        opacity: 1;
        color: #FEEA06;
        transition: 0.8s;
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