<?php
session_start();

include "../fonctions.php";

$bdd = connexion('M152_Fontaines', 'localhost', 'root', '');

if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    if( $_SESSION["ADMIN"])
    {
        if(isset($_REQUEST['id']))
        {
            valider_fontaine($_REQUEST['id'], $bdd);
            header('Location: ./gestionFontaines.php');
        }
        else
        {
            header('Location: ./gestionFontaines.php?error=Aucun id spécifié');
        }
    } 
    else
    {
        header('Location: ../../index.php?error=Vous devez être Admin');
    }
}