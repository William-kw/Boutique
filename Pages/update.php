<?php
    require_once('connexion.php');

    if (isset($_POST['sub_m'])) {
        $idpr= $_POST['idpr'];
        $produit= $_POST['produit_m'];
        $stock_i= $_POST['stock_im'];
        $stock_r= $_POST['stock_rm'];

        if (!empty($stock_i) && !empty($produit)) {
            if (!intval($stock_i) || !intval($stock_r)) {
                header("location: modifier.php?resultat=chiffre");
            } else {
                $req= $connexion->prepare("UPDATE produits SET Produit=?, Qte_Initiale=?, Qte_Stock= ? WHERE ID_PR=?");
                $res= $req->execute(array($produit, $stock_i, $stock_r, $idpr));
                if ($res) {
                   header("location:indexs.php?resultat=modif_s");
                } else header("location:indexs.php?resultat=modif_e");                
            }
        } else {
             header("location: modifier.php?resultat=vide");
        }
    }
?>