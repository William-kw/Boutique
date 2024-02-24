<?php 
	require_once("../connexion.php"); 
	checkconnexion();	
?>
<link rel="stylesheet" type="text/css" href="../CSS/barre.css">
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">
<link rel="stylesheet" href="../CSS/style.css">
<div class="barre-verticale">
	<div class="logo">
		<img src="../IMG/Boutique.png" alt="Boutique" class="boutique">
		<a href="index.php">Boµtique.com</a>
	</div>
	<div class="menu">
		<ul>
			<li><a href="index.php" class="<?php echo isset($index)? "page":"" ?>"><i class="fas fa-dashboard"></i>Dashboard</a></li>
			<li><a href="recette.php" class="<?php echo isset($recette)? "page":"" ?>"><i class="fa-solid fa-money-bill-trend-up"></i>Recettes</a></li>
			<li><a href="achat.php" class="<?php echo isset($achat)? "page":"" ?>"><i class="fa-solid fa-cart-shopping"></i>Achats</a></li>
			<li><a href="depense.php" class="<?php echo isset($depense)? "page":"" ?>"><i class="fa-solid fa-hand-holding-dollar"></i>Dépenses</a></li>
			<li><a href="charge.php" class="<?php echo isset($charge)? "page":"" ?>"><i class="fa-solid fa-file-invoice-dollar"></i>Charges</a></li>
			<li><a href="fournisseur.php" class="<?php echo isset($fournisseur)? "page":"" ?>"><i class="fa-solid fa-truck"></i>Fournisseurs</a></li>
			<li><a href="ristourne.php" class="<?php echo isset($ristourne)? "page":"" ?>"><i class="fa-solid fa-code-branch"></i>Ristournes</a></li>
			<li><a href="recapitulatif.php" class="<?php echo isset($recapitulatif)? "page":"" ?>"><i class="fa-solid fa-clipboard-list"></i>Récapitulatifs</a></li>
			<li><a href="utilisateur.php" class="<?php echo isset($utilisateur)? "page":"" ?>"><i class="fa-solid fa-users"></i>Utilisateurs</a></li>
			<li><a href="facture.php" class="<?php echo isset($facture)? "page":"" ?>"><i class="fa-solid fa-file"></i>Facturation</a></li>
			<li><a href="stock.php" class="<?php echo isset($stock)? "page":"" ?>"><i class="fa-solid fa-layer-group"></i>Stocks</a></li>
		</ul>
	</div>
</div>
<div class="barre-horizon">
	<div class="home">
		<input type="checkbox" name="" id="menu">
		<label for="menu"><i class="fa-solid fa-bars"></i></label>
	</div>
	<div class="search-bar">
		<i class="fa-solid fa-search"></i>
		<input type="search" name="search" id="search" class="search" placeholder="Rechercher...">
	</div>
	<div class="user-profil" id="masquer">
		<div class="profil" onclick="plus()">
			<div class="pp">
				<img src="../IMG/<?= $_SESSION['pp']; ?>" alt="User" class="user-pp">
			</div>
			<div class="text">
				<div class="nom" title="<?= $_SESSION['user']; ?> : <?= $_SESSION['roles']; ?>">
					<h3 class="nom"><?= $_SESSION['user']; ?></h3>
					<h6 class="nom"><?= $_SESSION['roles']; ?></h5>
				</div>
				<div class="notif"> <a href="notification.php"><i class="fa-solid fa-bell"></i></a></div>
			</div>
		</div>
		<div class="plus" id="plus">
			<li><a href="profil.php"><i class="fa-solid fa-pen-to-square"></i> Profil</a></li>
			<li><a href="../deconnexion.php" Onclick="return confirm('Vous allez vous déconnecter !')" title="Se déconnecter"><i class="fa-sharp fa-solid fa-power-off"></i> Déconnecter</a></li>			
		</div>
	</div>
</div>
<script type="text/javascript">
	function plus() {
		var plus = document.getElementById("plus");
		if (plus.style.display === "block") {
			plus.style.display = "none";
		} else {
			plus.style.display = "block";
		}
	}
</script>