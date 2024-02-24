<?php
    session_start();
    $recette = true;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <title>Recette</title>
</head>

<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une recette">
            <h3>+</h3> Ajouter
        </button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter une recette</h2>
                <div class="erreur"></div>
                <form action="" class="formRecette">
                    <input type="date" name="date" id="date" placeholder="Dates">
                    <input type="text" name="montant_rec" id="montant_rec" placeholder="Montant recette" autocomplete="off">
                    <input type="submit" name="recette" class="sub_formulaire" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les recettes</h2>
            <?php
                $count = $connexion->query("SELECT COUNT(ID_REC) AS NB FROM recettes");
                $tcount = $count->fetch();
                @$page = $_GET["page"];
                if (empty($page)) $page = 1;
                $nb_element = 10;
                $nb_page = ceil($tcount["NB"] / $nb_element);
                $debut = ($page - 1) * $nb_element;
            ?>
            <table class="content_table">
                <thead>
                    <tr>
                        <th>Dates</th>
                        <th>Recettes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $req = $connexion->query("SELECT R.ID_REC AS ID_REC, J.DATE_JR AS DATES, R.MONTANT_REC AS MONTANT 
                                                        FROM journees J, recettes R
                                                        WHERE J.ID_REC=R.ID_REC
                                                        ORDER BY J.DATE_JR DESC LIMIT $debut, $nb_element");
                        if ($req->rowCount() == 0) header("location:recette.php");
                        while ($aff = $req->fetch()) {
                    ?>
                        <tr>
                            <td><?= ladate($aff['DATES']); ?></td>
                            <td><?= $aff['MONTANT']; ?></td>
                            <td>
                                <a href="modifier_rec.php?idrec=<?= $aff['ID_REC']; ?>" class="modifier" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="supprimer.php?idrec=<?= $aff['ID_REC']; ?>" class="supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                    $p = $page - 1;
                    $s = $page + 1;
                    echo "<a href='?page=$p' class='lien-fleche'><i class='fa-solid fa-arrow-left'></i></a>";
                    $point_point = true;
                    for ($i = 1; $i <= $nb_page; $i++) {
                        if ($page != $i) {
                            if (($i < 3) || (($i > $page - 3) && ($i < $page)) || (($i < $page + 3) && ($i > $page)) || ($i > $nb_page - 2)) {
                                echo "<a href='?page=$i' class='lien'>$i</a>";
                                $point_point = true;
                            } else {
                                if ($point_point) {
                                    echo "<a href='?page=$i' class='lien'>...</a>";
                                    $point_point = false;
                                }
                            }
                        } else {
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