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
    <title>PROFIL</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="content_profil">
        <div class="form_content_profil">
            <h2>Modifier mes informations</h2>
            <?php
                if (isset($_GET['result'])) {
                    $result= $_GET['result'];
                    if ($result == "cmdp") {
                        echo "<div class='erreur'><p>Les deux mots de passe ne correspondent pas !!!</p></div>";
                    }
                    if ($result == "amdp") {
                        echo "<div class='erreur'><p>Ancien mot de passe incorrecte !!!</p></div>";
                    }
                    if ($result == "img") {
                        echo "<div class='erreur'><p>Seul les fichiers de type image sont autorisés !!!</p></div>";
                    }
                    if ($result == "succes") {
                        echo "<div class='succes'><p>Informations modifées avec succes !!!</p><p>Ils prendront effet à la prochaine connexion !!!</p></div>";
                    }
                }
            ?>
            <form action="update.php" method="post" enctype="multipart/form-data" >
                <div class="parties">
                    <div class="ecris">
                        <input type="text" name="nom" id="nom" disabled placeholder="Noms" value="<?= $_SESSION['user']; ?>" autocomplete="off">
                        <input type="password" name="ancien_mdp" id="ancien_mdp" placeholder="Ancien mot de passe" autocomplete="off">
                        <input type="password" name="nouveau_mdp" id="nouveau_mdp" placeholder="Nouveau mot de passe" autocomplete="off">
                        <input type="password" name="confirm_mdp" id="confirm_mdp" placeholder="Confirmer le mot de passe" autocomplete="off">
                    </div>
                    <div class="photo">
                        <img alt="User" src="../IMG/<?= $_SESSION['pp']; ?>" class="pp_modif">
                        <div class="file">
                            <input type="file" name="image">
                        </div>
                    </div>
                </div>
                <input type="submit" name="infos" id="infos" Onclick="return confirm('Enregistrer les modifications ? Vous allez être déconnecté !!!')" value="Modifier">
            </form>
        </div>
    </div>
</body>
</html>