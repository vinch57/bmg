<?php

/**
 *
 * BMG
 * © GroSoft, 2016
 *
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe ClientDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	DRICI & DASTAN
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Client : fabrique d'objets Client
 *  ====================================================================
 */

// sollicite les méthodes de la classe ClientDal
require_once ('./modele/Dal/ClientDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Client.class.php');

class Clients {

    /**
     * Méthodes publiques
     */

    /**
     * récupère les Clients
     * @param   int 	$mode : 0 == tableau assoc, 1 == tableau d'objets
     * @param   int(optionnel)    $etat : 0 = uniquement les clients bannis, 1 = uniquement les clients interdits de prêt, 2 = uniquement les clients normaux
     * @return  un tableau de type $mode et selon l'état du client
     */
    public static function chargerLesClients($mode, $etat = null) {
        $tab = ClientDal::loadClients(1, $etat);
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unClient = new Client(
                            $ligne->no_client,
                            $ligne->nom_client,
                            $ligne->prenom,
                            $ligne->rue_client,
                            $ligne->code_post,
                            $ligne->ville,
                            $ligne->date_inscr,
                            $ligne->login,
                            $ligne->password,
                            $ligne->mel,
                            $ligne->etat_client,
                            $ligne->caution,
                            $ligne->caution_encaissee,
                            $ligne->montant_compte
                    );
                    array_push($res, $unClient);
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
     * vérifie si un Client existe
     * @param   int $id : l'id du client à contrôler
     * @return  un booléen
     */
    public static function clientExiste($id) {
        $values = ClientDal::loadClientByID($id, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }
    
    public static function recevoirDernierPretClient($no_client) {
        return ClientDal::getLastLoan($no_client);
    }

    /**
     * ajoute un Client
     * @param   array 	$valeurs : le tableau des propriétés du client à ajouter
     * @return  un objet de la classe Client
     */
   public static function ajouterClient($valeurs) {
        $id = ClientDal::addClient(
                $valeurs[0],
                $valeurs[1],
                $valeurs[2],
                $valeurs[3],
                $valeurs[4],
                $valeurs[5],
                $valeurs[6],
                $valeurs[7],
                $valeurs[8],
                $valeurs[9])
        ;

        return self::chargerClientParID($id);
    }

    /**
     * modifie un client
     * @param   Object $client : un objet de la classe Client
     * @return  int un code erreur revoyé par la méthode de la DAL
     */
    public static function modifierClient($client) {
        return ClientDal::setClient(
            $client->getNoClient(),
            $client->getNomClient(),
            $client->getPrenomClient(),
            $client->getRueClient(),
            $client->getCodePClient(),
            $client->getVilleClient(),
            $client->getMelClient(),
            $client->getCautionClient()
        );
    }
    /**
     * 
     * @param type $id : l'identifiant du client
     * @param type $password : le novueau mot de passe
     * @return int un code erreur revoyé par la méthode de la DAL
     */
    public static function reinitMotDePasse($id, $password) {
        return ClientDal::resetPassword($id, $password);
    }


    /**
     * récupère les caractéristiques du client
     * @param   int $id : l'id du client
     * @return  un objet de la classe Client
     */
    public static function chargerClientParId($id) {
        $values = ClientDal::loadClientByID($id, 1);
        if (Application::dataOK($values)) {
            $nom = $values[0]->nom_client;
            $prenom = $values[0]->prenom;
            $rue = $values[0]->rue_client;
            $codep = $values[0]->code_post;
            $ville = $values[0]->ville;
            $date_inscr = $values[0]->date_inscr;
            $login = $values[0]->login;
            $password = $values[0]->password;
            $mel = $values[0]->mel;
            $etat_client = $values[0]->etat_client;
            $caution = $values[0]->caution;
            $caution_encaissee = $values[0]->caution_encaissee;
            $montant_compte = $values[0]->montant_compte;
            return new Client ($id,$nom,$prenom,$rue,$codep,
                    $ville,$date_inscr,$login,$password,
                    $mel,$etat_client,$caution,$caution_encaissee,$montant_compte);
        }
        return NULL;
    }
    
    /**
     * Fonction qui retourne un nouveau login à partir du nom et prénom
     * @param type $nom
     * @param type $prenom
     * @return string
     */
    public static function recevoirNouveauLogin($nom, $prenom) {
        return ClientDal::getNewLogin($nom, $prenom);
    }
}
