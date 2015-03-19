<?php
session_start();
include "../fonctions.php";

$lat = "";
$lng = "";
$id_user = "";

$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');

$liens[0] = "";
$liens[1] = "";
$liens[2] = "";

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    $id_user = $_SESSION["ID"];
    
    if( $_SESSION["ADMIN"])
    {
        $liens[0] = '<li role="presentation"><a href="./gestionFontaines.php">Gestion fontaines</a></li>';
        $liens[1] = '<li role="presentation"><a href="../utilisateurs/gestion_utilisateurs.php">Gestion Utilisateurs</a></li>';
    }
    
    $liens[2] = '<li role="presentation"><a href="../utilisateurs/parametreCompte.php">Parametres du compte</a></li>';
}
else
{
    header('Location: ../../index.php?error=Vous devez être connécté');
}

if(isset($_REQUEST["btn_ajouter"]))
{
    $lat = $_REQUEST["tbx_Lat"];
    $lng = $_REQUEST["tbx_Lng"];
    
    if(isset($_FILES['photo_fontaine']['error']) && $_FILES['photo_fontaine']['error'] != 4)
    {
        $photos = 1;
        
        if(isset($_REQUEST['nom_fontaine']) && $_REQUEST['nom_fontaine'] != '')
        {
            $nom_fontaine = $_REQUEST['nom_fontaine'] . get_image_format_file($_FILES['photo_fontaine']['type']);
        }
        else
        {
            $nom_fontaine = $_FILES['photo_fontaine']['name'];
        }
    }
    else 
    {
        $photos = 0;
    }
    
    
    
    
   
    $lastinsertid = ajout_fontaine($lat, $lng, $photos, $id_user, $bdd);
        
    if($lastinsertid > -1 && $photos == 1)
    {
        mkdir('../../img/Fontaines/' . $lastinsertid);

        move_uploaded_file($_FILES['photo_fontaine']['tmp_name'], '../../img/Fontaines/'. $lastinsertid . '/' . $nom_fontaine);
    }
    
    header('Location: ../../index.php?error=Enregistrer avec succès, Un administrateur doit accepter la fontaine pour qu\'elle soit visible dans j\'ai Soif');
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
                    <?php echo $liens[0]; echo $liens[1]; echo $liens[2]; ?>
                </ul>
            </nav>
            <section>
                
                    <div class="afficheCoord">
                        <label>Lat : </label><input type="number" name="tbx_tmp_Lat" value="<?php echo $lat; ?>" id="tbx_tmp_lat" onKeypress="tbx_changed_value()" onchange="tbx_changed_value()"/>
                        <label>Lng : </label><input type="number" name="tbx_tmp_lng" value="<?php echo $lng; ?>" id="tbx_tmp_lng" onKeypress="tbx_changed_value()" onchange="tbx_changed_value()"/>
                    </div>  
                    <div id='map-canvas' ></div> 
                    <div class="mapFooter">
                        <div class="line_map_footer"><span id="nom_rue"></span></div>
                        <div class="line_map_footer">
                            <form method="post" action="#" enctype="multipart/form-data">
                                <div id="div_form">
                                    <div id="fildset">
                                        <div id="titre">Ajout Photo</div>
                                        <div><input type="file" name="photo_fontaine" /></div>
                                        <div>
                                            <label>Nom fontaine : (facultatif)</label>
                                            <input type="text" name="nom_fontaine" />
                                        </div>
                                    </div>
                                    <div id="div_btn_ajout_fontaine">
                                        <input type="submit" value="Ajouter la fontaine" name="btn_ajouter" />
                                    </div>
                                </div>
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
