<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Pages/IMG/Boutique.png">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">
    <link rel="stylesheet" href="style.css">
    <script src="Pages/JS/login.js" defer></script>
    <title>Boµtique</title>
</head>

<body>
    <div class="content">
        <table></table>
        <div class="logo">
            <img src="Pages/IMG/Boutique.png" alt="Boutique" class="boutique">
            <h3>Boµtique.com</h3>
        </div>
        <div class="erreur"></div>
        <?php
            require_once("Pages/connexion.php");

            if (isset($_GET["result"])) {
                $message = ($_GET["result"] == "privilege") ? "<div class='erreurC'><i class='fa-solid fa-xmark' onclick='masquer(erreurC)' id='fermer'></i><span><i class='fa-solid fa-triangle-exclamation'></i>Erreur : vous ne pouvez pas accéder à cette page</span></div>" : "<div class='erreurC'><i class='fa-solid fa-xmark' onclick='masquer(erreurC)' id='fermer'></i><span><i class='fa-solid fa-triangle-exclamation'></i>Erreur : vous devez vous connecter</span></div>";
                echo $message;
            }
            
            if (isset($_POST["inscription"])) {
                $nom = $_POST["nom"];
                $role = "Super-admin";
                $privilege = 2;
                $mdp = $_POST["mdp"];
                $cmdp = $_POST["cmdp"];
                var_dump($_POST["inscription"]);
                if (!empty($nom) && !empty($mdp) && !empty($cmdp)) {
                    if ($mdp == $cmdp) {
                        $cmdp = password_hash($cmdp, PASSWORD_DEFAULT);
                        $req = $connexion->prepare("INSERT INTO utilisateurs (ID_UTIL, NOM, MDP, ROLES, PRIVILEGE) VALUES (null, ?, ?, ?, ?)");
                        $res = $req->execute(array($nom, $cmdp, $role, $privilege));
                    } else header("location:index.php?result=cmdp");
                    if ($res) {
                        header("location: index.php?result=succes");
                    }
                } else header("location: index.php?result=vide");
            }
            $req = $connexion->query("SELECT COUNT(ID_UTIL) AS NB FROM utilisateurs");
            $res = $req->fetch();
            if ($res["NB"] >= 1) {
                echo '<form action="" >            
                        <div class="input">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" placeholder="Nom d\'utilisateur" name="nom" autocomplete="off">
                        </div>
                        <div class="input">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" placeholder="Mot de passe" name="mdp" id="mdp" autocomplete="off">
                            <i class="fa-solid fa-eye" id="showmdp"></i>
                            <i class="fa-solid fa-eye-slash" id="masqmdp" style="display:none;"></i>
                        </div>
                        <input type="submit" class="btn btn-primary" name="connexion" value="Se connecter">
                    </form>';
            } else {
                echo '<form action="#" >            
                            <div class="input">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" placeholder="Nom d\'utilisateur" name="nom" autocomplete="off">
                            </div>   
                            <div class="input">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" placeholder="Mot de passe" name="mdp" id="mdp" autocomplete="off">
                            </div>
                            <div class="input">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" placeholder="Confirmer le mot de passe" name="cmdp" id="cmdp" autocomplete="off">
                            </div>  
                            <input type="submit" name="inscription" value="S\'inscrire">
                        </form>';
            }
        ?>
    </div>
</body>

</html>