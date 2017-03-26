<?php
/**
 * Page de gestion des auteurs

 * @author 
 * @package default
 */
?>
<div id="content">
    <h2>Gestion des auteurs</h2>
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un auteur</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererAuteurs&action=ajouterAuteur">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererAuteurs&action=modifierAuteur&option=saisirAuteur&id=<?php echo $unAuteur->getId() ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererAuteurs&action=supprimerAuteur&id=<?php echo $unAuteur->getId() ?>">Supprimer</a>
                    <a href="index.php?uc=gererAuteurs&action=consulterAuteur&id=<?php echo $unAuteur->getId() ?>&list=true">Ouvrages de cet auteur</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unAuteur->getId() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unAuteur->getNomAuteur() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Prénom :
                        </td>
                        <td class="h-valeur">
                            <?php echo ($unAuteur->getPrenomAuteur()) ? $unAuteur->getPrenomAuteur() : "-" ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Alias :
                        </td>
                        <td class="h-valeur">
                            <?php echo ($unAuteur->getAliasAuteur()) ? $unAuteur->getAliasAuteur() : "-" ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Notes :
                        </td>
                        <td class="h-valeur">
                            <?php echo ($unAuteur->getNotesAuteur()) ? $unAuteur->getNotesAuteur() : "-" ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <?php
            if (!empty($list)) {
                echo '<fieldset>';
                echo '<legend>Liste d\'ouvrages de cet auteur</legend>';
                if ($nbOuvragesDeAuteur > 0) {
                    echo '<table>';
                    // affichage de l'entête du tableau
                    echo '<thead>';
                    echo '<tr>'
                    . '<th>ID</th>'
                    . '<th>Titre</th>'
                    . '<th>Genre</th>'
                    . '<th>Auteur(s)</th>'
                    . '<th>Salle</th>'
                    . '<th>Rayon</th>'
                    . '<th>Dernier prêt</th>'
                    . '<th>Disponibilité</th>'
                    . '</tr>';
                    echo '</thead>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach ($lesOuvragesDeAuteur as $unOuvrage) {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id='
                        . $unOuvrage->no_ouvrage . '">' . $unOuvrage->no_ouvrage . '</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>' . $unOuvrage->titre . '</td>';
                        echo '<td>' . $unOuvrage->lib_genre . '</td>';
                        if ($unOuvrage->auteur == 'Indéterminé') {
                            echo '<td class="erreur">' . $unOuvrage->auteur . '</td>';
                        } else {
                            echo '<td>' . $unOuvrage->auteur . '</td>';
                        }
                        echo '<td>' . $unOuvrage->salle . '</td>';
                        echo '<td>' . $unOuvrage->rayon . '</td>';
                        echo '<td>' . (!empty($unOuvrage->dernier_pret) ? Utilities::getDay($unOuvrage->dernier_pret) . ' ' . Utilities::getMonth($unOuvrage->dernier_pret, 2) . ' ' . Utilities::getYear($unOuvrage->dernier_pret) : '-') . '</td>';
                        if ($unOuvrage->disponibilite == 'D') {
                            echo '<td class="center"><img src="img/dispo.png"</td>';
                        } else {
                            echo '<td class="center"><img src="img/emprunte.png"</td>';
                        }
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                } else {
                    echo 'Aucun ouvrage pour cet auteur';
                }
                echo '</fieldset>';
            }
            ?>
        </div>
    </div>
</div>
