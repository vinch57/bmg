<?php
/**
 * Page de modification d'un client
 * @author Loîc Dimitri BG Team
 * @package default
*/
?>
<div id="content">
    <h2>Gestion des clients</h2>
    <?php AdminRender::showNotifications(); ?>
    <div id="object-list">
        <form action="index.php?uc=gererClients&action=modifierClient&option=validerClient&id=<?php echo $unClient->getNoClient() ?>" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Modifier un client</legend>
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
                                    size="50" maxlength="50"
                                    required="required"
                                    value="<?php echo $unClient->getNomClient() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtPrenom">
                                    Prénom :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtPrenom"
                                    name="txtPrenom"
                                    size="50" maxlength="50"
                                    required="required"
                                    value="<?php echo $unClient->getPrenomClient() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtRue">
                                    Rue :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtRue"
                                    name="txtRue"
                                    size="50" maxlength="50"
                                    required="required"
                                    value="<?php echo $unClient->getRueClient() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtCp">
                                    Code postal :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtCp"
                                    name="txtCp"
                                    size="50" maxlength="5"
                                    required="required"
                                    value="<?php echo $unClient->getCodePClient() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtVille">
                                    Ville :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtVille"
                                    name="txtVille"
                                    size="50" maxlength="50"
                                    required="required"
                                    value="<?php echo $unClient->getVilleClient() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtMel">
                                    Mail :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtMel"
                                    name="txtMel"
                                    size="50" maxlength="50"
                                    required="required"
                                    value="<?php echo $unClient->getMelClient() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtCaution">
                                    Caution :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtCaution"
                                    name="txtCaution"
                                    size="50" maxlength="50"
                                    required="required"
                                    value="<?php echo $unClient->getCautionClient() ?>"
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
                           value="Modifier"
                    />
                </p>
            </div>
        </form>
    </div>
</div>
