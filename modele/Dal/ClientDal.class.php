<?php
/** 
 * BMG
 * © GroSoft, 2015
 * 
 * Data Access Layer
 * Classe d'accès aux données 
 *
 * Utilise les services de la classe PdoDao
 *
 * @package 	default
 * @author 		collectif
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class ClientDal { 
       
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @param   int    $etat : 0 == uniquement les clients bannis, 1 = uniquement les clients interdits de prêt, 2 = uniquement les clients normaux
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadClients($style, $etat) {
        $cnx = new PdoDao();
        $arrayParams = array();
        switch ($etat) {
            case '0' : {
                $qry = 'SELECT * FROM client WHERE etat_client = ?';
                array_push($arrayParams, "B");
            } break;
            case '1' : {
                $qry = 'select * from v_interdits';
                
            } break;
            case '2' : {
                $qry = 'SELECT * FROM client WHERE etat_client = ?';
                array_push($arrayParams, "N");
            } break;
            default : {
                $qry = 'SELECT * FROM client';
            }
        }
        $res = $cnx->getRows($qry,$arrayParams,$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }    
        return $res;
    }

    /**
     * charge un objet de la classe Auteur à partir de son id
     * @param  int	$id : l'identifiant de l'auteur
     * @return  un objet de la classe Auteur
    */   
    public static function loadClientById($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM client WHERE no_client = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    
    /**
     * ajoute un client
     * @param   string  $nom : le nom du client
     * @param   string  $prenom : le prénom du client à ajouter
     * @param   string rue : la rue du client à ajouter
     * @param   string code postal : le code postal du client à ajouter
     * @param   string ville : la ville du client à ajouter
     * @param   motdepasse : le mot de passe du client à ajouter
     * @param   string  caution : le montant de la caution du client à ajouter
     * @return  object un objet de la classe Auteur
    */      
    public static function addClient(
            $nom,
            $prenom,
            $rue,
            $codepostal,
            $ville,
            $dateInscription,
            $login,
            $mdp,
            $mail,
            $caution
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO client(nom_client, prenom, rue_client, code_post, ville, date_inscr, login, password, mel, caution) VALUES (?,?,?,?,?,?,?,?,?,?)';
        $res = $cnx->execSQL($qry,array(
            $nom,
            $prenom,
            $rue,
            $codepostal,
            $ville,
            $dateInscription,
            $login,
            $mdp,
            $mail,
            $caution
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        } else {
            $cnx = new PdoDao();
            $qry = 'SELECT MAX(no_client) FROM client';
            $res = $cnx->getValue($qry, array());
            return $res;
        }
    }
    
    /**
     * modifie un client
     * @param   int     $id
     * @param   string  $nom
	 * @param   string  $prenom
	 * @param   string  $alias
	 * @param   string  $notes
     * @return  un code erreur
    */      
    public static function setClient(
            $no_client,
            $nom,
            $prenom,
            $rue,
            $codepostal,
            $ville,
            $mel,
            $caution
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE client SET nom_client = ?, prenom = ?, rue_client = ?, code_post = ?, ville = ?, mel = ?, caution = ? WHERE no_client = ?';
        $res = $cnx->execSQL($qry,array(
                $nom,
                $prenom,
                $rue,
                $codepostal,
                $ville,
                $mel,
                $caution,
                $no_client
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    
    /**
     * Retourne un nouveau login
     * @param type $nom
     * @param type $prenom
     * @return string
     */
    public static function getNewLogin($nom, $prenom) {
        $login = null;
        foreach (explode('-', $prenom) as $value) {
            $login .= $value[0];
        }
        $login .= '.' . $nom;
        
        //dans le cas où plusieurs personnes portent le même nom et prénom
        //on ajoute un rang au login
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM client WHERE login LIKE ?';
        $res = $cnx->getValue($qry, array($login.'%'));
        if($res != 0){
            $login = $login . (int)$res; 
        }
        return strtolower($login);
    }
    
    public static function resetPassword($id, $password) {
        $cnx = new PdoDao();
        $qry = 'UPDATE client SET password = ? WHERE no_client = ?';
        $res = $cnx->execSQL($qry, array(
            $password,
            $id
        ));
        
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * Retourne le dernier prêt
     * @param type $id
     * @return type
     */
    public static function getLastLoan($id) {
        $cnx = new PdoDao();
        $qry = "SELECT date_dernier_pret from v_clients WHERE no_client = ?";
        $res = $cnx->getValue($qry, array($id));
        return $res;
    }
}


