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
            supprimer_utilisateur($_REQUEST['id'], $bdd);
            header('Location: ./gestion_utilisateurs.php');
        }
        else
        {
            header('Location: ./gestion_utilisateurs.php?error=Aucun id spécifié');
        }
    } 
    else
    {
        header('Location: ../../index.php?error=Vous devez être Admin');
    }
}