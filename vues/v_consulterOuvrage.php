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
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un ouvrage</legend>                        
                <div id="breadcrumb">
                    <a href="index.php?uc=gererOuvrages&action=ajouterOuvrage">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererOuvrages&action=modifierOuvrage&option=saisirOuvrage&id=<?php echo $unOuvrage->getNoOuvrage() ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererOuvrages&action=supprimerOuvrage&id=<?php echo $unOuvrage->getNoOuvrage() ?>">Supprimer</a>
                    <a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id=<?php echo $unOuvrage->getNoOuvrage() ?>&list=true">Liste de prêts</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unOuvrage->getNoOuvrage() ?>
                        </td>
                        <td class="right h-valeur" rowspan="8">
                            <?php echo $unOuvrage->getCouverture($unOuvrage->getNoOuvrage(), $unOuvrage->getTitreOuvrage()) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Titre :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unOuvrage->getTitreOuvrage() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Auteur(s) :
                        </td>
                        <td class="h-valeur">
                            <?php
                            $tabAuteurs = $unOuvrage->getAuteurs();
                            foreach ($tabAuteurs as $unAuteur) {
                                echo $unAuteur->getPrenomAuteur() . ' ' . $unAuteur->getNomAuteur() . ' ';
                                echo (!empty($unAuteur->getAliasAuteur())) ? '(' . $unAuteur->getAliasAuteur() . ')' : '';
                            }
                            ?>
                        </td>
                    </tr>                                
                    <tr>
                        <td class="h-entete">
                            Date d'acquisition :
                        </td>
                        <td class="h-valeur">
                            <?php echo (!empty($unOuvrage->getDateAcquisitionOuvrage()) ? Utilities::getDay($unOuvrage->getDateAcquisitionOuvrage()) . ' ' . Utilities::getMonth($unOuvrage->getDateAcquisitionOuvrage(), 1) . ' ' . Utilities::getYear($unOuvrage->getDateAcquisitionOuvrage()) : '-') ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Genre :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unOuvrage->getGenreOuvrage()->getLibelle(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Salle et rayon :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unOuvrage->getSalleOuvrage() . ', ' . $unOuvrage->getRayonOuvrage() ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Dernier prêt :
                        </td>
                        <td class="h-valeur">
                            <?php echo (!empty($unOuvrage->getDateDernierPret()) ? Utilities::getDay($unOuvrage->getDateDernierPret()) . ' ' . Utilities::getMonth($unOuvrage->getDateDernierPret(), 1) . ' ' . Utilities::getYear($unOuvrage->getDateDernierPret()) : '-') ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Disponibilité :
                        </td>
                        <td class="h-valeur">
                            <?php
                            if ($unOuvrage->getDisponibilite() == "D") {
                                echo '<img src="img/dispo.png" alt="" />';
                            } else {
                                echo '<img src="img/emprunte.png" alt="" />';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <?php
            if (!empty($list)) {
                echo '<fieldset>';
                echo '<legend>Liste de prêts de cet ouvrage</legend>';
                if ($nbPretsDeOuvrage > 0) {
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>'
                    . '<th>ID</th>'
                    . '<th>Client</th>'
                    . '<th>Date emprunt</th>'
                    . '<th>Date retour</th>'
                    . '<th>Pénalité</th>'
                    . '</tr>';
                    echo '</thead>';
                    $n = 0;
                    foreach ($lesPretsDeOuvrage as $unPret) {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererPrets&action=consulterPret&id='
                        . $unPret->id_pret . '">' . $unPret->id_pret . '</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>' . $unPret->nom_prenom_client . '</td>';
                        echo '<td>' . $unPret->date_emp . '</td>';
                        echo '<td>' . $unPret->date_ret . '</td>';
                        if ($unPret->penalite == null) {
                            echo '<td class="erreur">' . 'Pas de pénalité' . '</td>';
                        } else {
                            echo '<td>' . $unPret->penalite . '</td>';
                        }
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                } else {
                    echo 'Aucun prêt pour cet ouvrage';
                }
                echo '</fieldset>';
            }
            ?>
        </div>
    </div>
</div>
