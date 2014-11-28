<?php
function var_dump_pre($var)
{
    echo '<pre>';
        var_dump($var);
    echo '</pre>';
}
 /************************************ FONCTIONS EN LIEN AVEC LA BASE DE DONNEÉ ***************************************/
 
 /**
 * Fonction de connexion a la base de donnée a l'aide de parametre
 * -------------------------------------------------------------------
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
 * 
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
/**Fonction qui recupere une personne en spécifiant un ID
 * 
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

/**Fonction qui insert une personne dans la table
 * 
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
?>