<?php
    session_start();
    $ristourne = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <title>Ristourne</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une ristourne"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter une ristourne</h2>
                <div class="erreur"></div>
                <?php
                    $count= $connexion->query("SELECT COUNT(ID_RIST) AS NB FROM ristournes");
                    $tcount= $count->fetch();
                    @$page= $_GET["page"];
                    if (empty($page)) $page= 1;
                    $nb_el= 10;
                    $nb_pa= ceil($tcount["NB"] / $nb_el);
                    $debut= ($page - 1) * $nb_el;
                ?>
                <form action="" class="formRistourne">
                    <select name="four" id="four">
                        <option value="">Choisir le fournisseur</option>
                        <?php
                            $req_fr= $connexion->query("SELECT * FROM fournisseurs");
                            while ($res_fr= $req_fr->fetch()) {
                        ?>
                        <option value="<?= $res_fr["ID_FR"]; ?>"><?= $res_fr["FOURNISSEUR"]; ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="montant_rist" id="montant_rist" placeholder="Montant ristourne" autocomplete="off">
                    <input type="submit" name="ristourne" class="sub_formulaire" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les ristournes</h2>
            <table class="content_table">
                <thead>
                    <th>Dates</th>
                    <th>Fournisseurs</th>
                    <th>Ritournes</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php
                        $req= $connexion->query("SELECT ID_RIST, DATE_JR, MONTANT_RIST, FOURNISSEUR
                                                    FROM ristournes R, fournisseurs F, journees J
                                                    WHERE J.ID_JR=R.ID_JR
                                                    AND F.ID_FR=R.ID_FR
                                                    ORDER BY DATE_JR DESC LIMIT $debut, $nb_el");
                        if($req -> rowCount() == 0) header("location:ristourne.php");
                        while ($aff= $req->fetch()) {
                    ?>
                    <tr>
                        <td><?= $aff['DATE_JR']; ?></td>
                        <td><?= $aff['FOURNISSEUR']; ?></td>
                        <td><?= $aff['MONTANT_RIST']; ?></td>
                        <td>
                            <a href="modifier_rist.php?idrist=<?= $aff['ID_RIST']; ?>" class="modifier" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="supprimer.php?idrist=<?= $aff['ID_RIST']; ?>" class="supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')" title="Supprimer"><i class="fa-solid fa-trash"></i></a>
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