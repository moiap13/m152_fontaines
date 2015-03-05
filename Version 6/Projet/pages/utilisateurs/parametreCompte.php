<?php
session_start();
include './../fonctions.php';
$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');

$liens[0] = "";
$liens[1] = "";
$liens[2] = "";

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{   
    $id = $_SESSION["ID"];
    $utilisateur = recupere_infos_modif_utilisateur($id,$bdd);
        
    
    
    
    if( $_SESSION["ADMIN"])
    {
        $isAdmin = 'Admin';
        $liens[0] = '<li role="presentation"><a href="../fontaines/gestionFontaines.php">Gestion fontaines</a></li>';
        $liens[1] = '<li role="presentation"><a href="./gestion_utilisateurs.php">Gestion Utilisateurs</a></li>';
    }
    else
        $isAdmin = 'Utilisateur standard';
    
    if(isset($_REQUEST['btn_modifier'])){
    
        if(isset($_REQUEST['mdp']) && $_REQUEST['mdp']==$_REQUEST['confmdp']){
            $newMdp = $_REQUEST['mdp'];
            $rayon = $_REQUEST['rayon'];
            modifierUser($id, $newMdp, $rayon, $bdd);
        }      
    }
    
    $liens[2] = '<li role="presentation"><a href="./parametreCompte.php">Parametres du compte</a></li>';
}
else
{
    $admin = false;
    header('Location: ../../index.php?error=Vous devez être Connecté');
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
                <h3>Profil de <?php echo $_SESSION["UID"]." (".$isAdmin.")" ?></h3>
                <div id="conteneur_utilisateur">
                <form method="get" action="#">
                    <label for="mdp" >Modification du mot de passe</label><br>
                    <input type="password" value="<?php echo $utilisateur[0][0]?>" name="mdp" /><br>
                    <label for="confmdp" >Confirmation du nouveau mot de passe</label><br>
                    <input type="password" value="<?php echo $utilisateur[0][0] ?>" name="confmdp" /><br>
                    <label for="rayon" >Modifier le rayon de recherche (en mètres)</label><br>
                    <input type="number" value="<?php echo $utilisateur[0][1]; ?>" min="200" name="rayon" /><br>
                    <input type="submit" value="Modifier" name="btn_modifier" style="margin-top: 10px;" />
                    <input type="reset" value="Annuler" onclick="location.href='../../index.php' " name="btn_annuler" />
                </form>
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
