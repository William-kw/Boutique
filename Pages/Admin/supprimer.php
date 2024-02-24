<?php
    require_once("../connexion.php");

    /* RECETTES */
    if (isset($_GET["idrec"])) {
        $idrec= $_GET["idrec"];
        $sup_rec= $connexion->prepare("DELETE FROM recettes WHERE ID_REC=? LIMIT 1");
        $res_sup_rec= $sup_rec->execute(array($idrec));
        if ($res_sup_rec) {
            header("location:recette.php");
        }
    }

    /* FOURNISSEURS */
    if (isset($_GET["idfr"])) {
        $idfr= $_GET["idfr"];
        $sup_fr= $connexion->prepare("DELETE FROM fournisseurs WHERE ID_FR=? LIMIT 1");
        $res_sup_fr= $sup_fr->execute(array($idfr));
        if ($res_sup_fr) {
            header("location:fournisseur.php");
        }
    }

    /* CHARGES */
    if (isset($_GET["idch"])) {
        $idch= $_GET["idch"];
        $sup_ch= $connexion->prepare("DELETE FROM charges WHERE ID_CH=? LIMIT 1");
        $res_sup_ch= $sup_ch->execute(array($idch));
        if ($res_sup_ch) {
            header("location:charge.php");
        }
    }

    /* DEPENSES */
    if (isset($_GET["iddep"])) {
        $iddep= $_GET["iddep"];
        $sup_dep= $connexion->prepare("DELETE FROM depenses WHERE ID_DEP=? LIMIT 1");
        $res_sup_dep= $sup_dep->execute(array($iddep));
        if ($res_sup_dep) {
            header("location:depense.php");
        }
    }

    /* ACHATS */
    if (isset($_GET["idach"])) {
        $idach= $_GET["idach"];
        $sup_ch= $connexion->prepare("DELETE FROM achats WHERE ID_ACH=? LIMIT 1");
        $res_sup_ch= $sup_ch->execute(array($idach));
        if ($res_sup_ch) {
            header("location:achat.php");
        }
    }

    /* RISTOURNES */
    if (isset($_GET["idrist"])) {
        $idrist= $_GET["idrist"];
        $sup_rist= $connexion->prepare("DELETE FROM ristournes WHERE ID_RIST=? LIMIT 1");
        $res_sup_rist= $sup_rist->execute(array($idrist));
        if ($res_sup_rist) {
            header("location:ristourne.php");
        }
    }

    /* UTILISATEURS */
    if (isset($_GET["idutil"])) {
        $idutil= $_GET["idutil"];
        $sup_util= $connexion->prepare("DELETE FROM utilisateurs WHERE ID_UTIL=? LIMIT 1");
        $res_sup_util= $sup_util->execute(array($idutil));
        if ($res_sup_util) {
            header("location:utilisateur.php");
        }
    }

    /* REINITIALISER LE MOT DE PASSE */
    if (isset($_GET["idutil_reset"])) {
        $idutil_reset= $_GET["idutil_reset"];
        $pass= password_hash("1234", PASSWORD_DEFAULT);
        $sup_util= $connexion->prepare("UPDATE utilisateurs  SET MDP= ? WHERE ID_UTIL=? LIMIT 1");
        $res_sup_util= $sup_util->execute(array($pass, $idutil_reset));
        if ($res_sup_util) {
            header("location:utilisateur.php");
        }
    }
