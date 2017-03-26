<?php
/**
 * Page de gestion des auteurs

 * @author DIMITRI LE BG
 * @package default
 */
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <div id="breadcrumb">
        <a href="index.php?uc=gererClients&action=ajouterClient" title="Ajouter">Ajouter un client</a>
        <a href="index.php?uc=gererClients" title="ListerTous">Tous les clients</a>
        <a href="index.php?uc=gererClients&action=listerClients&option=listerClientsNormaux" title="ListerNormaux">Clients normaux</a>
        <a href="index.php?uc=gererClients&action=listerClients&option=listerClientsBannis" title="ListerBannis">Clients bannis</a>
        <a href="index.php?uc=gererClients&action=listerClients&option=listerClientsInterditsPret" title="ListerInterdits">Clients interdits de prêt</a>
    </div>
    <div class="corps-form">
        <!--- afficher la liste des clients -->
        <fieldset>	
            <legend>Clients</legend>
            <div id="object-list">
                <?php
                echo '<span>' . $nbClients . ' client(s) trouvé(s)'
                . '</span><br /><br />';
                // afficher un tableau des clients
                if ($nbClients > 0) {
                    // création du tableau
                    echo '<table id="table_pagination" class="display">';
                    // affichage de l'entete du tableau 
                    echo '<thead>';
                    echo '<tr>'
                    . '<th>ID</th>'
                    . '<th>Nom</th>'
                    . '<th>Prénom</th>'
                    . '<th>Ville</th>'
                    . '<th>Etat client</th>'
                    . '<th>Caution</th>'
                    . '<th>Date dernier prêt</th>'
                    . '</tr>';
                    echo '</thead>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach ($lesClients as $client) {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererClients&action=consulterClient&id='
                        . $client->getNoClient() . '">' . $client->getNoClient() . '</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>' . $client->getNomClient() . '</td>';
                        echo '<td>' . $client->getPrenomClient() . '</td>';
                        echo '<td>' . $client->getVilleClient() . '</td>';
                        echo '<td>' . $client->getEtatClient() . '</td>';
                        echo '<td>' . $client->getCautionClient() . '</td>';
                        echo '<td>';
                        echo (!empty($client->getDateDernierPret())) ? Utilities::getDateFrancais($client->getDateDernierPret()) : '-';
                        echo '</td>';
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                } else {
                    echo "Aucun client trouvé !";
                }
                ?>
            </div>
        </fieldset>
    </div>
</div>          
