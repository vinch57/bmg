<?php
/**
 * Contrôleur secondaire chargé de la gestion des ouvrages
 * @author  dk
 * @package default (mission 4)
 */

// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/App/Utilities.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/Bll/Ouvrages.class.php');
require_once ('include/_metier.lib.php');
require_once ('modele/Bll/Genres.class.php'); //sollicite la Business Logic Layer de genres

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerOuvrages';
}

// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unOuvrage = Ouvrages::chargerOuvrageParID($id);
}

//récupération des genres pour l'ajout et et la modification
$tabGenres = Genres::chargerLesGenres(1);

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerOuvrages' : {
        //récupérer les ouvrages
        $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
        //afficher le nombre d'ouvrages
        $nbOuvrages = count($lesOuvrages);
        include 'vues/v_listeOuvrages.php';
    } break;
    case 'consulterOuvrage' : {
        if ($unOuvrage == NULL) {
            Application::addNotification(new Notification("Cet ouvrage n'existe pas !", ERROR));
        } else {
            $list = isset($_GET["list"]);
            $lesPretsDeOuvrage = Ouvrages::chargerLesPretsParOuvrage($id);
            $nbPretsDeOuvrage = count($lesPretsDeOuvrage);
            include 'vues/v_consulterOuvrage.php';
        }
    } break;
    case 'ajouterOuvrage' : {
        // initialisation des variables
        $hasErrors = false;
        $strTitre = '';
        $intSalle = 1;
        $strRayon = '';
        $strCodeGenre = '';
        $strDateAcquisition = '';
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirOuvrage';
        }
        switch($option) {            
            case 'saisirOuvrage' : {
                include 'vues/v_ajouterOuvrage.php';
            } break;
            case 'validerOuvrage' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {
                    // récupération des valeurs saisies
                    if (!empty($_POST["txtTitre"]) and !empty($_POST["txtRayon"]) and !empty($_POST["txtDate"])) {
                        $strTitre = ucfirst($_POST["txtTitre"]);
                        $intSalle = $_POST["rbnSalle"];
                        $strRayon = ucfirst($_POST["txtRayon"]);
                        $strGenre = $_POST["cbxGenres"];
                        $strDate = $_POST["txtDate"];
                    } else {
                        if(empty($strTitre)) {
                            Application::addNotification(new Notification("Le titre doit être renseigné", ERROR));
                        }
                        if(empty($strRayon)) {
                            Application::addNotification(new Notification("Le rayon doit être renseigné", ERROR));
                        }
                        if(empty($strDate)) {
                            Application::addNotification(new Notification("La date doit être renseignée", ERROR));
                        }
                        $hasErrors = true;
                    }
                    if(!$hasErrors) {
                        // ajout dans la base de données
                        $unOuvrage = Ouvrages::ajouterOuvrage(array($strTitre, $intSalle, $strRayon, $strGenre, $strDate));
                        Application::addNotification(new Notification("L'ouvrage à été ajouté !", SUCCESS));
                        include 'vues/v_consulterOuvrage.php';
                    } else {
                        include 'vues/v_ajouterOuvrage.php';
                    }
                }
            } break;
        }        
    } break;    
    case 'modifierOuvrage' : {
        // initialisation des variables
        $hasErrors = false;
        $strTitre = '';
        $intSalle = '';
        $strGenre = '';
        $strDate = '';        
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirOuvrage';
        }
        switch($option) {            
            case 'saisirOuvrage' : {
                // récupération du code
                if (isset($_GET["id"])) {
                    include("vues/v_modifierOuvrage.php");
                } else {
                    Application::addNotification(new Notification("L'ouvrage est inconnu !", ERROR));
                    include ("vues/v_listeOuvrages.php");
                }
            } break;
            case 'validerOuvrage' : {
                // si on a cliqué sur Valider
                if (isset($_POST["cmdValider"])) {
                    // mémoriser les données pour les réafficher
                    $intID = intval($_POST["txtID"]);
                    //test zones obligatoires
                    if (!empty($_POST["txtTitre"])) {
                        $strTitre = ucfirst($_POST["txtTitre"]);
                    } else {
                        if(empty($strTitre)){
                            Application::addNotification(new Notification("Le titre est obligatoire", ERROR));
                        }
                        $hasErrors = true;
                    }
                    $intSalle = $_POST["rbnSalle"];
                    if (!empty($_POST["txtRayon"])) {
                        $strRayon = ucfirst($_POST["txtRayon"]);
                    } else {
                        if(empty($strRayon)){
                            Application::addNotification(new Notification("Le rayon est obligatoire", ERROR));
                        }
                        $hasErrors = true;
                    }
                    $strGenre = $_POST["cbxGenres"];
                    if (!empty($_POST["txtDate"])) {
                        $strDate = $_POST["txtDate"];
                    } else {
                        if(empty($strDate)){
                            Application::addNotification(new Notification("La date est obligatoire", ERROR));
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // mise à jour dans la base de données
                        $unOuvrage->setTitreOuvrage($strTitre);
                        $unOuvrage->setSalleOuvrage($intSalle);
                        $unOuvrage->setRayonOuvrage($strRayon);
                        $unOuvrage->setGenreOuvrage(new Genre($strGenre, Genres::chargerGenreParId($strGenre)->getLibelle()));
                        $unOuvrage->setDateAcquisitionOuvrage($strDate);
                        $res = Ouvrages::modifierOuvrage($unOuvrage);
                        Application::addNotification(new Notification("L'ouvrage à été modifié !", SUCCESS));
                        include 'vues/v_consulterOuvrage.php';
                    } else {
                        include ("vues/v_modifierOuvrage.php");
                    }
                }
            }
        }
    } break;
    case 'supprimerOuvrage' : {
        
        //rechercher des prêts de cet ouvrage
        if(Ouvrages::nbPretsEnCoursParOuvrage($unOuvrage->getNoOuvrage()) > 0) {
            //il y a des prêts en cours, suppression impossible
            Application::addNotification(new Notification("Il existe des prêts en cours, suppression impossible !", ERROR));
            include 'vues/v_consulterOuvrage.php';
        } else {
            //supprimer l'ouvrage
            Ouvrages::supprimerOuvrage($unOuvrage->getNoOuvrage());
            Application::addNotification(new Notification("L'ouvrage a bien été supprimé", SUCCESS));
            //Afficher la liste
            $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
            $nbOuvrages = count($lesOuvrages);
            include 'vues/v_listeOuvrages.php';
        }
    } break; 
}
