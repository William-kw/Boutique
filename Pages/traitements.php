<?php
    $connexion= new PDO("mysql:host=localhost; dbname=boutique", "root", "");

    if (isset($_POST["sub"])) {
        $stock_i= $_POST["stock_i"];
        $produit= $_POST["produit"];        

       if (!empty($stock_i) && !empty($produit)) {
            if (!intval($stock_i)) {
                header("location: index.php?resultat=chiffre");
            }
            $req= $connexion->prepare("INSERT INTO produits VALUES (null, ?, ?, ?)");
            $res= $req->execute(array($produit, $stock_i, $stock_i));
            if ($res) {
                header("location:index.php?resultat=succes");
            }
        } else {
            header("location: index.php?resultat=vide");
        }
    }
?>