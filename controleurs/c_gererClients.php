<?php

/**
 * Contrôleur secondaire chargé de la gestion des clients
 * @author  
 */
// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/App/Utilities.class.php');
require_once ('modele/Bll/Clients.class.php');
require_once ('include/_config.inc.php'); //pour accéder aux constantes
// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerClients';
}

// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unClient = Clients::chargerClientParID($id);
}


// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerClients' : {

            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'listerTousLesClients';
            }

            switch ($option) {
                case 'listerTousLesClients' : {
                        //récupérer les clients
                        $lesClients = Clients::chargerLesClients(1);
                    } break;
                case 'listerClientsBannis' : {
                        $lesClients = Clients::chargerLesClients(1, 0);
                    } break;
                case 'listerClientsInterditsPret' : {
                        $lesClients = Clients::chargerLesClients(1, 1);
                    } break;
                case 'listerClientsNormaux' : {
                        $lesClients = Clients::chargerLesClients(1, 2);
                    } break;
            }
            //afficher le nombre de clients
            //var_dump($lesClients);
            $nbClients = count($lesClients);
            include 'vues/v_listeClients.php';
        } break;
    case 'consulterClient' : {
            if ($unClient == NULL) {
                Application::addNotification(new Notification("Ce client n'existe pas !", ERROR));
            } else {
                include 'vues/v_consulterClient.php';
            }
        } break;
    case 'ajouterClient' : {
            // initialisation des variables
            $hasErrors = false;
            $strNom = '';
            $strPrenom = '';
            $strRue = '';
            $strCp = '';
            $strVille = '';
            $strMdp = '';
            $strMail = '';
            $strCaution = '';
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirClient';
            }
            switch ($option) {
                case 'saisirClient' : {
                        include 'vues/v_ajouterClient.php';
                    } break;
                case 'validerClient' : {
                        // tests de gestion du formulaire
                        if (isset($_POST["cmdValider"])) {
                            // récupération des valeurs saisies
                            if (!empty($_POST["txtNom"]) && !empty($_POST["txtPrenom"]) && !empty($_POST["txtRue"]) && !empty($_POST["txtCp"]) && !empty($_POST["txtVille"]) && preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['txtMail']) && !$_POST["txtCaution"] == 0) {
                                $strNom = ucfirst(htmlentities($_POST["txtNom"]));
                                $strPrenom = ucfirst(htmlentities($_POST["txtPrenom"]));
                                $strRue = ucfirst(htmlentities($_POST["txtRue"]));
                                $strCp = ucfirst(htmlentities($_POST["txtCp"]));
                                $strVille = ucfirst(htmlentities($_POST["txtVille"]));
                                $strMail = htmlentities($_POST["txtMail"]);
                                $strCaution = htmlentities($_POST["txtCaution"]);
                                $strMdp = Utilities::getTempPassword(8);
                                $strLogin = Clients::recevoirNouveauLogin($strNom, $strPrenom);
                                $strDateInscription = date("Y-m-d H:i:s");
                            } else {
                                if (empty($_POST["txtNom"])) {
                                    Application::addNotification(new Notification("Le nom doit être renseigné", ERROR));
                                }
                                if (empty($_POST["txtPrenom"])) {
                                    Application::addNotification(new Notification("Le prénom doit être renseigné", ERROR));
                                }
                                if (empty($_POST["txtRue"])) {
                                    Application::addNotification(new Notification("La rue doit être renseigné", ERROR));
                                }
                                if (empty($_POST["txtCp"])) {
                                    Application::addNotification(new Notification("Le code postal doit être renseigné", ERROR));
                                }
                                if (empty($_POST["txtVille"])) {
                                    Application::addNotification(new Notification("La ville doit être renseigné", ERROR));
                                }

                                if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['txtMail'])) {
                                    Application::addNotification(new Notification("Veuillez entrer un email valide du type ttt@ooo.dd", ERROR));
                                }

                                if (empty($_POST["txtCaution"]) || $_POST["txtCaution"] == 0) {
                                    Application::addNotification(new Notification("La caution doit être renseignée et être supérieure à 0", ERROR));
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                // ajout dans la base de données
                                $unClient = Clients::ajouterClient(array($strNom, $strPrenom, $strRue, $strCp, $strVille, $strDateInscription, $strLogin, $strMdp, $strMail, $strCaution));
                                Application::addNotification(new Notification("Le client a été ajouté !", SUCCESS));
                                include 'vues/v_consulterClient.php';
                            } else {
                                include 'vues/v_ajouterClient.php';
                            }
                        }
                    } break;
            }
        } break;
    case 'modifierClient' : {
            // initialisation des variables
            $hasErrors = false;
            $strNom = '';
            $strPrenom = '';
            $strCp = '';
            $strVille = '';
            $strMail = '';
            $strCaution = '';
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirClient';
            }
            switch ($option) {
                case 'saisirClient' : {
                        // récupération du code
                        if (isset($_GET["id"])) {
                            include("vues/v_modifierClient.php");
                        } else {
                            Application::addNotification(new Notification("Le client est inconnu !", ERROR));
                            include ("vues/v_listeClients.php");
                        }
                    } break;
                case 'validerClient' : {
                        // si on a cliqué sur Valider
                        if (isset($_POST["cmdValider"])) {
                            // mémoriser les données pour les réafficher
                            // test zones obligatoires
                            if (!empty($_POST["txtNom"])) {
                                $strNom = ucfirst(htmlentities($_POST["txtNom"]));
                            } else {
                                if (empty($strNom)) {
                                    Application::addNotification(new Notification("Le nom est obligatoire", ERROR));
                                }
                                $hasErrors = true;
                            }

                            if (!empty($_POST["txtPrenom"])) {
                                $strPrenom = ucfirst(htmlentities($_POST["txtPrenom"]));
                            } else {
                                if (empty($strPrenom)) {
                                    Application::addNotification(new Notification("Le prénom est obligatoire", ERROR));
                                }
                                $hasErrors = true;
                            }
                            if (!empty($_POST["txtRue"])) {
                                $strRue = ucfirst(htmlentities($_POST["txtRue"]));
                            } else {
                                if (empty($strRue)) {
                                    Application::addNotification(new Notification("La rue est obligatoire", ERROR));
                                }
                                $hasErrors = true;
                            }

                            if (!empty($_POST["txtCp"])) {
                                $strCp = ucfirst(htmlentities($_POST["txtCp"]));
                            } else {
                                if (empty($strCp)) {
                                    Application::addNotification(new Notification("Le code postal est obligatoire", ERROR));
                                }
                                $hasErrors = true;
                            }

                            if (!empty($_POST["txtVille"])) {
                                $strVille = ucfirst(htmlentities($_POST["txtVille"]));
                            } else {
                                if (empty($strVille)) {
                                    Application::addNotification(new Notification("La ville est obligatoire", ERROR));
                                }
                                $hasErrors = true;
                            }

                            if (!empty($_POST["txtMel"])) {
                                $strMail = htmlentities($_POST["txtMel"]);
                            } else {
                                if (empty($strMail)) {
                                    Application::addNotification(new Notification("Le mail est obligatoire", ERROR));
                                }
                                $hasErrors = true;
                            }

                            $strCaution = ucfirst(htmlentities($_POST["txtCaution"]));

                            if (!$hasErrors) {
                                // mise à jour dans la base de données
                                $unClient->setNom($strNom);
                                $unClient->setPrenom($strPrenom);
                                $unClient->setRue($strRue);
                                $unClient->setCodeP($strCp);
                                $unClient->setVille($strVille);
                                $unClient->setMel($strMail);
                                $unClient->setCaution($strCaution);
                                $res = Clients::modifierClient($unClient);
                                Application::addNotification(new Notification("Le client a été modifié !", SUCCESS));
                                include 'vues/v_consulterClient.php';
                            } else {
                                include("vues/v_modifierClient.php");
                            }
                        }
                    }
            }
        } break;
    case 'reinitialiserMotDePasse' : {
            $res = Clients::reinitMotDePasse($unClient->getNoClient(), Utilities::getTempPassword(8));
            Application::addNotification(new Notification("Le mot de passe à été réinitialisé !", SUCCESS));
            include 'vues/v_consulterClient.php';
        } break;
}
