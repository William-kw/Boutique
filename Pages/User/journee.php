<?php
    session_start();

    if (isset($_SESSION['loged'])) {
        if ($_SESSION['priv'] != 1) {
            session_destroy();
            header("location:../../index.php?result=priv");
        }
    } else header("location:../../index.php?result=connect");
    
    require_once("../connexion.php");
    /* CREATION D'UNE NOUVELLE JOURNEE */
    if (isset($_GET['date'])) {
        $date= $_GET['date'];
        if ($date == "vide") {
            $date= date('Y-m-d');
            $select_rec= $connexion->query("SELECT MAX(ID_REC) AS idrec FROM recettes ");
            $idrec= $select_rec->fetch();
            $idrec= $idrec['idrec'];
            $insert_jr= $connexion->prepare("INSERT INTO journees VALUES (null, ?, ?, ?) ");
            $insert= $insert_jr->execute(array($idrec, $idmois, $date));
            if ($insert) {
                header("location:index.php?result=succes");
            }
        } else {
            $select_rec= $connexion->query("SELECT MAX(ID_REC) AS idrec FROM recettes ");
            $idrec= $select_rec->fetch();
            $idrec= $idrec['idrec'];
            $insert_jr= $connexion->prepare("INSERT INTO journees VALUES (null, ?, ?, ?) ");
            $insert= $insert_jr->execute(array($idrec, $idmois, $date));
            if ($insert) {
                header("location:index.php?result=succes");
            }        
        }
    }
?>