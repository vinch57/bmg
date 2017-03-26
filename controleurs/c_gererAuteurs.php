<?php
/**
 * Contrôleur secondaire chargé de la gestion des auteurs
 * @author  dk
 * @package default (mission 4)
 */

// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/Bll/Auteurs.class.php');
require_once ('modele/App/Utilities.class.php');

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerAuteurs';
}

// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unAuteur = Auteurs::chargerAuteurParID($id);
}


// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerAuteurs' : {
        //récupérer les auteurs
        $lesAuteurs = Auteurs::chargerLesAuteurs(1);
        //afficher le nombre d'auteurs
        $nbAuteurs = count($lesAuteurs);
        include 'vues/v_listeAuteurs.php';
    } break;
    case 'consulterAuteur' : {
        if($unAuteur == NULL){
            Application::addNotification(new Notification("Cet auteur n'existe pas !", ERROR));
        } else {
            $list = isset($_GET["list"]);
            $lesOuvragesDeAuteur = Auteurs::chargerLesOuvragesParAuteur($id);
            $nbOuvragesDeAuteur = count($lesOuvragesDeAuteur);
            include 'vues/v_consulterAuteur.php';
        }
    } break;
    case 'ajouterAuteur' : {
        // initialisation des variables
        $hasErrors = false;
        $strNom = '';
        $strPrenom = '';
        $strAlias = '';
        $strNotes = '';
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirAuteur';
        }
        switch($option) {            
            case 'saisirAuteur' : {
                include 'vues/v_ajouterAuteur.php';
            } break;
            case 'validerAuteur' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {
                    // récupération des valeurs saisies
                    if (!empty($_POST["txtNom"])) {
                        $strNom = ucfirst(htmlentities($_POST["txtNom"]));
                        $strPrenom = ucfirst(htmlentities($_POST["txtPrenom"]));
                        $strAlias = ucfirst(htmlentities($_POST["txtAlias"]));
                        $strNotes = ucfirst(htmlentities($_POST["txtNotes"]));
                    } else {
                        if(empty($strNom)){
                            Application::addNotification(new Notification("Le nom doit être renseigné", ERROR));
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // ajout dans la base de données
                        $unAuteur = Auteurs::ajouterAuteur(array($strNom, $strPrenom, $strAlias, $strNotes));
                        Application::addNotification(new Notification("L'auteur a été ajouté !", SUCCESS));
                        include 'vues/v_consulterAuteur.php';
                    } else {
                        include 'vues/v_ajouterAuteur.php';
                    }
                }
            } break;
        }
    } break;                
    case 'modifierAuteur' : {
        // initialisation des variables
        $hasErrors = false;
        $strNom = '';
        $strPrenom = '';
        $strAlias = '';
        $strNotes = '';        
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        } else {
            $option = 'saisirAuteur';
        }
        switch($option) {            
            case 'saisirAuteur' : {
                // récupération du code
                if (isset($_GET["id"])) {
                    include("vues/v_modifierAuteur.php");
                } else {
                    Application::addNotification(new Notification("L'auteur est inconnu !", ERROR));
                    include ("vues/v_listeAuteurs.php");
                }
            } break;
            case 'validerAuteur' : {
                // si on a cliqué sur Valider
                if (isset($_POST["cmdValider"])) {
                    // mémoriser les données pour les réafficher
                    // test zones obligatoires
                    if (!empty($_POST["txtNom"])) {
                        $strNom = ucfirst(htmlentities($_POST["txtNom"]));
                    } else {
                        if(empty($strNom)){
                            Application::addNotification(new Notification("Le nom est obligatoire", ERROR));
                        }
                        $hasErrors = true;
                    }
                    $strPrenom = ucfirst(htmlentities($_POST["txtPrenom"]));
                    $strAlias = ucfirst(htmlentities($_POST["txtAlias"]));
                    $strNotes = ucfirst(htmlentities($_POST["txtNotes"]));
                    if (!$hasErrors) {
                        // mise à jour dans la base de données
                        $unAuteur->setNomAuteur($strNom);
                        $unAuteur->setPrenomAuteur($strPrenom);
                        $unAuteur->setAliasAuteur($strAlias);
                        $unAuteur->setNotesAuteur($strNotes);
                        $res = Auteurs::modifierAuteur($unAuteur);
                        Application::addNotification(new Notification("L'auteur a été modifié !", SUCCESS));
                        include 'vues/v_consulterAuteur.php';
                    } else {
                        include("vues/v_modifierAuteur.php");
                    }
                }
            }
        }
    } break;
    case 'supprimerAuteur' : {
        //rechercher ouvrages de cet auteur
        if(Auteurs::nbOuvragesParAuteur($unAuteur->getId()) > 0){
            //il y a des ouvrages référencés, suppression impossible
            Application::addNotification(new Notification("Il existe des ouvrages qui référencent cet auteur, suppression impossible !", ERROR));
            include 'vues/v_consulterAuteur.php';
        } else {
            //supprimer l'auteur
            Auteurs::supprimerAuteur($unAuteur->getId());
            Application::addNotification(new Notification("L'auteur a bien été supprimé !", SUCCESS));
            //Afficher la liste
            $lesAuteurs = Auteurs::chargerLesAuteurs(1);
            $nbAuteurs = count($lesAuteurs);
            include 'vues/v_listeAuteurs.php';
        }
    } break;
}

