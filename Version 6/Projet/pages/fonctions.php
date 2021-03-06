<?php
/** Fonction de debug 
 * -------------------
 * @param type $var 
 */
function var_dump_pre($var)
{
    echo '<pre>';
        var_dump($var);
    echo '</pre>';
}

/**
 * Fonction pour donner les extensions aux images importées
 * ---------------------------------------------------------
 * @param type $type type donnée par $_FILE
 * @return string un string contenant l'extension
 */
function get_image_format_file($type)
{
    $format = "";
    
    switch ($type)
    {
        case 'image/png':
            $format = '.png';
            break;
        case 'image/jpeg':
            $format = '.jpg';
            break;
        case 'image/gif':
            $format = '.gif';
            break;
        case 'image/bmp':
            $format = '.bmp';
            break;
        case 'image/vnd.microsoft.icon':
            $format = '.ico';
            break;
        case 'image/tiff':
            $format = '.tif';
            break;
        case 'image/svg+xml':
            $format = '.svg';
            break;
    }
     
    return $format;
}

function dir_exist($dir)
{
    $result = false;
    
    if(file_exists($dir) && is_dir($dir))
        $result = true;
    
    return $result;
}

function put_dirfile_array($path)
{
    $array = "";
    $i =0;
    
    if ($dossier = opendir($path)) 
    {
        while (false !== ($file = readdir($dossier))) 
        {
            if ($file != "." && $file != ".." && $file != ".DS_Store") 
            {
                $array[$i] = $file;
                $i++;
            }
        }
        
        closedir($dossier);
    }
    
    return $array;
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
    $sql = 'SELECT id_user FROM users WHERE (pseudo="'.$pseudo.'" AND mdp="'.$mdp.'" AND deleted=0 )';
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
    $sql = 'SELECT pseudo, admin FROM users WHERE deleted=0 AND id_user=' . $id;
    $requete = $bdd->query($sql);
    return $requete->fetchAll();
}

/**Fonction qui récupère les utilisateurs
 * ---------------------------------------
 * @param type $bdd : connection PDO
 * @return type type Tableaux multidimensionnel
 */
