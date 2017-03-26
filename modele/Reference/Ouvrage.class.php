<?php
/** 
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * References
 * Classes métier
 *
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Ouvrage : représente un ouvrage
 *  ====================================================================
*/

//sollicite les services de la Data Access Layer
require_once('./modele/Dal/OuvrageDal.class.php');
//besoin de connaître la classe Auteur
require_once('./modele/Reference/Auteur.class.php');

class Ouvrage {
    private $_no_ouvrage;
    private $_titre;
    private $_salle;
    private $_rayon;
    private $_genre; //objet de la classe Genre
    private $_date_acquisition;
    
    /**
     * Constructeur
     */
    
    public function __construct(
            $p_no_ouvrage,
            $p_titre,
            $p_salle,
            $p_rayon,
            $p_genre,
            $p_date_acquisition
    ) {
        $this->setNoOuvrage($p_no_ouvrage);
        $this->setTitreOuvrage($p_titre);
        $this->setSalleOuvrage($p_salle);
        $this->setRayonOuvrage($p_rayon);
        $this->setGenreOuvrage($p_genre);
        $this->setDateAcquisitionOuvrage($p_date_acquisition);
    }
    
    /**
     * Accesseurs
     */
    
    public function getNoOuvrage() {
        return $this->_no_ouvrage;
    }
    
    public function getTitreOuvrage() {
        return $this->_titre;
    }
    
    public function getSalleOuvrage() {
        return $this->_salle;
    }
    
    public function getRayonOuvrage() {
        return $this->_rayon;
    }
    
    public function getGenreOuvrage() {
        return $this->_genre;
    }
    
    public function getDateAcquisitionOuvrage() {
        return $this->_date_acquisition;
    }
    
    /**
     * Mutateurs
     */
    
    public function setNoOuvrage($p_no_ouvrage){
        $this->_no_ouvrage = $p_no_ouvrage;
    }
    
    public function setTitreOuvrage($p_titre){
        $this->_titre = $p_titre;
    }
    
    public function setSalleOuvrage($p_salle){
        $this->_salle = $p_salle;
    }
    
    public function setRayonOuvrage($p_rayon){
        $this->_rayon = $p_rayon;
    }
    
    public function setGenreOuvrage(Genre $p_genre){
        $this->_genre = $p_genre;
    }
    
    public function setDateAcquisitionOuvrage($p_date_acquisition){
        $this->_date_acquisition = $p_date_acquisition;
    }
    
    public function getAuteurs () {
        $tab = OuvrageDal::loadAuteursOuvrage($this->getNoOuvrage());
        $res = array();
        foreach($tab as $ligne) {
            $unAuteur = new Auteur ($ligne->id_auteur, $ligne->nom_auteur, $ligne->prenom_auteur, $ligne->alias, $ligne->notes);
            array_push($res, $unAuteur);
        }
        return $res;
    }
    
    public function getDateDernierPret () {
        return OuvrageDal::loadDateDernierPretOuvrage($this->getNoOuvrage());
    }
    
    public function getDisponibilite () {
        return OuvrageDal::loadDisponibiliteOuvrage($this->getNoOuvrage());
    }
    
    public function getCouverture($no_ouvrage, $titre) {
        return couvertureOuvrage($no_ouvrage, $titre);
    }
    
}