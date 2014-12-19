<?php
function var_dump_pre($var)
{
    echo '<pre>';
        var_dump($var);
    echo '</pre>';
}
 /************************************ FONCTIONS EN LIEN AVEC LA BASE DE DONNEÉ ***************************************/
 
/*************************************************** PAGE INDEX ********************************************************/
 /**
 * Fonction de connexion a la base de donnée a l'aide de parametre
 * ----------------------------------------------------------------
 * @param type $db_name : the name of the database where you want to connect
 * @param type $host : the adress from the host
 * @param type $user : the user who want to connect to the database
 * @param type $pwd : the password
 * @return type : return an connection PDO
 */
function connexion($db_name, $host, $user, $pwd)
{
    try {
        $bdd = new PDO('mysql:dbname=' . $db_name . ';host=' . $host, $user, $pwd);
        $bdd ->exec("SET CHARACTER SET utf8");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        $bdd = $e->getMessage();
    }
    
    return $bdd;
}

/**Fonction de Login a l'aide du pseudo mdp et email (pas obligatoire)
 * -------------------------------------------------------------------
 * @param type $bdd : l'objet PDO qui établie un lien avec la base de donnée
 * @param type $pseudo : Le pseudo de l'utilisateur
 * @param type $mdp : Le mot de passe de l'utilisateur
 */
function Login($pseudo, $mdp, $bdd)
{
    $sql = 'SELECT id_user FROM users WHERE (pseudo="'.$pseudo.'" AND mdp="'.$mdp.'") OR (email="'.$pseudo.'" AND mdp="'.$mdp.'")';
    $requete = $bdd->query($sql);
    return $requete->fetchAll();
}
/** Fonction qui recupere une personne en spécifiant un ID
 * ------------------------------------------------------
 * @param type $id
 * @param type $bdd
 * @return type
 */
function recupere_users_par_id($id, $bdd)
{
    $sql = 'SELECT pseudo, admin FROM users WHERE id_user=' . $id;
    $requete = $bdd->query($sql);
    return $requete->fetchAll();
}

function recupere_utilisateur($bdd)
{
    $sql = 'SELECT id_user, pseudo, admin FROM users';
    $requete = $bdd->query($sql);
    return $requete->fetchAll();
}

/**Fonction qui insert une personne dans la table
 * ----------------------------------------------- 
 * @param type $pseudo
 * @param type $mdp
 * @param type $bdd
 * @return type
 */
function ajout_personne($pseudo, $mdp, $bdd)
{
    $ajout = $bdd->prepare('insert into users(pseudo,mdp) values("' . $pseudo . '","' . $mdp . '")');
    $ajout->execute();
    return $bdd->lastInsertId();
}

/****************************************** PAGE AFFICHER FONTAINES ****************************************/

function recupere_fontaines($bdd)
{
    $sql = "select id_fontaine,lat,lng,active from fontaines";
    $request_fontaines = $bdd->query($sql);
    return $request_fontaines->fetchAll();
}

function instancier_tableau_javascript($array)
{
    $affichage = '<input type="hidden" id="nb_items" class="lat" value="' . count($array) . '" />';
    
    for($i=0;$i<count($array);$i++)
    {
        $affichage .= '<input type="hidden" id="lat_' . $i . '" class="lat" value="' . $array[$i][1] . '" />';  
        $affichage .= '<input type="hidden" id="lng_' . $i . '" class="lng" value="' . $array[$i][2] . '" />';  
    }
    
    return $affichage;
}

