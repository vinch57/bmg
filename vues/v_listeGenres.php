<?php
/** 
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Page de gestion des genres
 * Affiche une liste des genres présents dans la base
 * @author  klein
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des genres</h2>
    <?php AdminRender::showNotifications(); ?>
    <a href="index.php?uc=gererGenres&action=ajouterGenre" title="Ajouter">
        Ajouter un genre
    </a>
    <div class="corps-form">
        <fieldset>	
            <legend>Genres</legend>
            <div id="object-list">
                <?php
                echo '<span>'.$nbGenres.' genre(s) trouvé(s)'
                        . '</span><br /><br />';
                // afficher un tableau des genres
                if ($nbGenres > 0) {
                    // création du tableau
                    echo '<table id="table_pagination" class="display">';
                    // affichage de l'entete du tableau 
                    echo '<thead>';
                    echo '<tr>';
                    // création entete tableau avec noms de colonnes  
                    echo '<th>Code</th>';
                    echo '<th>Libellé</th>';
                    echo '</tr>';
                    echo '</thead>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesGenres as $unGenre)  {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererGenres&action=consulterGenre&id='
                            .$unGenre->getCode().'">'.$unGenre->getCode().'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>'.$unGenre->getLibelle().'</td>';
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun genre trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>