<?php
    require_once("../connexion.php");
    require_once("..\jpgraph-4.4.1\src\jpgraph.php");
    require_once("..\jpgraph-4.4.1\src\jpgraph_pie.php");

    /*$reqtotal= $connexion->query("SELECT SUM(MONTANT_ACH) AS TOTAL 
                                FROM fournisseurs ");
    $restotal= $reqtotal->fetch();
    $reqtotal= $connexion->query("SELECT F.ID_FR AS ID_FR, SUM(MONTANT_ACH) AS SOMME, FOURNISSEUR 
                                FROM fournisseurs F LEFT JOIN achats ON F.ID_FR=achats.ID_FR 
                                GROUP BY ID_FR ORDER BY SOMME DESC");
    $nb= $reqfr->rowCount();
    $resfr= $reqfr->fetch();
    $donnee= ($resfr["SOMME"] * 100) / $restotal["TOTAL"];*/
    $data= [20, 10, 9, 8, 8, 8, 7, 7, 6, 5, 4, 3, 3, 2, 1];

    $graph= new PieGraph(800,800);
    $theme_class= new VividTheme;
    $graph->SetTheme($theme_class);
    $p1= new PiePlot($data);
    $graph->Add($p1);
    $p1->ShowBorder();
    $p1->ExplodeAll(2);
    $p1->SetColor('black');
    $graph->Stroke();
?>