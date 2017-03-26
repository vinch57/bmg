<?php
/** 
 * Page de gestion des ouvrages

  * @author 
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des ouvrages</h2>
    <?php AdminRender::showNotifications(); ?>
    <a href="index.php?uc=gererOuvrages&action=ajouterOuvrage" title="Ajouter">
        Ajouter un ouvrage
    </a>
    <div class="corps-form">
        <fieldset>	
            <legend>Ouvrages</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbOuvrages.' ouvrage(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des ouvrages
                if ($nbOuvrages > 0) {
                    // création du tableau
                    echo '<table id="table_pagination" class="display">';
                    // affichage de l'entête du tableau
                    echo '<thead>';
                    echo '<tr>'
                            .'<th>ID</th>'
                            .'<th>Titre</th>'
                            .'<th>Genre</th>'
                            .'<th>Auteur(s)</th>'
                            .'<th>Salle</th>'
                            .'<th>Rayon</th>'
                            .'<th>Dernier prêt</th>'
                            .'<th>Disponibilité</th>'
                            .'</tr>';
                    echo '</thead>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesOuvrages as $unOuvrage)  {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id='
                            .$unOuvrage->no_ouvrage.'">'.$unOuvrage->no_ouvrage.'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>'.$unOuvrage->titre.'</td>';
                        echo '<td>'.$unOuvrage->lib_genre.'</td>';
                        if ($unOuvrage->auteur == 'Indéterminé') {
                            echo '<td class="erreur">'.$unOuvrage->auteur.'</td>';
                        }
                        else {
                            echo '<td>'.$unOuvrage->auteur.'</td>';
                        }
                        echo '<td>'.$unOuvrage->salle.'</td>';
                        echo '<td>'.$unOuvrage->rayon.'</td>';
                        echo '<td>'.(!empty($unOuvrage->dernier_pret) ? Utilities::getDay($unOuvrage->dernier_pret).' '. Utilities::getMonth($unOuvrage->dernier_pret, 2).' '.Utilities::getYear($unOuvrage->dernier_pret) : '-').'</td>';
                        if ($unOuvrage->disponibilite == 'D') {
                            echo '<td class="center"><img src="img/dispo.png"</td>';
                        }
                        else {
                            echo '<td class="center"><img src="img/emprunte.png"</td>';
                        }
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun ouvrage trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>