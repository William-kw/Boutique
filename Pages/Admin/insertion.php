<?php
    session_start();
require_once("../connexion.php");

$select_jr = $connexion->query("SELECT ID_JR FROM journees ORDER BY ID_JR DESC LIMIT 1");
$journee = $select_jr->fetch();
$journee = $journee['ID_JR'];

// RECUPERER LE SOLDE D'HIER 
$reqsh = $connexion->query("SELECT ID_SLD, SOLDE FROM soldes ORDER BY ID_SLD DESC LIMIT 1");
$resSH = $reqsh->fetch();
$solde_hier = $resSH["SOLDE"];
$idsld = $resSH["ID_SLD"];

// INSERTION DES RECETTES 
if (isset($_POST["montant_rec"]) && isset($_POST["date"])) {
    intval($recette = $_POST["montant_rec"]);
    $date = $_POST["date"];
    if (!empty($recette) && !empty($date)) {
        $reqCheckDate = $connexion->query("SELECT * FROM journees WHERE DATE_JR <= '$date'");
        if ($reqCheckDate->rowCount() > 0) {
            if (is_int($recette) || $recette > 0) {
                // ID_MOIS 
                $req = $connexion->query("SELECT MAX(ID_MOIS) AS ID_MOIS FROM mois");
                $idmois = $req->fetch();
                $idmois = $idmois["ID_MOIS"];
                $jour = explode("-", $date);
                if (($jour[2] * 1) === 06) {
                    $idmois += 1;
                    $req = $connexion->query("INSERT INTO mois VALUES ('$idmois')");
                }
                // MISE A JOUR DU SOLDE DE LA JOURNEE
                // RECUPERER LES ACHATS D'HIER 
                $reqah = $connexion->query("SELECT SUM(MONTANT_ACH) AS HIER 
                        FROM achats 
                        WHERE ID_JR=(SELECT ID_JR FROM journees ORDER BY ID_JR DESC LIMIT 1) 
                        GROUP BY ID_JR ORDER BY ID_ACH DESC LIMIT 1");
                $resAH = $reqah->fetch();
                $achat_hier = (empty($resAH["HIER"])) ? 0: $resAH["HIER"];

                // RECUPERER LA DEPENSE D'HIER 
                $reqdh = $connexion->query("SELECT SUM(MONTANT_DEP) AS HIER 
                        FROM depenses 
                        WHERE ID_JR=(SELECT ID_JR FROM journees ORDER BY ID_JR DESC LIMIT 1)                                    
                        GROUP BY ID_JR ORDER BY ID_DEP DESC LIMIT 1");
                $resDH = $reqdh->fetch();
                $depense_hier = (empty($resDH["HIER"])) ? 0: $resDH["HIER"];

                $solde_soir = $solde_hier - $achat_hier - $depense_hier;
                $req_update_solde = $connexion->prepare("UPDATE soldes SET SOLDE= ? WHERE ID_SLD= ?");
                $up = $req_update_solde->execute([$solde_soir, $idsld]);
                if ($up) {
                    // RECUPERER LA RECETTE D'HIER 
                    $reqrh = $connexion->query("SELECT MONTANT_REC FROM recettes ORDER BY ID_REC DESC LIMIT 1");
                    $resRH = $reqrh->fetch();
                    $recette_hier = $resRH["MONTANT_REC"];
                    $solde_matin = (date('d') == 06) ? $solde_soir - $_SESSION["benefice"] : $solde_soir + $recette_hier;
                    $insert_rec = $connexion->query("INSERT INTO recettes VALUES (null, $recette)");
                    $insert_sld = $connexion->query("INSERT INTO soldes VALUES(null, $solde_matin)");

                    // CREATION D'UNE NOUVELLE JOURNEE 
                    $reqidsld = $connexion->query("SELECT ID_SLD FROM soldes ORDER BY ID_SLD DESC LIMIT 1");
                    $idsldjour = $reqidsld->fetch();
                    $idsldjour = $idsldjour["ID_SLD"];
                    $select_rec = $connexion->query("SELECT ID_REC FROM recettes ORDER BY ID_REC DESC LIMIT 1");
                    $idrec = $select_rec->fetch();
                    $idrec = $idrec['ID_REC'];
                    $insert_jr = $connexion->prepare("INSERT INTO journees VALUES (null, ?, ?, ?, ?)");
                    $insert = $insert_jr->execute([$idrec, $idmois, $idsldjour, $date]);
                    if ($insert) echo "Success";
                } else header("location:recette.php?result=update");
            } else echo "Erreur : Le montant n'est pas valide";
        } else echo "Erreur : cette date existe déjà";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}

// INSERTION DES FOURNISSEURS 
if (isset($_POST["fournisseur"])) {
    $fournisseur = $_POST["fournisseur"];
    if (!empty($fournisseur)) {
        $insert_fr = $connexion->prepare("INSERT INTO fournisseurs VALUES (null, ?)");
        $res_fr = $insert_fr->execute([$fournisseur]);
        if ($res_fr) echo "Success";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}

/* INSERTION DES CHARGES */
if (isset($_POST["charge"])) {
    $charge = $_POST["charge"];
    if (!empty($charge)) {
        $insert_ch = $connexion->prepare("INSERT INTO charges VALUES (null, ?)");
        $res_ch = $insert_ch->execute([$charge]);
        if ($res_ch) echo "Success";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}

/* INSERTION DES ACHATS */
if (isset($_POST["montant_ach"]) && isset($_POST["four"])) {
    $achat = $_POST["montant_ach"];
    $four = $_POST['four'];
    if (!empty($achat) && !empty($four)) {
        if (intval($achat)) {
            $insert_ach = $connexion->prepare("INSERT INTO achats VALUES (null, ?, ?, ?) ");
            $res_ach = $insert_ach->execute([$journee, $four, $achat]);
            if ($res_ach) echo "Success";
        } else echo "Erreur : entrez un nombre";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}

/* INSERTION DES DEPENSES */
if (isset($_POST["charge_dep"]) && isset($_POST["montant_dep"])) {
    $depense = $_POST["montant_dep"];
    $charge = $_POST["charge_dep"];
    if (!empty($depense) && !empty($charge)) {
        if (intval($depense)) {
            $insert_ach = $connexion->prepare("INSERT INTO depenses VALUES (null, ?, ?, ?) ");
            $res_ach = $insert_ach->execute([$journee, $charge, $depense]);
            if ($res_ach) echo "Success";
        } else echo "Erreur : entrez un nombre";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}

/* INSERTION DES RISTOURNES */
if (isset($_POST["montant_rist"])) {
    $ristourne = $_POST["montant_rist"];
    $four = $_POST['four'];
    if (!empty($ristourne) && !empty($four)) {
        if (intval($ristourne)) {
            $insert_ach = $connexion->prepare("INSERT INTO ristournes VALUES (null, ?, ?, ?) ");
            $res_ach = $insert_ach->execute([$journee, $four, $ristourne]);
            if ($res_ach) echo "Success";
        } else echo "Erreur : entrez un nombre";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}

/* INSERTION DES UTILISATEURS */
if (isset($_POST["nom"]) && isset($_POST["role"]) && isset($_POST["mdp"]) && isset($_POST["cmdp"])) {
    $nom = $_POST["nom"];
    $role = $_POST["role"];
    $mdp = $_POST["mdp"];
    $cmdp = $_POST["cmdp"];
    if (!empty($nom) && !empty($mdp) && !empty($cmdp) && !empty($role)) {
        $req = $connexion->query("SELECT * FROM utilisateurs WHERE NOM= '$nom'");
        if ($req->rowCount() == 0) {
            $privilege = ($role == "Administrateur") ? 2 : 1;
            if ($mdp == $cmdp) {
                $cmdp = password_hash($cmdp, PASSWORD_DEFAULT);
                $insert_util = $connexion->prepare("INSERT INTO utilisateurs (ID_UTIL, NOM, MDP, ROLES, PRIVILEGE) VALUES (null, ?, ?, ?, ?)");
                $res_util = $insert_util->execute([$nom, $cmdp, $role, $privilege]);
                if ($res_util) echo "Success";
            } else echo "Erreur : les 2 mots de passes sont différents";
        } else echo "Erreur : ce nom d'utilisateur est déjà pris";
    } else echo "Erreur : un ou plusieurs champs vide(s)";
}
