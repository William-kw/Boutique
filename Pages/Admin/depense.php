<?php
    session_start();
    $depense = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <title>Depense</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une depense"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter une dépense</h2>
                <div class="erreur"></div>
                <form action="" class="formDepense">
                    <select name="charge_dep" id="charge">
                        <option value="">Choisir la charge</option>
                        <?php
                            $req_fr= $connexion->query("SELECT * FROM charges ORDER BY charge");
                            while ($res_fr= $req_fr->fetch()) {
                        ?>
                            <option value="<?= $res_fr["ID_CH"]; ?>"><?= $res_fr["CHARGE"]; ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="montant_dep" id="montant_dep" placeholder="Montant depense" autocomplete="off">
                    <input type="submit" name="depense" class="sub_formulaire" value="Ajouter">
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
                    <th>Actions</th>             
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
                        <td><?= ladate($aff['DATE_JR']); ?></td>
                        <td><?= $aff['CHARGE']; ?></td>
                        <td><?= $aff['MONTANT_DEP']; ?></td>
                        <td>
                            <a href="modifier_dep.php?iddep=<?= $aff['ID_DEP']; ?>" class="modifier" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="supprimer.php?iddep=<?= $aff['ID_DEP']; ?>" class="supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                    $p= $page - 1;
                    $s= $page + 1;
                    echo "<a href='?page=$p' class='lien-fleche'><i class='fa-solid fa-arrow-left'></i></a>";
                    $point_point = true;
                    for ($i=1; $i <= $nb_pa; $i++) {                        
                        if ($page != $i) {
                            if (($i < 3) || (($i > $page - 3) && ($i < $page)) || (($i < $page + 3) && ($i > $page)) || ($i > $nb_pa - 2)) {
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