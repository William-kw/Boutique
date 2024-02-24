<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/update.js" defer></script>
    <title>Profil</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content_profil">
        <div class="modif-form">
            <h2>Modifier mes informations</h2>
            <div class="erreur"></div>
            <form action="" method="" enctype="multipart/form-data" autocomplete="off">
                <div class="parties">
                    <div class="ecris">
                        <input type="text" name="nom" disabled="" id="nom" placeholder="Noms" value="<?= $_SESSION['user']; ?>">
                        <input type="password" name="ancien_mdp" id="ancien_mdp" placeholder="Ancien mot de passe">
                        <input type="password" name="nouveau_mdp" id="nouveau_mdp" placeholder="Nouveau mot de passe">
                        <input type="password" name="confirm_mdp" id="confirm_mdp" placeholder="Confirmer le mot de passe">
                    </div>
                    <div class="photo">
                        <img alt="User" src="../IMG/<?= $_SESSION['pp']; ?>" id="pp" class="pp_modif">
                        <div class="file">
                            <input type="file" id="input_pp" name="image" title="" onchange="previewFile()">
                        </div>
                    </div>
                </div>
                <input type="submit" name="infos" class="sub_modif" value="Modifier">
            </form>
        </div>
    </div>
</body>
</html>