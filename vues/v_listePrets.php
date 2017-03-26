<?php
/** 
 * Page de gestion des prets
  * @author pv
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des prets</h2>
    <?php AdminRender::showNotifications();?>
    <div id="breadcrumb">
        <a href="index.php?uc=gererPrets&action=ajouterPret" title="Ajouter">Ajouter un pret</a>
        <a href="index.php?uc=gererPrets" title="Lister tous les prêts">Tous les prêts</a>
        <a href="index.php?uc=gererPrets&action=listerPrets&option=listerPretsEnCours" title="Lister prêts en cours">Prêts en cours</a>
        <a href="index.php?uc=gererPrets&action=listerPrets&option=listerPretsRendusEnRetard" title="Lister prêts rendus en retard">Prêts rendus en retard</a>
        <a href="index.php?uc=gererPrets&action=listerPrets&option=listerPretsRendusATemps" title="Lister prêts rendus à temps">Prêts rendus à temps</a>
        <a href="index.php?uc=gererPrets&action=listerPrets&option=listerPretsEnRetard" title="Lister prêts irrécupérables">Prêts irrécupérables</a>
    </div>
    
    <div class="corps-form">
        <fieldset>	
            <legend>Prets</legend>
            <div id="object-list">
                <?php
                if($nbPrets>1)
                {
                    echo '<span>'.$nbPrets.' prets trouvés'
                            . '</span><br /><br />';   
                }
                else{
                    echo '<span>'.$nbPrets.' pret trouvé'
                            . '</span><br /><br />';   
                }
                // afficher un tableau des prets
                if ($nbPrets > 0) {
                    // création du tableau
                    echo '<table id="table_pagination" class="display">';
                    // affichage de l'entête du tableau 
                    echo '<thead>';
                    echo '<tr>'
                            .'<th>ID</th>'
                            .'<th>Numéro client</th>'
                            .'<th>Numéro ouvrage</th>'
                            .'<th>Date emprunt</th>'
                            .'<th>Date retour</th>'
                            .'<th>Pénalité</th>'
                        .'</tr>';
                    echo '</thead>';
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach($lesPrets as $ligne)  {
                        echo '<tr>';
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td><a href="index.php?uc=gererPrets&action=consulterPret&id='
                            .$ligne->getId().'">'.$ligne->getId().'</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td><center>'.$ligne->getNoClient().'</center></td>';
                         echo '<td><center><a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id='
                            .$ligne->getNoOuvrage().'">'.$ligne->getNoOuvrage().'</a></center></td>';
                        echo '<td>'.$ligne->getDateEmp().'</td>';
                        echo '<td>'.$ligne->getDateRet().'</td>';
                        if ($ligne->getPenalite() == NULL) {
                            echo '<td class="erreur">Pas de pénalité</td>';
                        }
                        else {
                            echo '<td>'.$ligne->getPenalite().'</td>';
                        }
                        echo '</tr>';
                        $n++;
                    }
                    echo '</table>';
                }
                else {			
                    echo "Aucun prêt trouvé !";
                }		
                ?>
            </div>
        </fieldset>
    </div>
</div>
