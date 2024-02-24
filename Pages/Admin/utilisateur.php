<?php
    session_start();
    $utilisateur = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <script src="../JS/script.js" defer></script>
    <title>Utilisateur</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <div class="success"></div>
    <div class="content">
        <button class="ajouter" id="ajouter" title="Ajouter une recette"><h3>+</h3> Ajouter</button>
        <div class="form" id="form">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Ajouter un utilisateur</h2>
                <div class="erreur"></div>
                <form action="" enctype="multipart/form-data" autocomplete="off" class="formUtilisateur">
                    <input type="text" name="nom" placeholder="Noms">
                    <select name="role" id="role" class="role">
                        <option value="">Définir le rôle</option>
                        <option value="Utilisateur">Utilisateur</option>
                        <option value="Administrateur">Administrateur</option>
                    </select>
                    <input type="password" name="mdp" placeholder="Entrer le mot de passe">
                    <input type="password" name="cmdp" placeholder="Conformir le mot de passe">
                    <input type="submit" name="utilisateur" class="sub_formulaire" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="form" id="pass">
            <div class="form_content">
                <i class="fa-solid fa-xmark" class="fermer" id="fermer"></i>
                <h2>Confirmer votre identité</h2>
                <form action="" autocomplete="off">
                    <input type="password" name="mdp" placeholder="Entrer le mot de passe">
                    <input type="submit" name="confirmer" value="Confirmer">
                </form>
            </div>
        </div>
        <div class="tab">
            <h2>Les utilisateurs</h2>
            <table class="content_table">
                <thead>
                    <tr>
                        <th>Noms</th>
                        <th>Rôles</th>
                        <th>Réinitialiser</th>
                        <th>Statut</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $nom= $_SESSION['user'];
                        $req= $connexion->prepare("SELECT * 
                                                    FROM utilisateurs
                                                    WHERE PRIVILEGE < 3
                                                    AND NOM NOT IN (SELECT NOM FROM utilisateurs WHERE NOM= ?)
                                                    ORDER BY ID_UTIL");
                        $req->execute(array($nom));
                        while ($aff= $req->fetch()) {
                            $statut = ($aff['STATUT'] == "En ligne") ? "<p class='en-ligne' title='En ligne'></p>" : "<p class='hors-ligne' title='Hors ligne'></p>";
                    ?>
                    <tr>
                        <td><?= $aff['NOM']; ?></td>
                        <td><?= $aff['ROLES']; ?></td>
                        <td><a href="supprimer.php?idutil_reset=<?= $aff['ID_UTIL']; ?>" Onclick="return confirm('Réinitialiser le mot de passe ?')" class="modifier" title="Réinitialiser le mot de passe"><i class="fa-solid fa-arrows-spin"></i></a></td>
                        <td><?= $statut; ?></td>
                        <td><a href="supprimer.php?idutil=<?= $aff['ID_UTIL']; ?>" class="supprimer" Onclick="return confirm('Voulez vous vraiment supprimer ?')" title="Supprimer"><i class="fa-solid fa-trash"></i></a></td>                        
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>