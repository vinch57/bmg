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
 *  Classe Auteur : représente un auteur
 *  ====================================================================
*/

class Auteur {
    private $_id_auteur;
    private $_nom_auteur;
    private $_prenom_auteur;
    private $_alias;
    private $_notes;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_id_auteur,
            $p_nom_auteur,
            $p_prenom_auteur,
            $p_alias,
            $p_notes
    ) {
        $this->setIdAuteur($p_id_auteur);
        $this->setNomAuteur($p_nom_auteur);
        $this->setPrenomAuteur($p_prenom_auteur);
        $this->setAliasAuteur($p_alias);
        $this->setNotesAuteur($p_notes);
    }  
    
    /**
     * Accesseurs
    */

    public function getId () {
        return $this->_id_auteur;
    }

    public function getNomAuteur () {
        return $this->_nom_auteur;
    }
    
    public function getPrenomAuteur () {
        return $this->_prenom_auteur;
    }
    
    public function getAliasAuteur () {
        return $this->_alias;
    }
    
    public function getNotesAuteur () {
        return $this->_notes;
    }
    
    /**
     * Mutateurs
    */
    
    public function setIdAuteur ($p_id_auteur) {
        $this->_id_auteur = $p_id_auteur;
    }

    public function setNomAuteur ($p_nom_auteur) {
        $this->_nom_auteur = $p_nom_auteur;
    }
    
    public function setPrenomAuteur ($p_prenom_auteur) {
        $this->_prenom_auteur = $p_prenom_auteur;
    }
    
    public function setAliasAuteur ($p_alias) {
        $this->_alias = $p_alias;
    }
    
    public function setNotesAuteur ($p_notes) {
        $this->_notes = $p_notes;
    }
}
