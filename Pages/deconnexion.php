<?php
    session_start();
    require_once("connexion.php");
    $req= $connexion->prepare("UPDATE utilisateurs SET STATUT= 'Hors ligne' WHERE NOM= ?");
    $update= $req->execute([$_SESSION['user']]);
    if ($update) {
        $_SESSION['loged']= "Hors ligne";
        session_destroy();
        header("location:../index.php");
    }
?>