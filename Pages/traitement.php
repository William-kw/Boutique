<?php
    session_start();
    require_once("connexion.php");
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];
    if (!empty($nom) && !empty($mdp)) {
        $req = $connexion->query("SELECT * FROM utilisateurs WHERE NOM='$nom'");
        if ($req->rowCount() > 0) {
            $aff = $req->fetch();
            if (password_verify($mdp, $aff['MDP'])) {
                $_SESSION['user'] = $aff['NOM'];
                $_SESSION['roles'] = $aff['ROLES'];
                $_SESSION['pp'] = $aff['IMG'];
                $_SESSION['priv'] = $aff['PRIVILEGE'];
                $req = $connexion->prepare("UPDATE utilisateurs SET STATUT= 'En ligne' WHERE NOM= ?");
                $update = $req->execute([$_SESSION['user']]);
                if ($update) {
                    $_SESSION['loged'] = "loged";
                    $role = ($_SESSION["priv"] > "1") ? "Admin":"User";
                    echo $role;
                }
            } else echo "Erreur : mot de passe incorrecte !";
        } else echo "Erreur : ce compte n'existe pas !";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
?>