/****************************************** PAGE AJOUT FONTAINES ****************************************/
function ajout_fontaine($lat, $lng, $id, $bdd)
{
    $sql = "insert into fontaines(lat, lng, active, id_user) values(:lat, :lng, 0, :id_user)";
    $request = $bdd->prepare($sql);
    $request->execute(array(
        "lat" => $lat,
        "lng" => $lng,
        "id_user" => $id
    ));
    
    return $bdd->lastInsertId();
}
/****************************************** GESTION UTILISATEUR ****************************************/
function modifierUser($id, $newMdp, $bdd){
  $sql = "UPDATE users SET mdp = '$newMdp' WHERE id_user = $id ";
  $request = $bdd->prepare($sql);
    $request->execute();
}
/****************************************** PAGE GESTION FONTAINES ****************************************/
function affiche_fontaines($array, $mode)
{
    $affichage = "";
    $affichage = '<div class="liste_fontaines">';
    $affichage .= '<div id="en_tete"><div class="cellule">N° Fontaine</div><div class="cellule">LatLng</div><div class="cellule">Action</div></div>';

    for($i=0;$i<count($array);$i++)
    {
        if($array[$i][3] == $mode)
        {
            /*if($i%2 == 0)
            {
                $class = "ligne_fonce";
            }
            else
            {*/
                $class = "ligne_clair";
            //}

            $affichage .= '<div class="'. $class .'">';
            $affichage .= '<div class="cellule">'.$array[$i][0].'</div>';
            $affichage .= '<div class="cellule"><a href="afficheFontaines.php?mode=validation&latlng='.$array[$i][1].','.$array[$i][2].'" />'.$array[$i][1].','.$array[$i][2].'</a></div>';
            $affichage .= '<div class="cellule">';
            
            if($mode == 0)
                $affichage .= '<a href="valider_fontaine.php?id='.$array[$i][0].'">✔</a><a href="supprimer_fontaine.php?id='.$array[$i][0].'">x</a>';
            else
                $affichage .= '<a href="supprimer_fontaine.php?id='.$array[$i][0].'">x</a>';
            
            $affichage .= '</div>';
            $affichage .= '</div>';
        }
    }

   $affichage .= "</div>";
    
    return $affichage;
}

function supprimer_fontaine($id, $bdd)
{
    $sql = 'delete from fontaines where id_fontaine = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('id' => $id));
}

function valider_fontaine($id, $bdd)
{
    $sql = 'UPDATE fontaines SET active = 1 where id_fontaine = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('id' => $id));
}

/****************************************** PAGE GESTION UTILISATEURS ****************************************/
function affiche_utilisateur($array)
{
    $affichage = "";
    $affichage = '<div class="liste_utilisateurs">';
    $affichage .= '<div id="en_tete"><div class="cellule">N° Utilisateur</div><div class="cellule">Nom / Admin</div><div class="cellule">Action</div></div>';

    for($i=0;$i<count($array);$i++)
    {
            /*if($i%2 == 0)
            {
                $class = "ligne_fonce";
            }
            else
            {*/
                $class = "ligne_clair";
            //}

            $affichage .= '<div class="'. $class .'">';
            $affichage .= '<div class="cellule">'.$array[$i][0].'</div>';
            
            if($array[$i][2])
            {
                $est_admin = 'ADMIN';
                $action = '<a href="changer_admin.php?id='.$array[$i][0].'&mode=0">✍</a><a href="supprimer_utilisateur.php?id='.$array[$i][0].'">x</a>';
            }
            else
            {
               $est_admin = 'PAS ADMIN'; 
               $action = '<a href="changer_admin.php?id='.$array[$i][0].'&mode=1">✍</a><a href="supprimer_utilisateur.php?id='.$array[$i][0].'">x</a>';
            }
            
            
            $affichage .= '<div class="cellule">'.$array[$i][1].' / '.$est_admin.'</div>';
            $affichage .= '<div class="cellule">';
            $affichage .= $action;
            $affichage .= '</div>';
            $affichage .= '</div>';
    }

   $affichage .= "</div>";
    
    return $affichage;
}

function supprimer_utilisateur($id, $bdd)
{
    $sql = 'delete from users where id_user = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('id' => $id));
}

function valider_admin_utilisateur($id, $admin, $bdd)
{
    $sql = 'UPDATE users SET admin = :admin where id_user = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('admin' => $admin, 'id' => $id));
}
?>
