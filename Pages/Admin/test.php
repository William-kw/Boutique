<?php
    session_start();
    require_once("../connexion.php");
    if (isset($_SESSION['loged'])) {
        if ($_SESSION['priv'] < 2) {
            session_destroy();
            header("location:../../index.php?result=priv");
        }
    } else header("location:../../index.php?result=connect");

    $img = $connexion->prepare("SELECT img FROM
    test WHERE id = ?");
    $img->execute(array(1));
    $code_img= $img->fetch()["img"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/Boutique.png">
    <title>DASHBOARD</title>
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <img  alt="" srcset="">
    <img src="data:/jpg;base64,<?php echo base64_encode( $code_img); ?>" alt="">
</body>
<style>    
    .barre-verticale .menu ul li .bord{
        background-color: #112B4D;
        opacity: 1;
        transition: 0.8s;
        color: #FEEA06;
        border-left: 2px solid #FEEA06;
    }
</style>
</html>