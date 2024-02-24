<?php 
    try {
        $connexion= new PDO ("mysql:host=localhost; dbname=boutique", "root", "");
    } catch (PDOException $th) {
        echo "Echec Connexion".$th->getMessage();
    }
    
    function mois($m){
        $mois= array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre");
        return $mois[$m-1];
    }

    function ladate($d){
        $ladate= explode("-",$d);
        return "le ".$ladate[2]." ".mois($ladate[1])." ".$ladate[0];
    }

    function checkconnexion(){
        if (isset($_SESSION['loged'])) {
            if ($_SESSION['priv'] < 2) {
                global $connexion;
                $connexion->prepare("UPDATE utilisateurs SET STATUT= 'Hors ligne' WHERE NOM= ?")->execute([$_SESSION['user']]);
                session_destroy();
                header("location:../../index.php?result=privilege");
            }
        } else {
            global $connexion;
            $connexion->prepare("UPDATE utilisateurs SET STATUT= 'Hors ligne' WHERE NOM= ?")->execute([$_SESSION['user']]);
            session_destroy();
            header("location:../../index.php?result=connect");
        }
    }
