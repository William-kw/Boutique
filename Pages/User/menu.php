<link rel="stylesheet" type="text/css" href="../CSS/barre.css">
<link rel="stylesheet" type="text/css" href="../fontawesomev6/css/all.css">
<link rel="stylesheet" href="../CSS/style.css">
<div class="barre-verticale">
	<div class="logo">
		<img src="../IMG/Boutique.png" alt="Boutique" class="boutique">
		<a href="index.php">Boµtique.com</a>
	</div>
	<div class="menu">
		<ul>
			<li><a href="index.php" class="recette"><i class="fa-solid fa-money-bill-trend-up"></i>Recettes</a></li>
			<li><a href="achat.php" class="achat"><i class="fa-solid fa-cart-shopping"></i>Achats</a></li>
			<li><a href="depense.php" class="depense"><i class="fa-solid fa-hand-holding-dollar"></i>Dépenses</a></li>
			<li><a href="facture.php" class="ristourne"><i class="fa-solid fa-file"></i>Facturation</a></li>
			<li><a href="chat.php" class="message"><i class="fa-solid fa-layer-group"></i>Stock</a></li>
		</ul>
	</div>
</div>
<div class="barre-horizon">
	<div class="home">
		<input type="checkbox" name="" id="menu">
		<label for="menu"><i class="fa-solid fa-bars"></i></label>
	</div>
	<div class="search">
		<i class="fa-solid fa-search"></i>
		<input type="search" name="search" class="search" placeholder="Rechercher...">
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