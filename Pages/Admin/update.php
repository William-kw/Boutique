<?php
    session_start();
    require_once("../connexion.php");
    $date = date("YmdHis");

    // FOURNISSEUR 
    if (isset($_POST["idfr"]) && isset($_POST["fournisseur"])) {
        $idfr = $_POST["idfr"];
        $fournisseur = $_POST["fournisseur"];
        if (!empty($fournisseur)) {
            $update = $connexion->prepare("UPDATE fournisseurs SET FOURNISSEUR= ? WHERE ID_FR= ?");
            $res = $update->execute(array($fournisseur, $idfr));
            if ($res) echo "fournisseur";
        } else echo "Erreur : un ou plusieurs champs vide(s)";
    }

    // RECETTES 
    if (isset($_POST["date_rec"]) && isset($_POST["montant_rec"])) {
        $dateR = $_POST["date_rec"];
        $idjr = $_POST["idjr"];
        $idrec = $_POST["idrec"];
        $montant = $_POST["montant_rec"];
        if (!empty($dateR) && !empty($montant)) {
            $update_date =  $connexion->prepare("UPDATE journees SET DATE_JR= ? WHERE ID_JR = ?")->execute([$dateR, $idjr]);
            $update_rec = $connexion->prepare("UPDATE recettes SET MONTANT_REC= ? WHERE ID_REC= ?");
            $res_rec = $update_rec->execute(array($montant, $idrec));
            if ($res_rec) echo "recette";
        } else echo "Erreur : un ou plusieurs champs vide(s)";
    }

    // CHARGES 
    if (isset($_POST["idch"]) && isset($_POST["charge"])) {
        $idch = $_POST["idch"];
        $charge = $_POST["charge"];
        if (!empty($charge)) {
            $update = $connexion->prepare("UPDATE charges SET CHARGE= ? WHERE ID_CH= ?");
            $res = $update->execute(array($charge, $idch));
            if ($res) echo "charge";
        } else echo "Erreur : un ou plusieurs champs vide(s)";
    }

    // ACHATS 
    if (isset($_POST["idach"]) && isset($_POST["four"]) && isset($_POST["montant_ach"])) {
        $idach = $_POST["idach"];
        $fournisseur = $_POST['four'];
        $montant = $_POST["montant_ach"];
        if (!empty($montant) && !empty($fournisseur)) {
            $update = $connexion->prepare("UPDATE achats SET ID_FR= ?, MONTANT_ACH= ? WHERE ID_ACH= ?");
            $res = $update->execute(array($fournisseur, $montant, $idach));
            if ($res) echo "achat";
        } else echo "Erreur : un ou plusieurs champs vide(s)";
    }

    // DEPENSES 
    if (isset($_POST["iddep"]) && isset($_POST["char"]) && isset($_POST["montant_dep"])) {
        $iddep = $_POST["iddep"];
        $charge = $_POST['char'];
        $montant = $_POST["montant_dep"];
        if (!empty($charge) && !empty($montant)) {
            $update = $connexion->prepare("UPDATE depenses SET ID_CH= ?, MONTANT_DEP= ? WHERE ID_DEP= ?");
            $res = $update->execute(array($charge, $montant, $iddep));
            if ($res) echo "depense";
        } else echo "Erreur : un ou plusieurs champs vide(s)";
    }

    // RISTOURNES 
    if (isset($_POST["idrist"]) && isset($_POST["four"]) && isset($_POST["montant_rist"])) {
        $idrist = $_POST["idrist"];
        $fournisseur = $_POST['four'];
        $montant = $_POST["montant_rist"];
        if (!empty($fournisseur) && !empty($montant)) {
            $update = $connexion->prepare("UPDATE ristournes SET ID_FR= ?, MONTANT_RIST= ? WHERE ID_RIST= ?");
            $res = $update->execute(array($fournisseur, $montant, $idrist));
            if ($res) echo "ristourne";
        } else echo "Erreur : un ou plusieurs champs vide(s)";
    }

    // INFOS 
    if (isset($_FILES["image"]["name"]) && isset($_POST["nouveau_mdp"]) && isset($_POST["ancien_mdp"]) && isset($_POST["confirm_mdp"])) {
        $img_nom = $_FILES["image"]["name"];
        $amdp = $_POST["ancien_mdp"];
        $nmdp = $_POST["nouveau_mdp"];
        $cmdp = $_POST["confirm_mdp"];
        $req = $connexion->prepare("SELECT ID_UTIL, MDP FROM utilisateurs WHERE NOM=?");
        $req->execute(array($_SESSION["user"]));
        $res = $req->fetch();

        // PHOTO DE PROFIL 
        if (!empty($img_nom)) {
            $img_nom_tmp = $_FILES["image"]["tmp_name"];
            $img_ext = strrchr($img_nom, ".");
            $img_nom = $_SESSION["user"] ."-Profil". $img_ext;
            $extension = array(".png", ".jpg", ".jpeg", ".PNG", ".JPEG", ".JPG");
            if (in_array($img_ext, $extension)) {
                $deplacer = move_uploaded_file($img_nom_tmp, "../IMG/" . $img_nom);
                
                if (file_exists("../IMG/".$_SESSION["pp"])) {
                    $suppression = unlink("../IMG/".$_SESSION["pp"]);
                    if ($suppression) {
                        if ($deplacer) {
                            $update = $connexion->prepare("UPDATE utilisateurs SET IMG= ? WHERE ID_UTIL=?");
                            $udpate_res = $update->execute(array($img_nom, $res["ID_UTIL"]));
                            if ($udpate_res) {
                                $_SESSION["pp"] = $img_nom;
                                echo "Success";
                                return;
                            }
                        } else echo "Erreur : choisir un fichier de moins de 1Mo";
                    } else echo "Erreur : echec de suppression";
                } else echo "Erreur : le fichier n'existe pas";
            } else echo "Erreur : choisir un fichier image (PNG, JPG, JPEG)";
        }

        // MOT DE PASSE 
        if (!empty($amdp) && !empty($nmdp) && !empty($cmdp)) {
            if (password_verify($amdp, $res["MDP"])) {
                if ($nmdp == $cmdp) {
                    $cmdp = password_hash($cmdp, PASSWORD_DEFAULT);
                    $update = $connexion->prepare("UPDATE utilisateurs SET MDP= ? WHERE ID_UTIL=?");
                    $udpate_res = $update->execute(array($cmdp, $res["ID_UTIL"]));
                    if ($udpate_res) echo "mdp";
                } else echo "Erreur : les 2 mots de passe sont différents";
            } else echo "Erreur : mot de passe incorrecte";
        } else echo "Erreur : un ou plusieurs champs vide(s)";

        // MOT DE PASSE ET PHOTO DE PROFIL
    }