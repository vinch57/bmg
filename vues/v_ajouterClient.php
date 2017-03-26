<?php
/** 
 * Page permettant l'ajout d'un client
 * @author 
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <form action="index.php?uc=gererClients&action=ajouterClient&option=validerClient" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Ajouter un client</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="txtNom">
                                    Nom :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" id="txtNom" 
                                    name="txtNom"
                                    size="50" maxlength="128"
                                    required="required"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtPrenom">
                                    Prénom :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtPrenom" 
                                    name="txtPrenom"
                                    size="50" maxlength="128"
                                    required="required"
                                    <?php 
                                        if (!empty($strPrenom)) {
                                            echo ' value="'.$strPrenom.'"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtRue">
                                    Rue :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" id="txtRue" 
                                    name="txtRue"
                                    size="50" maxlength="128"
                                    required="required"
                                    <?php 
                                        if (!empty($strRue)) {
                                            echo ' value="'.$strRue.'"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>                                        
                        <tr>
                            <td>
                                <label for="txtCp">
                                    Code postal :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtCp" 
                                    name="txtCp"
                                    size="10" maxlength="5"
                                    required="required"
                                    <?php 
                                        if (!empty($strCp)) {
                                            echo ' value="'.$strCp.'"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtVille">
                                    Ville :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtVille" 
                                    name="txtVille"
                                    size="50" maxlength="128"
                                    required="required"
                                    <?php 
                                        if (!empty($strVille)) {
                                            echo ' value="'.$strVille.'"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtMail">
                                    Choisissez une adresse mail :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtMail" 
                                    name="txtMail"
                                    size="50" maxlength="128"
                                    required="required"
                                    <?php 
                                        if (!empty($strMail)) {
                                            echo ' value="'.$strMail.'"';
                                        }
                                    ?>
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtCaution">
                                    Entrez une caution :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtCaution" 
                                    name="txtCaution"
                                    size="50" maxlength="128"
                                    required="required"
                                    <?php 
                                            echo ' value="'.DEFAULT_CAUTION.'"';
                                    ?>
                                />
                            </td>
                        </tr>
                    </table>                                
                </fieldset>
            </div>
            <div class="pied-form">
                <p>
                    <input id="cmdValider" name="cmdValider" 
                           type="submit"
                           value="Ajouter"
                    />
                </p> 
            </div>
        </form>
    </div>
</div>          

