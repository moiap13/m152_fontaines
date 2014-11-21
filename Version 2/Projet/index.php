<?php
$mode = 'Login';
$mode_lien = 'Inscription';
$input = "";
$taille_login = "180px";
$petite_image = 'glyphicon glyphicon-send';

if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'Inscription')
{
    $mode = 'Inscription';
    $input = '<input type="password" name="tbx_confirm" placeholder="Confirmer MDP" class="espace_login"/>';
    $mode_lien = 'Login';
    $taille_login = "210px";
    $petite_image = 'glyphicon glyphicon-pencil';
}



?>
<!DOCTYPE html>
<!--
Auteurs : Robin Plojoux / Antonio Pisanello
Titre : Index
Date : 21.11.2014
Version : 2.0
-->
<html>
    <head>
        <title>Maquette HTML5 Bootstrap</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css"> 
        <link rel="stylesheet" href="css/style.css"> 
        <style>
            #login {
                float: right;
                width: 200px;
                height: <?php echo $taille_login; ?>;
            }
        </style>
    </head>
    <body>
        <div id="page">
            <header>
            </header>
            <nav>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="./index.html">Accueil <span class="glyphicon glyphicon-home"></span></a></li>
                    <li role="presentation"><a href="#">Page1</a></li>
                    <li role="presentation"><a href="#">Page2</a></li>
                </ul>
            </nav>
            <section>
                <aside id="login" class="panel panel-info" >
                    <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> <?php echo $mode; ?></div>
                    <div class="panel-body" >
                        <form method="post" action="#">
                            <input type="text" name="tbx_uid" placeholder="Nom d'utilisateur" class="espace_login"/>
                            <input type="password" name="tbx_pwd" placeholder="Mot de passe" class="espace_login"/>
                            <?php echo $input; ?>
                            <input type="submit" name="btn_envoyer" value="<?php echo $mode; ?>" class="espace_login"/> <span class="<?php echo $petite_image; ?>"></span>
                            <p><a id="inscription" href="index.php?mode=<?php echo $mode_lien; ?>" ><?php echo $mode_lien; ?></a></p>
                        </form>   
                    </div>
                </aside>
            </section>
            <footer>
                <div class="footer_infos">Robin Plojoux / Antonio Pisanello</div>
                <div class="footer_infos">CFPT-I 2014-2015 <span class="glyphicon glyphicon-copyright-mark"></span></div>
                <div class="footer_infos">Module 152</div>
            </footer>
        </div>
    </body>
</html>
