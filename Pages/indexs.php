<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>
</head>
<body>
    <?php
        require_once('connexion.php');
        if (isset($_GET['resultat'])) {
            if ($_GET['resultat']== "chiffre") {
                echo "<p>Vous devez entrer un chiffre!!!</p>";
            }
            if ($_GET['resultat']== "vide") {
                echo "<p>Vueillez rempli tous champs!!!</p>";
            }
            if ($_GET['resultat']== "succes") {
                echo "<p>Ajoute réussit!!!</p>";
            }
            if ($_GET['resultat']== "supp_s") {
                echo "<p>Suppresion réussie!!!</p>";
            }
            if ($_GET['resultat']== "supp_e") {
                echo "<p>Echec suppresion!!!</p>";
            }
            if ($_GET['resultat']== "modif_s") {
                echo "<p>Modification réussie!!!</p>";
            }
            if ($_GET['resultat']== "modif_e") {
                echo "<p>Echec modification!!!</p>";
            }
        }

        if (isset($_POST["files"])) {
            var_dump($_FILES);
            $nom= $_FILES["image"]["name"];
            $nom_xt= $_FILES["image"]["type"];
            $nomf= "pp".$_FILES["image"]["type"];
            echo $nomf.$date;
        }
    ?>
    <h1>Stocks</h1>
    <form action="traitements.php" method="POST">
        <label>Produit</label><input type="text" name="produit" autocomplete="off"><br>
        <label>Quantité Initiale</label><input type="text" name="stock_i" autocomplete="off"><br>
        <input type="submit" name="sub">
    </form>
    <form action="#" method="POST" enctype="multipart/form-data">
        <h3>Envoyer un fichier</h3>
        <input type="file" name="image"><br>
        <input type="submit" name="files">
    </form>
    <table border="1">
        <th>Produits</th>
        <th>Stock Initial</th>
        <th>Stock Réel</th>
        <th>Actions </th>
        <?php
        $req= $connexion->query("SELECT * FROM produits ORDER BY Produit ASC");
        while ($res= $req->fetch()) {
        ?>
        <tr>
            <td><?php echo $res[1]; ?></td>
            <td><?php echo $res[2]; ?></td>
            <td><?php echo $res[3]; ?></td>
            <td>
                <a href="modifier.php?idpr=<?php echo $res[0]; ?>">Modifier</a>
                <a href="supprimer.php?idpr=<?php echo $res[0]; ?>">Supprimer</a>
            </td>
            
        </tr>
        <?php } ?>
    </table>
</body>
</html>