<?php
session_start();
include 'pages/fonctions.php';


$mode = 'Login';
$mode_lien = 'Inscription';

$input[0] = '<input type="text" name="tbx_uid" placeholder="Nom d\'utilisateur" class="espace_login"/>';
$input[1] = '<input type="password" name="tbx_pwd" placeholder="Mot de passe" class="espace_login"/>';
$input[2] = "";

$liens[0] = "";
$liens[1] = "";
$liens[2] = "";

$taille_login = "180px";
$petite_image = 'glyphicon glyphicon-send';
$btn_ajout_fontaine = "";
$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');
        
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'Inscription')
{
    $mode = 'Inscription';
    $input[2] = '<input type="password" name="tbx_confirm" placeholder="Confirmer MDP" class="espace_login"/>';
    $mode_lien = 'Login';
    $taille_login = "210px";
    $petite_image = 'glyphicon glyphicon-pencil';
}

$input[3] = '<input type="submit" name="btn_envoyer" value="'.$mode.'" class="espace_login"/> <span class="<?php echo $petite_image; ?>"></span>';
$input[4] = ' <p><a id="inscription" href="index.php?mode='.$mode_lien.'" >'.$mode_lien.'</a></p>';

if((isset($_REQUEST["btn_envoyer"]) && $_REQUEST['mode'] == 'Login'))
{
    $pseudo = (isset($_REQUEST["tbx_uid"])?$_REQUEST["tbx_uid"]:"");
    $mdp = (isset($_REQUEST["tbx_pwd"])?$_REQUEST["tbx_pwd"]:"");
    
    $Login = Login($pseudo, $mdp, $bdd);
            
    if(!empty($Login))
    { 
        $user = recupere_users_par_id($Login[0][0], $bdd);

        $_SESSION["ID"] = $Login[0][0];
        $_SESSION["UID"] = $user[0][0];
        $_SESSION["ADMIN"] = $user[0][1];
        $_SESSION["CONN"] = true;
        
    }
    else
    {
        echo '<script type="text/javascript">alert("Nom d\'utilisateur ou mot de passe incorect");</script>';
        $input[0] = '<input type="text" name="tbx_uid" placeholder="Nom d\'utilisateur" class="espace_login" value="' . $pseudo.'"/>';
        $input[1] = '<input type="password" name="tbx_pwd" placeholder="Mot de passe" class="espace_login" value="' . $mdp.'"/>';
        $_SESSION["CONN"] = false;
    }
}

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    $mode = "connecté";
    $mode_lien = "Déconnexion";
    
    $input[0] = '<p>Bienvenue <span id="pseudo">' . $_SESSION["UID"] . "</span></p>";
        
    if( $_SESSION["ADMIN"])
    {
        $input[1] = '<p>Admin</p>';
        $liens[0] = '<li role="presentation"><a href="./pages/fontaines/gestionFontaines.php">Gestion fontaines</a></li>';
        $liens[1] = '<li role="presentation"><a href="./pages/utilisateurs/gestion_utilisateurs.php">Gestion Utilisateurs</a></li>';
    }
    else
        $input[1] = '<p>Utilisateur standard</p>'; 

    $input[2] = "<p></p>";
    $input[3] = "<p></p>";
    $input[4] = ' <p><a id="inscription" href="./pages/connexion/deconnexion.php" >'.$mode_lien.'</a></p>';
    
    $liens[2] = '<li role="presentation"><a href="./pages/fontaines/gestionUtilisateur.php">Gestion du compte</a></li>';
    
    $btn_ajout_fontaine = '<div id="btn_ajoutFontaine"><a class="modlinks" href="./pages/fontaines/ajoutFontaine.php">Ajouter une fontaine</a></div>';
}

if(isset($_REQUEST["btn_envoyer"]) && $_REQUEST['mode'] == 'Inscription')
{
    $pseudo = (isset($_REQUEST["tbx_uid"])?$_REQUEST["tbx_uid"]:"");
    $mdp = (isset($_REQUEST["tbx_pwd"])?$_REQUEST["tbx_pwd"]:"");
    $mdp_2 = (isset($_REQUEST["tbx_confirm"])?$_REQUEST["tbx_confirm"]:"");
    
    if($mdp === $mdp_2)
    {
        ajout_personne($pseudo, $mdp, $bdd);
        header("Location: index.php?mode=Login&tbx_uid=$pseudo&tbx_pwd=$mdp&btn_envoyer=Login");
    }
    else
    {
        echo '<script type="text/javascript">alert("Les deux mots de passes ne concordent pas");</script>';
        $input[0] = '<input type="text" name="tbx_uid" placeholder="Nom d\'utilisateur" class="espace_login" value="' . $pseudo.'"/>';
        $input[1] = '<input type="password" name="tbx_pwd" placeholder="Mot de passe" class="espace_login" value="' . $mdp.'"/>';
        $input[2] = '<input type="password" name="tbx_pwd" placeholder="Mot de passe" class="espace_login" value="' . $mdp_2.'"/>';
    }
}

if(isset($_REQUEST['error']))
{
    echo $_REQUEST['error'];
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
        <title>J'ai soif!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="./css/bootstrap/css/bootstrap.css"> 
        <link rel="stylesheet" href="./css/style.css"> 
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
                    <li role="presentation" class="active"><a href="./index.php">Accueil <span class="glyphicon glyphicon-home"></span></a></li>
                    <?php echo $liens[0]; echo $liens[1]; echo $liens[2]; ?>
                </ul>
            </nav>
            <section>
                
                <aside id="login" class="panel panel-info" >
                    <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> <?php echo $mode; ?></div>
                    <div class="panel-body" >
                        <form method="post" action="index.php?mode=<?php echo $mode; ?>">
                            <?php 
                                echo $input[0];
                                echo $input[1];
                                echo $input[2];
                                echo $input[3];
                                echo $input[4];
                            ?>
                        </form>   
                    </div>
                </aside>
                
                <div class="conteneur_btn">
                    <div id="btn_afficheFontaine"><a class="modlinks" href="./pages/fontaines/afficheFontaines.php">J'ai soif!</a></div>
                    <?php echo $btn_ajout_fontaine; ?>
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
