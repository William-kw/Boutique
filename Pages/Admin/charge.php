<?php
    session_start();
    $charge = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <title>Charge</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une charge"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter une charge</h2>
                <div class="erreur"></div>
                <form action="" class="formCharge">
                    <input type="text" name="charge" id="charge" placeholder="Charge" autocomplete="off">
                    <input type="submit" name="charge_sub" class="sub_formulaire" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les charges</h2>
                <?php
                    $count= $connexion->query("SELECT COUNT(ID_CH) AS NB FROM charges");
                    $tcount= $count->fetch();
                    @$page= $_GET["page"];
                    if (empty($page)) $page= 1;
                    $nb_el= 10;
                    $nb_pa= ceil($tcount["NB"] / $nb_el);
                    $debut= ($page - 1) * $nb_el;
                ?>
            <table class="content_table">
                <thead>
                    <th>charges</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php
                        $req_ch= $connexion->query("SELECT * FROM charges ORDER BY CHARGE ASC LIMIT $debut, $nb_el");
                        if($req_ch -> rowCount() == 0) header("location:charge.php");
                        while ($res_ch= $req_ch->fetch()) {
                    ?>
                    <tr>                    
                        <td><?= $res_ch["CHARGE"]; ?></td>
                        <td>
                            <a href="modifier_cha.php?idch=<?= $res_ch["ID_CH"]; ?>" class="modifier" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="supprimer.php?idch=<?= $res_ch['ID_CH']; ?>" class="supprimer" title="Supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                    $p= $page - 1;
                    $s= $page + 1;
                    echo "<a href='?page=$p' class='lien-fleche'><i class='fa-solid fa-arrow-left'></i></a>";
                    for ($i=1; $i <= $nb_pa; $i++) {
                        if ($page != $i) {
                            echo "<a href='?page=$i' class='lien'>$i</a>";
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