<?php
session_start();
include "../fonctions.php";

$lat = "";
$lng = "";
$id_user = "";

$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    $id_user = $_SESSION["ID"];
}
else
{
    header('Location: ../../index.php?error=Vous devez être connécté');
}

if(isset($_REQUEST["btn_ajouter"]))
{
    $lat = $_REQUEST["tbx_Lat"];
    $lng = $_REQUEST["tbx_Lng"];
    
    
}
?>
<!DOCTYPE html>
<!--
Auteurs : Robin Plojoux / Antonio Pisanello
Titre : Ajout Fontaine
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
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUVlw-hCn3f0Z2-hyEyjZdtzt8XvJLvV4"></script>
        <script type="text/javascript" src="../../javascript/googleMaps.js"></script> 
        <script type="text/javascript" src="../../javascript/ajoutFontaines.js"></script>
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
                
                    <div class="afficheCoord">
                        <label>Lat : </label><input type="number" name="tbx_tmp_Lat" value="<?php echo $lat; ?>" id="tbx_tmp_lat" onKeypress="tbx_changed_value()" onchange="tbx_changed_value()"/>
                        <label>Lng : </label><input type="number" name="tbx_tmp_lng" value="<?php echo $lng; ?>" id="tbx_tmp_lng" onKeypress="tbx_changed_value()" onchange="tbx_changed_value()"/>
                    </div>  
                    <div id='map-canvas' style="height: 80%;"></div> 
                    <div class="mapFooter">
                        <div class="line_map_footer"><span id="nom_rue"></span></div>
                        <div class="line_map_footer">
                            <form method="post" action="#">
                                <input type="submit" value="Ajouter" name="btn_ajouter" />
                                <input type="hidden" name="tbx_Lat" value="" id="tbx_lat" />
                                <input type="hidden" name="tbx_Lng" value="" id="tbx_lng" />
                            </form>
                        </div>
                    </div>
            </section>
            <footer>
                <div class="footer_infos">Robin Plojoux / Antonio Pisanello</div>
                <div class="footer_infos">CFPT-I 2014-2015 <span class="glyphicon glyphicon-copyright-mark"></span></div>
                <div class="footer_infos">Module 152</div>
            </footer>
        </div>
    </body>
</html>
