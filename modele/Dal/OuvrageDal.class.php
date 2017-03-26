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

class OuvrageDal{
    
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadOuvrages($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM v_ouvrages';
        $res = $cnx->getRows($qry, array(), $style);
        if(is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
     /**
     * charge un objet de la classe Ouvrage à partir de son code
     * @param  $id : le code de l'ouvrage
     * @return  un objet de la classe Ouvrage
    */   
    public static function loadOuvrageByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM v_ouvrages WHERE no_ouvrage = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    
    /**
     * ajoute un ouvrage
     * @param   string  $titre : le titre de l'ouvrage à ajouter
     * @param   string  $salle : la salle de l'ouvrage à ajouter
     * @param   string  $rayon : le rayon de l'ouvrage à ajouter
     * @param   string  $genre : le genre de l'ouvrage à ajouter
     * @param   date    $date_acquisition : la date d'acquisition de l'ouvrage
     * @return  object un objet de la classe Ouvrage
    */      
    public static function addOuvrage(
            $titre,
            $salle,
            $rayon,
            $genre,
            $date_acquisition
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO ouvrage (titre, salle, rayon, code_genre, date_acquisition) VALUES (?,?,?,?,?)';
        $res = $cnx->execSQL($qry, array(
                $titre,
                $salle,
                $rayon,
                $genre,
                $date_acquisition
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        } else {
            $cnx = new PdoDao();
            $qry = 'SELECT MAX(no_ouvrage) FROM ouvrage';
            $res = $cnx->getValue($qry, array());
            return $res;
        }
    }
    
    
    /**
     * modifie un ouvrage
     * @param   string  $titre
     * @param   string  $salle
     * @param   string  $rayon
     * @param   string  $genre
     * @param   date    $date_acquisition
     * @return  un code erreur
    */      
    public static function setOuvrage(
            $no_ouvrage,
            $titre,
            $salle,
            $rayon,
            $genre,
            $date_acquisition
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE ouvrage SET titre = ?, salle = ?, rayon = ?, code_genre = ?, date_acquisition = ? WHERE no_ouvrage = ?';
        $res = $cnx->execSQL($qry,array(
                $titre,
                $salle,
                $rayon,
                $genre,
                $date_acquisition,
                $no_ouvrage
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * supprime un ouvrage
     * @param   int $no_ouvrage : le numéro de l'ouvrage à supprimer
     */      
    public static function delOuvrage($no_ouvrage) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM ouvrage WHERE no_ouvrage = ?';
        $res = $cnx->execSQL($qry,array($no_ouvrage));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    public static function countPretsOuvrages($no_ouvrage) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM v_prets_en_cours WHERE no_ouvrage = ?';
        $res = $cnx->getValue($qry, array($no_ouvrage));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    //à supprimer : obsolète -> on peut avoir plusieurs auteurs pour un ouvrage
    public static function getAuteurPourOuvrage($no_ouvrage) {
        $cnx = new PdoDao();
        $qry = 'SELECT nom_auteur, prenom_auteur FROM auteur INNER JOIN auteur_ouvrage ON auteur.id_auteur = auteur_ouvrage.id_auteur WHERE no_ouvrage = ?';
        $res = $cnx->getValue($qry, array($no_ouvrage));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    public static function loadAuteursOuvrage($no_ouvrage) {
        $cnx = new PdoDao();
        $qry = 'SELECT auteur.id_auteur, nom_auteur, prenom_auteur, alias, notes FROM auteur INNER JOIN auteur_ouvrage ON auteur_ouvrage.id_auteur = auteur.id_auteur WHERE no_ouvrage = ?';
        $res = $cnx->getRows($qry, array($no_ouvrage), 1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    public static function loadDateDernierPretOuvrage($no_ouvrage) {
        $cnx = new PdoDao();
        $qry = 'SELECT dernier_pret FROM v_ouvrages WHERE no_ouvrage = ?';
        $res = $cnx->getValue($qry, array($no_ouvrage));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    public static function loadDisponibiliteOuvrage($no_ouvrage) {
        $cnx = new PdoDao();
        $qry = 'SELECT disponibilite FROM v_ouvrages WHERE no_ouvrage = ?';
        $res = $cnx->getValue($qry, array($no_ouvrage));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * retourne un tableau de prêts d'un ouvrage
     * @param type $no_ouvrage
     * @return tableau de prêts
     */
    public static function loadLoanByOuvrage($no_ouvrage){
        $cnx = new PdoDao();
        $qry = 'SELECT id_pret, f_nom_prenom_client(no_client) as nom_prenom_client,  date(date_emp) as date_emp, date(date_ret) as date_ret, penalite from v_prets where no_ouvrage = ?';
        $res = $cnx->getRows($qry, array($no_ouvrage), 1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}