<?php
    session_start();
    $achat = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat</title>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter un achat"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter un achat</h2>
                <div class="erreur"></div>
                <form action="" autocomplete="off" class="formAchat">
                    <select name="four" id="four">
                        <option value="">Choisir le fournisseur</option>
                        <?php
                            $req_fr= $connexion->query("SELECT * FROM fournisseurs ORDER BY FOURNISSEUR");
                            while ($res_fr= $req_fr->fetch()) {
                        ?>
                        <option value="<?= $res_fr["ID_FR"]; ?>"><?= $res_fr["FOURNISSEUR"]; ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="montant_ach" id="montant_ach" placeholder="Montant achat">
                    <input type="submit" name="achat" class="sub_formulaire" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les achats</h2>
                <?php
                    $count= $connexion->query("SELECT COUNT(ID_ACH) AS NB FROM achats");
                    $tcount= $count->fetch();
                    @$page= $_GET["page"];
                    $nb_el= 10;
                    $nb_pa= ceil($tcount["NB"] / $nb_el);
                    if (empty($page) && $page < $nb_pa || $page > $nb_pa) $page= 1;
                    $debut= ($page - 1) * $nb_el;
                ?>
            <table class="content_table">
                <thead>
                    <th>Dates</th>
                    <th>Fournisseurs</th>
                    <th>Dépenses</th>
                    <th>Actions</th>
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
                        <td><?= ladate($aff['DATE_JR']); ?></td>
                        <td><?= $aff['FOURNISSEUR']; ?></td>
                        <td><?= $aff['MONTANT_ACH']; ?></td>
                        <td>
                            <a href="modifier_ach.php?idach=<?= $aff['ID_ACH']; ?>" class="modifier" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="supprimer.php?idach=<?= $aff['ID_ACH']; ?>"  class="supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
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
                            if (($i < 3)
                                || (($i > $page - 3) && ($i < $page))
                                || (($i < $page + 3) && ($i > $page))
                                || ($i > $nb_pa - 2)) {
                                echo "<a href='?page=$i' class='lien'>$i</a>";
                                $point_point = true;
                            }
                            else {
                                if ($point_point) {
                                    echo "<a href='#' class='lien'>...</a>";
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