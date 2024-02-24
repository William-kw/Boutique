<?php
    session_start();
    $fournisseur = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <title>Fournisseur</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter un fournisseur"><h3>+</h3> Ajouter</button>        
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter un fournisseur</h2>
                <div class="erreur"></div>
                <form action="" class="formFournisseur">
                    <input type="text" name="fournisseur" id="fournisseur" placeholder="Fournisseur" autocomplete="off">
                    <input type="submit" name="fournisseur_sub" class="sub_formulaire" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="tab">
            <div class="titres">
                <h2>Les fournisseurs</h2>               
                <div class="titre">
                    <label for="">Mois</label>
                    <select name="mois" id="mois">
                        <option value="tout">Global</option>
                        <?php
                            $reqMois = $connexion->query("SELECT MONTH(DATE_JR) AS MOIS FROM journees GROUP BY MONTH(DATE_JR)");
                            while($resMois = $reqMois->fetch()){
                                ?>
                        <option value="<?= $resMois["MOIS"]; ?>"><?= mois($resMois["MOIS"]); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="titre">
                    <label for="">Années</label>
                    <select name="annee" id="annee">
                        <option value="tout">Global</option>
                        <?php
                            $reqAn = $connexion->query("SELECT YEAR(DATE_JR) AS ANNEE FROM journees GROUP BY YEAR(DATE_JR)");
                            while($resAn = $reqAn->fetch()){
                        ?>
                        <option value="<?= $resAn["ANNEE"]; ?>"><?= $resAn["ANNEE"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="fournisseurs">   
                <?php
                // SELECT F.ID_FR AS ID_FR, SUM(MONTANT_ACH) AS SOMME, FOURNISSEUR, MONTH(DATE_JR) AS MOIS
                // FROM fournisseurs F, journees J, achats A
                // WHERE F.ID_FR=A.ID_FR AND J.ID_JR=A.ID_JR
                // AND MONTH(DATE_JR) = 12
                // GROUP BY ID_FR, MOIS ORDER BY SOMME DESC;
                    $req_fr= $connexion->query("SELECT F.ID_FR AS ID_FR, SUM(MONTANT_ACH) AS SOMME, FOURNISSEUR 
                                                    FROM fournisseurs F LEFT JOIN achats ON F.ID_FR=achats.ID_FR 
                                                    GROUP BY ID_FR ORDER BY SOMME DESC");
                    while ($res_fr= $req_fr->fetch()) {
                ?> 
                <div class="fournisseur">
                    <h5><?= $res_fr["FOURNISSEUR"]; ?></h5>
                    <h3><?= (empty($res_fr["SOMME"]) ? "0" : $res_fr["SOMME"]) ;?><sup>FCFA</sup></h3>
                    <div class="liens">
                        <a href="modifier_four.php?idfr=<?= $res_fr["ID_FR"]; ?>" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="lister_four.php?idfr=<?= $res_fr["ID_FR"]; ?>" title="Lister"><i class="fa-solid fa-list"></i></a>
                        <a href="supprimer.php?idfr=<?= $res_fr['ID_FR']; ?>" class="supprimer" title="Supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>