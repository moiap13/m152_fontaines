<?php
session_start();
include "../fonctions.php";

$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');

$liens[0] = "";
$liens[1] = "";
$liens[2] = "";

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    if($_SESSION["ADMIN"])
    {
        $admin = true;
        
        if(isset($_REQUEST['error']))
        {
            echo $_REQUEST['error'];
        }
        
        $liens[0] = '<li role="presentation"><a href="./gestionFontaines.php">Gestion fontaines</a></li>';
        $liens[1] = '<li role="presentation"><a href="../utilisateurs/gestion_utilisateurs.php">Gestion Utilisateurs</a></li>';
        $liens[2] = '<li role="presentation"><a href="../utilisateurs/parametreCompte.php">Parametres du compte</a></li>';
    }
    else
    {
        $admin = false;
        header('Location: ../../index.php?error=Vous devez être Admin');
    }
}
else
{
    $admin = false;
    header('Location: ../../index.php?error=Vous devez être Admin');
}


?>
<!DOCTYPE html>
<!--
Auteurs : Robin Plojoux / Antonio Pisanello
Titre : Gestion Fontaines
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
                <form method="" action="">
                    <fieldset class="liste_fontaine">
                        <legend>Liste de fontaines non actives</legend>
                        <?php if($admin) echo affiche_fontaines(recupere_fontaines($bdd), 0);?>
                    </fieldset>
                </form>
                <form method="" action="">
                    <fieldset class="liste_fontaine">
                        <legend>Liste de fontaines actives</legend>
                        <?php if($admin) echo affiche_fontaines(recupere_fontaines($bdd), 1);?>
                    </fieldset>
                </form>
            </section>
            <footer>
                <div class="footer_infos">Robin Plojoux / Antonio Pisanello</div>
                <div class="footer_infos">CFPT-I 2014-2015 <span class="glyphicon glyphicon-copyright-mark"></span></div>
                <div class="footer_infos">Module 152</div>
            </footer>
        </div>
    </body>
</html>
