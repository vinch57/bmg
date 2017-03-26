<?php
/** 
 * Page de gestion des clients

 * @author 	thomas pascuzzo
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <div class="corps-form">
            <fieldset>
                <legend>Consulter un client</legend>   
                <div id="breadcrumb">
                    <a href="index.php?uc=gererClients&action=ajouterClient">Ajouter</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=modifierClient&option=saisirClient&id=<?php echo $unClient->getNoClient (); ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=supprimerClient&id=<?php echo $unClient->getNoClient ();?>">Supprimer</a>
                    <a href="index.php?uc=gererClients&action=reinitialiserMotDePasse&id=<?php echo $unClient->getNoClient ();?>">Réinitialiser le mot de passe</a>
                </div>
                
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getNoClient (); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getNomClient(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Prénom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getPrenomClient(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Adresse :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getRueClient(); ?> <br/>
                            <?php echo $unClient->getCodePClient(); ?>
                            <?php echo $unClient->getVilleClient(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            E-mail :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getMelClient(); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="h-entete">
                            Date d'inscripition :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getDateInscrClient (); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="h-entete">
                            Etat :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getEtatClient (); ?>
                        </td>
                    </tr>
                     <tr>
                        <td class="h-entete">
                            Compte :
                        </td>
                        <td class="h-valeur">
                            <?php echo $unClient->getMontantCompteClient (); ?>
                        </td>
                    </tr>
                    <div id="breadcrumb">
                    <a href="index.php?uc=gererClients&action=pretsClient&id=<?php echo $unClient->getNoClient ();?>">Prêts</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=evenementsClients&id=<?php echo $unClient->getNoClient (); ?>">Evenements</a>&nbsp;
                    <a href="index.php?uc=gererClients&action=operationsClient&id=<?php echo $unClient->getNoClient ();?>">Operations</a>
                </div>
                    
                </table>
            </fieldset>                    
        </div>
    </div>
</div>


