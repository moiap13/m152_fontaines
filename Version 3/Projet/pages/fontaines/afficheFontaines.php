<?php

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
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUVlw-hCn3f0Z2-hyEyjZdtzt8XvJLvV4"></script>
        <script type="text/javascript" src="../../javascript/googleMaps.js"></script> 
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
                <div class='mapFooter'></div>
            </section>
            <footer>
                <div class="footer_infos">Robin Plojoux / Antonio Pisanello</div>
                <div class="footer_infos">CFPT-I 2014-2015 <span class="glyphicon glyphicon-copyright-mark"></span></div>
                <div class="footer_infos">Module 152</div>
            </footer>
        </div>
    </body>
</html>
