<?php
    session_start();
    require_once("../connexion.php");
    $date= date('ymdhms');

    // FOURNISSEUR //
    if (isset($_POST["fournisseur_mod"])) {
        $idfr= $_POST["idfr"];
        $fournisseur= $_POST["fournisseur"];

        $update= $connexion->prepare("UPDATE fournisseurs SET FOURNISSEUR= ? WHERE ID_FR= ?");
        $res= $update->execute(array($fournisseur, $idfr));

        if ($res) {
            header("location: fournisseur.php");
        }
    }

    // RECETTES //
    if (isset($_POST["recette_mod"])) {
        $idrec= $_POST["idrec"];
        $montant= $_POST["montant_rec"];

        $update= $connexion->prepare("UPDATE recettes SET MONTANT_REC= ? WHERE ID_REC= ?");
        $res= $update->execute(array($montant, $idrec));

        if ($res) {
            header("location: recette.php");
        }
    }

    // CHARGES //
    if (isset($_POST["charge_mod"])) {
        $idch= $_POST["idch"];
        $charge= $_POST["charge"];

        $update= $connexion->prepare("UPDATE charges SET CHARGE= ? WHERE ID_CH= ?");
        $res= $update->execute(array($charge, $idch));

        if ($res) {
            header("location: charge.php");
        }
    }

    // ACHATS //
    if (isset($_POST["achat_mod"])) {
        $idach= $_POST["idach"];
        $fournisseur= $_POST['four'];
        $montant= $_POST["montant_ach"];
        
        $update= $connexion->prepare("UPDATE achats SET ID_FR= ?, MONTANT_ACH= ? WHERE ID_ACH= ?");
        $res= $update->execute(array($fournisseur, $montant, $idach));

        if ($res) {
            header("location: achat.php");
        }
    }

    // DEPENSES //
    if (isset($_POST["depense_mod"])) {
        $iddep= $_POST["iddep"];
        $charge= $_POST['char'];
        $montant= $_POST["montant_dep"];
        
        $update= $connexion->prepare("UPDATE depenses SET ID_CH= ?, MONTANT_DEP= ? WHERE ID_DEP= ?");
        $res= $update->execute(array($charge, $montant, $iddep));

        if ($res) {
            header("location: depense.php");
        }
    }

    // RISTOURNES //
    if (isset($_POST["ristourne_mod"])) {
        $idrist= $_POST["idrist"];
        $fournisseur= $_POST['four'];
        $montant= $_POST["montant_rist"];
        
        $update= $connexion->prepare("UPDATE ristournes SET ID_FR= ?, MONTANT_RIST= ? WHERE ID_RIST= ?");
        $res= $update->execute(array($fournisseur, $montant, $idrist));

        if ($res) {
            header("location: ristourne.php");
        }
    }

    // INFOS //
    if (isset($_POST["infos"])) {
        $img_nom= $_FILES["image"]["name"];
        $amdp= $_POST["ancien_mdp"];
        $nmdp= $_POST["nouveau_mdp"];
        $cmdp= $_POST["confirm_mdp"];
        $req= $connexion->prepare("SELECT ID_UTIL, MDP FROM utilisateurs WHERE NOM=?");
        $req->execute(array($_SESSION["user"]));
        $res= $req->fetch();
        // MOT DE PASSE ET PHOTO DE PROFIL //
        if (!empty($amdp) && !empty($nmdp) && !empty($cmdp) && !empty($img_nom)) {
            $img_nom_tmp= $_FILES["image"]["tmp_name"];
            $img_ext= strrchr($img_nom, ".");
            $img_nom= "pp".$date.$img_ext;
            $extension= array(".png", ".jpg", ".jpeg", ".PNG", ".JPEG", ".JPG", "");
            if (in_array($img_ext, $extension)) {
                move_uploaded_file($img_nom_tmp, "../IMG/".$img_nom);
                if (password_verify($amdp, $res["MDP"])) {
                    if ($nmdp == $cmdp) {
                        $cmdp= password_hash($cmdp, PASSWORD_DEFAULT);
                        $update= $connexion->prepare("UPDATE utilisateurs SET MDP= ?, IMG= ? WHERE ID_UTIL=?");
                        $udpate_res= $update->execute(array($cmdp, $img_nom, $res["ID_UTIL"]));
                        if ($udpate_res) { 
                            header("location:profil.php?result=succes");
                        }
                    } else header("location:profil?result=cmdp");
                } else header("location:profil?result=amdp");
            } else header("location:profil.php?result=img");
        } else header("location:profil.php");
        // PHOTO DE PROFIL //
        if (!empty($img_nom) && empty($amdp) && empty($nmdp) && empty($cmdp)) {
            $img_nom_tmp= $_FILES["image"]["tmp_name"];
            $img_ext= strrchr($img_nom, ".");
            $img_nom= "pp".$date.$img_ext;
            $extension= array(".png", ".jpg", ".jpeg", ".PNG", ".JPEG", ".JPG");
            if (in_array($img_ext, $extension)) {
                move_uploaded_file($img_nom_tmp, "../IMG/".$img_nom);
                $update= $connexion->prepare("UPDATE utilisateurs SET IMG= ? WHERE ID_UTIL=?");
                $udpate_res= $update->execute(array($img_nom, $res["ID_UTIL"]));
                $img_ext= strrchr($img_nom, ".");
                $extension= array(".png", ".jpg",".jpeg", ".PNG", ".JPEG", ".JPG");
                if ($udpate_res) { 
                    header("location:profil.php?result=succes");
                }
            } else header("location:profil.php?result=img");
        }
        // MOT DE PASSE //
        if (!empty($amdp) && !empty($nmdp) && !empty($cmdp) && empty($img_nom)) {
            if (password_verify($amdp, $res["MDP"])) {
                if ($nmdp == $cmdp) {
                    $cmdp= password_hash($cmdp, PASSWORD_DEFAULT);
                    $update= $connexion->prepare("UPDATE utilisateurs SET MDP= ? WHERE ID_UTIL=?");
                    $udpate_res= $update->execute(array($cmdp, $res["ID_UTIL"]));
                    if ($udpate_res) { 
                        header("location:profil.php?result=succes");
                    }
                } else header("location:profil?result=cmdp");
            } else header("location:profil?result=amdp");
        }
    }
?>