<?php
    require_once('connexion.php');
    if (isset($_GET['resultat'])) {
        if ($_GET['resultat']== "chiffre") {
            echo "<p>Vous devez entrer un chiffre!!!</p>";
        }
        if ($_GET['resultat']== "vide") {
            echo "<p>Veuillez rempli tous champs!!!</p>";
        }
        if ($_GET['resultat']== "succes") {
            echo "<p>Modification réussie!!!</p>";
        }
    }

    if (isset($_GET['idpr'])) {
        $idpr= $_GET['idpr'];
?>
<h1>Stocks</h1>
<form action="update.php" method="POST">
    <?php 
        $req= $connexion->query("SELECT * FROM produits WHERE ID_PR= $idpr");        
        while ($aff= $req->fetch()) {
    ?>
    <input type="hidden" name="idpr" value="<?php echo $aff[0]; ?>">
    <label>Produit</label><input type="text" name="produit_m" value="<?php echo $aff[1]; ?>" autocomplete="off"><br>
    <label>Quantité Initiale</label><input type="text" value="<?php echo $aff[2]; ?>" name="stock_im" autocomplete="off"><br>
    <label>Quantité Réelle</label><input type="text" value="<?php echo $aff[3]; ?>" name="stock_rm" autocomplete="off"><br>
    <input type="submit" name="sub_m" value= "Modifier">
    <?php } 
    }
    ?>
</form>