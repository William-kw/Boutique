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
    <title>DEPENSE</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une depense" onclick="masquer()"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" onclick="masquer()" id="fermer"></i>
                <h2>Ajouter une dépense</h2>
                <form action="insertion.php" method="POST">
                    <select name="charge" id="charge" required="">
                        <option value="">Choisir la charge</option>
                        <?php
                            $req_fr= $connexion->query("SELECT * FROM charges");
                            while ($res_fr= $req_fr->fetch()) {
                        ?>
                            <option value="<?= $res_fr["ID_CH"]; ?>"><?= $res_fr["CHARGE"]; ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="montant_dep" id="montant_dep" placeholder="Montant depense" autocomplete="off" required="">
                    <input type="submit" name="depense" id="sub_montant" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les Dépenses</h2>
                <?php
                    $count= $connexion->query("SELECT COUNT(ID_DEP) AS NB FROM depenses");
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
                    <th>Charges</th>
                    <th>Dépenses</th>         
                </thead>
                <tbody>
                    <?php
                        $req= $connexion->query("SELECT ID_DEP, DATE_JR, MONTANT_DEP, CHARGE
                                                    FROM depenses D, charges C, journees J
                                                    WHERE J.ID_JR=D.ID_JR
                                                    AND C.ID_CH=D.ID_CH
                                                    ORDER BY DATE_JR DESC LIMIT $debut, $nb_el");
                        if($req -> rowCount() == 0) header("location:depense.php");
                        while ($aff= $req->fetch()) {
                    ?>
                    <tr>
                        <td><?= $aff['DATE_JR']; ?></td>
                        <td><?= $aff['CHARGE']; ?></td>
                        <td><?= $aff['MONTANT_DEP']; ?></td>
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
    .barre-verticale .menu ul li .depense{
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