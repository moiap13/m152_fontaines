<?php
    include "../fonctions.php";
    
    $bdd = connexion('M152_Fontaines', 'localhost', 'root', '');
    
    $input_cache_mode = "";
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
                </ul>
            </nav>
            <section>
                <div id='map-canvas' style="height: 80%;"></div> 
                <div class='mapFooter'>
                    <div class="line_map_footer"><span id="nb_fontaines"></span></div>
                    <div class="line_map_footer"><span id="nom_rue"></span></div>
                    <?php echo $input_cache_mode; echo $input_cache_latlng;?>
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
