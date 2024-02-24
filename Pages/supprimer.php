<?php 
    require_once('connexion.php');
    if (isset($_GET['idpr'])) {
        $idpr= $_GET['idpr'];

        $req= $connexion->prepare("DELETE FROM produits WHERE ID_PR=?");
        $res= $req->execute(array($idpr));
        if ($res) {
            header("location:index.php?resultat=supp_s");
        } else header("location:index.php?resultat=supp_e");
    }
?>