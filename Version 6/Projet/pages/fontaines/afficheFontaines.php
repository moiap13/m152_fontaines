<?php
session_start();
include "../fonctions.php";

$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');

$liens[0] = "";
$liens[1] = "";
$liens[2] = "";

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    if( $_SESSION["ADMIN"])
    {
        $liens[0] = '<li role="presentation"><a href="./gestionFontaines.php">Gestion fontaines</a></li>';
        $liens[1] = '<li role="presentation"><a href="../utilisateurs/gestion_utilisateurs.php">Gestion Utilisateurs</a></li>';
    }
    
    $liens[2] = '<li role="presentation"><a href="../utilisateurs/parametreCompte.php">Parametres du compte</a></li>';
}

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
    $input_cache_rayon = '<input type="hidden" id="hidden_rayon" value="'. recupere_infos_modif_utilisateur($_SESSION["ID"], $bdd)[0][1] .'" />';
else
    $input_cache_rayon = '<input type="hidden" id="hidden_rayon" value="500" />';

$input_cache_mode = '<input type="hidden" id="hidden_mode" value="affichage" />';
$input_cache_latlng = "";


if(isset($_REQUEST['mode']))
{
    $input_cache_mode = '<input type="hidden" id="hidden_mode" value="'.$_REQUEST['mode'].'" />';
}
if(isset($_REQUEST['latlng']))
{
    $input_cache_latlng = '<input type="hidden" id="hidden_latlng" value="'.$_REQUEST['latlng'].'" />';
}
?>
<!DOCTYPE html>
<!--
Auteurs : Robin Plojoux / Antonio Pisanello
Titre : Affiche Fontaines
Date : 21.11.2014
Version : 2.0
-->
<html>
    <head>
        <title>J'ai soif!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../../css/bootstrap/css/bootstrap.css"> 
        <link rel="stylesheet" href="../../css/style.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry"></script>
        <script type="text/javascript" src="../../javascript/googleMaps.js"></script> 
        <script type="text/javascript" src="../../javascript/afficheFontaines.js"></script>
    </head>
    <body>
        <div id="page">
            <header>
            </header>
            <nav>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="../../index.php">Accueil <span class="glyphicon glyphicon-home"></span></a></li>
                    <?php echo $liens[0]; echo $liens[1]; echo $liens[2]; ?>
                </ul>
            </nav>
            <section>
                <div id='map-canvas' style="height: 80%;"></div> 
                <div class='mapFooter'>
                    <div class="line_map_footer"><input type="range" value="500" max="5000" min="500" step="100"></div>
                    <div class="line_map_footer"><span id="nb_fontaines"></span></div>
                    <div class="line_map_footer"><span id="nom_rue"></span></div>
                    <?php echo $input_cache_mode; echo $input_cache_latlng; echo $input_cache_rayon;?>
                </div>
            </section>
            <footer>
                <div class="footer_infos">Robin Plojoux / Antonio Pisanello</div>
                <div class="footer_infos">CFPT-I 2014-2015 <span class="glyphicon glyphicon-copyright-mark"></span></div>
                <div class="footer_infos">Module 152</div>
            </footer>
            <?php echo instancier_tableau_javascript(recupere_fontaines($bdd)) ?>
        </div>
    </body>
</html>
