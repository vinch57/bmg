<?php

/**
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe OuvrageDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Ouvrages : fabrique d'objets Ouvrage
 *  ====================================================================
 */

// sollicite les méthodes de la classe OuvrageDal
require_once ('./modele/Dal/OuvrageDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Ouvrage.class.php');
//sollicite la classe Genre pour créer les objets genre
require_once ('./modele/Reference/Genre.class.php');

class Ouvrages{
    
    /**
     * Méthodes publiques
     */
    
    /**
     * récupère les ouvrages
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     * @return  un tableau de type $mode 
     */ 
    
    public static function chargerLesOuvrages($mode) {
        $tab = OuvrageDal::loadOuvrages(1);
        if(Application::dataOK($tab)) {
            if($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unOuvrage = new Ouvrage(
                            $ligne->no_ouvrage,
                            $ligne->titre,
                            $ligne->salle,
                            $ligne->rayon,
                            new Genre($ligne->code_genre, $ligne->lib_genre),
                            $ligne->acquisition   
                    );
                    array_push($res, $unOuvrage);
                }
                return $res;
            }
            else {
                return $tab;
            }
        }
        return NULL;
    }
    
    /**
     * vérifie si un ouvrage existe
     * @param   $no_ouvrage : le numéro de l'ouvrage à contrôler
     * @return  un booléen
     */    
    public static function ouvrageExiste($no_ouvrage) {
        $values = OuvrageDal::loadOuvrageByID($code, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }
    
    public static function ajouterOuvrage($valeurs) {
        $id = OuvrageDal::addOuvrage(
            $valeurs[0],
            $valeurs[1],
            $valeurs[2],
            $valeurs[3],
            $valeurs[4]
        );
        return self::chargerOuvrageParId($id);
    }
    
    public static function modifierOuvrage($ouvrage) {
        return OuvrageDal::setOuvrage(
            $ouvrage->getNoOuvrage(), 
            $ouvrage->getTitreOuvrage(),
            $ouvrage->getSalleOuvrage(),
            $ouvrage->getRayonOuvrage(),
            $ouvrage->getGenreOuvrage()->getCode(),
            $ouvrage->getDateAcquisitionOuvrage()
        );
    }
    
    public static function supprimerOuvrage($no_ouvrage) {
        return OuvrageDal::delOuvrage($no_ouvrage);
    }
    
    /**
     * récupère les caractéristiques d'un ouvrage
     * @param   $no_ouvrage : le numéro de l'ouvrage
     * @return  un objet de la classe Ouvrage
     */
    public static function chargerOuvrageParId($id) {
        $values = OuvrageDal::loadOuvrageByID($id, 1);
        if (Application::dataOK($values)) {
            $titre = $values[0]->titre;
            $salle = $values[0]->salle;
            $rayon = $values[0]->rayon;
            $genre = new Genre($values[0]->code_genre, $values[0]->lib_genre);
            $date_acquisition = $values[0]->acquisition;
            return new Ouvrage ($id, $titre, $salle, $rayon, $genre, $date_acquisition);
        }
        return NULL;
    }
    
    /**
     * récupère le nombre de prêts en cours pour un ouvrage
     * @param int $code : le numéro d'ouvrage
     * @return int
     */
    public static function nbPretsEnCoursParOuvrage($code) {
        return OuvrageDal::countPretsOuvrages($code);
    }
    
    /**
     * retourne les prêts d'un ouvrage
     * @param type $no_ouvrage
     * @return tableau de prêts
     */
    public static function chargerLesPretsParOuvrage($no_ouvrage){
        return OuvrageDal::loadLoanByOuvrage($no_ouvrage);
    }
    
}