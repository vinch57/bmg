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
 * @author 	dk
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class AuteurDal{
    
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadAuteurs($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM auteur';
        $res = $cnx->getRows($qry, array(), $style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }
    
    /**
     * charge un objet de la classe Auteur à partir de son code
     * @param  $id : le code du auteur
     * @return  un objet de la classe Auteur
    */   
    public static function loadAuteurByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM auteur WHERE id_auteur = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    } 
    
    /**
     * ajoute un auteur
     * @param   string  $nom_auteur : le nom de l'auteur à ajouter
     * @param   string  $prenom_auteur : le prénom de l'auteur à ajouter
     * @param   string  $alias : l'alias de l'auteur à ajouter
     * @param   string $notes : les notes à propos de l'auteur à ajouter
     * @return  object un objet de la classe Auteur
    */      
    public static function addAuteur(
            $nom_auteur,
            $prenom_auteur,
            $alias,
            $notes
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO auteur (nom_auteur, prenom_auteur, alias, notes) VALUES (?,?,?,?)';
        $res = $cnx->execSQL($qry, array(
                $nom_auteur,
                $prenom_auteur,
                $alias,
                $notes
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        } else {
            $cnx = new PdoDao();
            $qry = 'SELECT MAX(id_auteur) FROM auteur';
            $res = $cnx->getValue($qry, array());
            return $res;
        }
    }
    
    /**
     * modifie un auteur
     * @param   string  $nom_auteur
     * @param   string  $prenom_auteur
     * @param   string  $alias
     * @param   string  $notes
     * @return  un code erreur
    */      
    public static function setAuteur(
            $id_auteur,
            $nom_auteur,
            $prenom_auteur,
            $alias,
            $notes
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE auteur SET nom_auteur = ?, prenom_auteur = ?, alias = ?, notes = ? WHERE id_auteur = ?';
        $res = $cnx->execSQL($qry,array(
                $nom_auteur,
                $prenom_auteur,
                $alias,
                $notes,
                $id_auteur
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * supprime un auteur
     * @param   int $id_auteur : l'identifiant de l'auteur à supprimer
     */      
    public static function delAuteur($id_auteur) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM auteur WHERE id_auteur = ?';
        $res = $cnx->execSQL($qry,array($id_auteur));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * calcule le nombre d'ouvrages pour un auteur
     * @param   int $id_auteur : l'identifiant de l'auteur
    */      
    public static function countOuvragesAuteur($id_auteur) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM auteur_ouvrage WHERE id_auteur = ?';
        $res = $cnx->getValue($qry,array($id_auteur));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * retourne les ouvrages d'un auteur
     * @param type $id_auteur
     * @return tableau d'ouvrages
     */
    public static function loadOuvragesByAuteur($id_auteur) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM v_ouvrages INNER JOIN auteur_ouvrage ON auteur_ouvrage.no_ouvrage = v_ouvrages.no_ouvrage WHERE auteur_ouvrage.id_auteur = ?';
        $res = $cnx->getRows($qry,array($id_auteur), 1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}