function recupere_utilisateur($bdd)
{
    $sql = 'SELECT id_user, pseudo, admin FROM users WHERE deleted=0';
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

/**
 * Fonction qui recupere toutes les fontaines de la base
 * ------------------------------------------------------
 * @param type $bdd : connection PDO
 * @return type Tableaux multidimensionnel
 */
function recupere_fontaines($bdd)
{
    $sql = "select id_fontaine,lat,lng,active, photo from fontaines";
    $request_fontaines = $bdd->query($sql);
    return $request_fontaines->fetchAll();
}

function recupere_photo_fontaine($id)
{
    $i = 0;
    $array = array();
    
    if(dir_exist('../../img/Fontaines/' . $id))
    {
        $dossier = opendir('../../img/Fontaines/' . $id); 
        
        while (false !== ($file = readdir($dossier))) 
        {
            if ($file != "." && $file != ".." && $file != ".DS_Store") 
            {
                $array[$i] = $file;
                $i++;
            }
        }
        
        closedir($dossier);
        return $array;
    }
    else
    {
        return null;
    }
    
    
}
/**
 * D'après un tableau ecrire des input type hidden pour pouvoir passer les valeurs entre javascript et php
 * --------------------------------------------------------------------------------------------------------
 * @param type $array 
 * @return string
 */
function instancier_tableau_javascript($array)
{
    $nb_items = 0;
    for($i=0;$i<count($array);$i++)
    {
        if($array[$i][3] == 1)
            $nb_items++;
    }
    $affichage = '<input type="hidden" id="nb_items" class="lat" value="' . $nb_items . '" />';
    
    for($i=0;$i<count($array);$i++)
    {
        if($array[$i][3] == 1)
        {
            $photo = recupere_photo_fontaine($array[$i][0]);
            
            $affichage .= '<input type="hidden" id="id_fontaine_' . $i . '" class="lat" value="' . $array[$i][0] . '" />';
            $affichage .= '<input type="hidden" id="lat_' . $i . '" class="lat" value="' . $array[$i][1] . '" />';  
            $affichage .= '<input type="hidden" id="lng_' . $i . '" class="lng" value="' . $array[$i][2] . '" />';
            $affichage .= '<input type="hidden" id="photo_fontaine_' . $i . '" class="lng" value="' . $array[$i][4] . '" />'; 
            $affichage .= '<input type="hidden" id="nom_photo_' . $i . '" class="lng" value="' . $photo[0] . '" />';
            
        }
    }
    
    return $affichage;
}

/****************************************** PAGE AJOUT FONTAINES ****************************************/
/** Fonction pour ajouter une fontaine 
 * -------------------------------------
 * @param type $lat : Longitude
 * @param type $lng : Longitude
 * @param type $id : id de l'utilisateur
 * @param type $bdd : connection PDO
 * @return type
 */
function ajout_fontaine($lat, $lng, $photos, $id, $bdd)
{
    $sql = "insert into fontaines(lat, lng, photo, active, id_user) values(:lat, :lng, :photos, 0, :id_user)";
    $request = $bdd->prepare($sql);
    $request->execute(array(
        "lat" => $lat,
        "lng" => $lng,
        "photos" => $photos,
        "id_user" => $id
    ));
    
    return $bdd->lastInsertId();
}
/****************************************** GESTION UTILISATEUR ****************************************/
/** Fonction pour modifier un utilisateur
 * ---------------------------------------
 * @param type $id : id utilisateur
 * @param type $newMdp : Nouveau mot de passe
 * @param type $rayon : Rayon
 * @param type $bdd : connection PDO
 */
function modifierUser($id, $newMdp,$rayon, $bdd){
  $sql = "UPDATE users SET mdp = '$newMdp', rayon = '$rayon' WHERE id_user = $id ";
  $request = $bdd->prepare($sql);
  $request->execute();
}

/** Fonction pour récupérer le mdp et le rayon d'un utilisateur
 * -------------------------------------------------------------
 * @param type $id : id de l'utilisateur
 * @param type $bdd : connection PDO
 * @return type : Tableaux multidimensionnel
 */
function recupere_infos_modif_utilisateur($id, $bdd){
  $sql = "SELECT mdp, rayon FROM users WHERE id_user = $id ";
  $request = $bdd->query($sql);
  return $request->fetchAll();
}
/****************************************** PAGE GESTION FONTAINES ****************************************/
/** Fonction pour afficher les fontaines
 * --------------------------------------
 * @param type $array
 * @param type $mode
 * @return string
 */
function affiche_fontaines($array, $mode)
{
    $affichage = "";
    $affichage = '<div class="liste_fontaines">';
    $affichage .= '<div id="en_tete"><div class="cellule">N° Fontaine</div><div class="cellule">LatLng</div><div class="cellule">Action</div></div>';

    for($i=0;$i<count($array);$i++)
    {
        if($array[$i][3] == $mode)
        {
                $class = "ligne_clair";

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

/** Fonction pour supprimer une fontaine
 * --------------------------------------
 * @param type $id : id de la fontaine
 * @param type $bdd : connection PDO
 */
function supprimer_fontaine($id, $bdd)
{
    $sql = 'delete from fontaines where id_fontaine = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('id' => $id));
}

/** Fonction pour valider une fontaine
 * ------------------------------------
 * @param type $id : id de la fontaine
 * @param type $bdd : connection PDO
 */
function valider_fontaine($id, $bdd)
{
    $sql = 'UPDATE fontaines SET active = 1 where id_fontaine = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('id' => $id));
}

/****************************************** PAGE GESTION UTILISATEURS ****************************************/
/** Fonction pour afficher les utilisateurs
 * ------------------------------------------
 * @param type $array
 * @return string
 */
function affiche_utilisateur($array)
{
    $affichage = "";
    $affichage = '<div class="liste_utilisateurs">';
    $affichage .= '<div id="en_tete"><div class="cellule">N° Utilisateur</div><div class="cellule">Nom / Admin</div><div class="cellule">Action</div></div>';

    for($i=0;$i<count($array);$i++)
    {
                $class = "ligne_clair";

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

/** Fonction pour supprimer un utilisateur
 * ---------------------------------------
 * @param type $id : id de l'utilisateur
 * @param type $bdd : connection PDO
 */
function supprimer_utilisateur($id, $bdd)
{
    $sql = 'UPDATE users SET deleted = 1 WHERE id_user = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('id' => $id));
}

/** Fonction pour changer l'etat d'un utilisateur
 * -----------------------------------------------
 * @param type $id
 * @param type $admin
 * @param type $bdd : connection PDO
 */
function valider_admin_utilisateur($id, $admin, $bdd)
{
    $sql = 'UPDATE users SET admin = :admin where id_user = :id';
    $request = $bdd->prepare($sql);
    $request->execute(array('admin' => $admin, 'id' => $id));
}
?>
