<?php
    session_start();

    if (isset($_SESSION['loged'])) {
        if ($_SESSION['priv'] != 1) {
            session_destroy();
            header("location:../../index.php?result=priv");
        }
    } else header("location:../../index.php?result=connect");

    require_once("../connexion.php");

    $dates= date('d F Y   H:i:s');

    $select_jr= $connexion->query("SELECT MAX(ID_JR) AS jr FROM journees ");
    $journee= $select_jr->fetch();
    $journee= $journee['jr'];
    
                /* INSERTION DES RECETTES */
    if (isset($_POST["recette"])) {
        $recette= $_POST["montant_rec"];
        if (empty($_POST["date"])) {
            if (!empty($recette) && !empty($date)) {
                if (intval($recette)) {
                    $insert_rec= $connexion->query("INSERT INTO recettes VALUES (null, $recette) ");
                    if ($insert_rec) {
                        header("location:journee.php?date=vide");
                    }
                } else header("location:index.php?result=chiffre");
            } else header("location:index.php?result=vide");  
        } else {
            $date= $_POST["date"];
            if (!empty($recette) && !empty($date)) {
                if (intval($recette)) {
                    $insert_rec= $connexion->query("INSERT INTO recettes VALUES (null, $recette) ");
                    if ($insert_rec) {
                        header("location:journee.php?date=$date");
                    }
                } else header("location:index.php?result=chiffre");
            } else header("location:index.php?result=vide");          
        }
    }
    
                /* INSERTION DES FOURNISSEURS */
    if (isset($_POST["fournisseur_sub"])) {
        $fournisseur= $_POST["fournisseur"];
        if (!empty($fournisseur)) {
            $insert_fr= $connexion->prepare("INSERT INTO fournisseurs VALUES (null, ?)");
            $res_fr= $insert_fr->execute(array($fournisseur));
            if ($res_fr) {
                header("location:fournisseur.php?result=succes");
            }            
        } else header("location:fournisseur.php?result=vide");
    }
    
                /* INSERTION DES CHARGES */
    if (isset($_POST["charge_sub"])) {
        $charge= $_POST["charge"];
        if (!empty($charge)) {
            $insert_ch= $connexion->prepare("INSERT INTO charges VALUES (null, ?)");
            $res_ch= $insert_ch->execute(array($charge));
            if ($res_ch) {
                header("location:charge.php?result=succes");
            }            
        } else header("location:charge.php?result=vide");
    }
    
                /* INSERTION DES ACHATS */
    if (isset($_POST["achat"])) {
        $achat= $_POST["montant_ach"];
        $four= $_POST['four'];
        if (!empty($achat) && !empty($four)) {
            if (intval($achat)) {
                $insert_ach= $connexion->prepare("INSERT INTO achats VALUES (null, ?, ?, ?) ");
                $res_ach= $insert_ach->execute(array($journee, $four, $achat));
                if ($res_ach) {
                    header("location:achat.php?result=succes");
                }
            } else header("location:achat.php?result=chiffre");
        } else header("location:achat.php?result=vide");
    }
    
                /* INSERTION DES DEPENSES */
    if (isset($_POST["depense"])) {
        $depense= $_POST["montant_dep"];
        $charge= $_POST['charge'];
        if (!empty($depense) && !empty($charge)) {
            if (intval($depense)) {
                $insert_ach= $connexion->prepare("INSERT INTO depenses VALUES (null, ?, ?, ?) ");
                $res_ach= $insert_ach->execute(array($journee, $charge, $depense));
                if ($res_ach) {
                    header("location:depense.php?result=succes");
                }
            } else header("location:depense.php?result=chiffre");
        } else header("location:depense.php?result=vide");
    }
    
                /* INSERTION DES RISTOURNES */
    if (isset($_POST["ristourne"])) {
        $ristourne= $_POST["montant_rist"];
        $four= $_POST['four'];
        if (!empty($ristourne) && !empty($four)) {
            if (intval($ristourne)) {
                $insert_ach= $connexion->prepare("INSERT INTO ristournes VALUES (null, ?, ?, ?) ");
                $res_ach= $insert_ach->execute(array($journee, $four, $ristourne));
                if ($res_ach) {
                    header("location:ristourne.php?result=succes");
                }
            } else header("location:ristourne.php?result=chiffre");
        } else header("location:ristourne.php?result=vide");
    }
    
        /* INSERTION DES UTILISATEURS */
    if (isset($_POST["utilisateur"])) {
        $nom= $_POST["nom"];
        $privilege= $_POST["privilege"];
        $role= $_POST["role"];
        if (!empty($nom) && !empty($privilege) && !empty($role)) {
            $insert_util= $connexion->prepare("INSERT INTO utilisateurs (ID_UTIL, NOM, ROLES, PRIVILEGE) VALUES (null, ?, ?, ?)");
            $res_util= $insert_util->execute(array($nom, $role, $privilege));
            if ($res_util) {
                header("location:utilisateur.php?result=succes");
            }  
        } else header("location:utilisateur.php?result=vide");  
    }
?>