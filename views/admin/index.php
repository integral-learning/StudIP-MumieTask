<style type="text/css">
    <?php include 'public/plugins_packages/integral-learning/MumieTaskPlugin/mumieStyle.css';
    ?>
</style>

<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/addServer'); ?>" method="get"
    data-dialog>
    <fieldset class="conf-form-field collapsable">

        <legend><?=dgettext("MumieTaskPlugin","MUMIE-Server-Konfiguration");?></legend>


        <table class="default">
            <tr>
                <th>Name</th>
                <th>URL-Prefix</th>
                <th>Bearbeiten</th>
                <th>Löschen</th>
            </tr>
            <? foreach ($servers as $server) : ?>
            <tr>
                <td>
                    <?= htmlReady($server['name']); ?>
                </td>
                <td>
                    <?= htmlReady($server['url_prefix']); ?>
                </td>
                <td>
                    <a href="<?= PluginEngine::getLink("MumieTaskPlugin", array('server_id' => $server["server_id"]),'admin/editServer'); ?>"
                        data-dialog>
                        <?= Icon::create('edit', 'clickable')->asImg('20px'); ?>
                    </a>
                </td>
                <td>
                    <a
                        href="<?= PluginEngine::getLink("MumieTaskPlugin", array('server_id' => $server["server_id"]),'admin/delete'); ?>">
                        <?= Icon::create('trash', 'clickable')->asImg('20px'); ?>
                    </a>
                </td>
            </tr>
            <? endforeach ?>
        </table>
        <div data-dialog-button>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Server hinzufügen')); ?>
        </div>
    </fieldset>
</form>
<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/privacy'); ?>" method="post">
    <fieldset class="conf-form-field collapsable">
        <legend>
            <?=dgettext("MumieTaskPlugin","Datenschutz");?>
        </legend>
        <table class="default">
            <caption>
                <?=dgettext("MumieTaskPlugin", "Legen Sie fest, welche Nutzerdaten an MUMIE-Server geschickt werden sollen."); ?>
            </caption>
            <tr>
                <th>
                    <?=dgettext("MumieTaskPlugin", "Einstellung");?>
                </th>
                <th>
                    <?=dgettext("MumieTaskPlugin", "Wert");?>
                </th>
            </tr>
            <tr>
                <td>
                    <label for="mumie_share_firstname">
                        <?= dgettext('MumieTaskPlugin', 'Vorname'); ?>
                    </label>
                </td>
                <td>
                    <input type="checkbox" id="mumie_share_firstname" name="share_firstname"
                        <?= Config::get()->MUMIE_SHARE_FIRSTNAME ? "checked" : "";?>>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mumie_share_lastname">
                        <?= dgettext('MumieTaskPlugin', 'Nachname'); ?>
                    </label>
                </td>
                <td>
                    <input type="checkbox" name="share_lastname" id="mumie_share_lastname"
                        <?= Config::get()->MUMIE_SHARE_LASTNAME ? "checked" : "";?>>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mumie_share_email">
                        <?= dgettext('MumieTaskPlugin', 'E-Mail-Addresse'); ?>
                    </label>
                </td>
                <td>
                    <input type="checkbox" id="mumie_share_email" name="share_email"
                        <?= Config::get()->MUMIE_SHARE_EMAIL ? "checked" : "";?>>
                </td>
            <tr>
        </table>
        <div data-dialog-button>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
        </div>
    </fieldset>
</form>
<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/authentication'); ?>"
    method="post">
    <fieldset class="conf-form-field collapsable">
        <legend><?=dgettext("MumieTaskPlugin","Authentifizierung");?></legend>
        <table class="default">
            <tr>
                <th>
                    <?=dgettext("MumieTaskPlugin", "Einstellung");?>
                </th>
                <th>
                    <?=dgettext("MumieTaskPlugin", "Wert");?>
                </th>
            </tr>
            <tr>
                <td>
                    <label for="mumie_org">
                        <?= dgettext('MumieTaskPlugin', 'MUMIE-Organisation') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="text" id="mumie_org" name="mumie_org" value=<?= Config::get()->MUMIE_ORG;?>>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mumie_api_key">
                        <?= dgettext('MumieTaskPlugin', 'API-KEY') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="text" name="mumie_api_key" id="mumie_api_key"
                        value=<?= Config::get()->MUMIE_API_KEY;?>>
                </td>
            </tr>
        </table>
        <div data-dialog-button>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
        </div>
    </fieldset>
</form>