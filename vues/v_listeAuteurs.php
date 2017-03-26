<?php
/** 
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Page de gestion des auteurs
 * Affiche une liste d'auteurs présents dans la base
 * @author  dk
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des auteurs</h2>
    <?php AdminRender::showNotifications(); ?>
    <a href="index.php?uc=gererAuteurs&action=ajouterAuteur" title="Ajouter">
        Ajouter un auteur
    </a>
    <div class="corps-form">
        <!--- afficher la liste des auteurs -->
        <fieldset>	
            <legend>Auteurs</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbAuteurs.' auteur(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des auteurs
                if ($nbAuteurs > 0) {
                    // création du tableau
                    echo '<table id="table_pagination" class="display">';
                    // affichage de l'entete du tableau 
                    echo '<thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Alias</th><th>Notes</th></tr></thead>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesAuteurs as $unAuteur) {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererAuteurs&action=consulterAuteur&id='
                            .$unAuteur->getId().'">'.$unAuteur->getId().'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>'.$unAuteur->getNomAuteur().'</td>';
                        echo '<td>'.$unAuteur->getPrenomAuteur().'</td>';
                        echo '<td>'.$unAuteur->getAliasAuteur().'</td>';
                        echo '<td>'.$unAuteur->getNotesAuteur().'</td>';
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun auteur trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>          
