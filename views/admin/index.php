<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/addServer'); ?>"
    method="get" data-dialog>
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
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Neuen Server hinzufügen')); ?>
        </div>
    </fieldset>
</form>
<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/privacy'); ?>" method="post">
    <fieldset class="conf-form-field collapsable collapsed">
        <legend><?=dgettext("MumieTaskPlugin","Datenschutz");?></legend>
        <table>
            <tr>
                <td>
                    <label for="mumie_share_firstname">
                        <?= dgettext('MumieTaskPlugin', 'Vornamen teilen') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="checkbox" id="mumie_share_firstname" name="share_firstname"
                        <?= Config::get()->MUMIE_SHARE_FIRSTNAME ? "checked" : "";?>
                        placeholder="<?= dgettext('MumieTaskPlugin', 'Bestimmen Sie, ob Sie den Vornamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mumie_share_lastname">
                        <?= dgettext('MumieTaskPlugin', 'Nachnamen teilen') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="checkbox" name="share_lastname" id="mumie_share_lastname"
                        <?= Config::get()->MUMIE_SHARE_LASTNAME ? "checked" : "";?>
                        placeholder="<?= dgettext('MumieTaskPlugin', 'Bestimmen Sie, ob Sie den Nachnamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mumie_share_email">
                        <?= dgettext('MumieTaskPlugin', 'E-Mai-Addresse teilen') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="checkbox" id="mumie_share_lastname" name="share_email"
                        <?= Config::get()->MUMIE_SHARE_EMAIL ? "checked" : "";?>
                        placeholder="<?= dgettext('MumieTaskPlugin', 'Bestimmen Sie, ob Sie die E-Mail-Addresse der Nutzer mit MUMIE-Servern teilen wollen'); ?>">
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
        <fieldset class="conf-form-field collapsable collapsed">
        <legend><?=dgettext("MumieTaskPlugin","Authentifizierung");?></legend>
        <table>
            <tr>
                <td>
                    <label for="mumie_org">
                        <?= dgettext('MumieTaskPlugin', 'MUMIE-Org') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="text" id="mumie_org" name="mumie_org" value=<?= Config::get()->MUMIE_ORG;?>
                        placeholder="<?= dgettext('MumieTaskPlugin', 'Bestimmen Sie, ob Sie den Vornamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mumie_api_key">
                        <?= dgettext('MumieTaskPlugin', 'API-KEY teilen') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="text" name="mumie_api_key" id="mumie_api_key" value=<?= Config::get()->MUMIE_API_KEY;?>
                        placeholder="<?= dgettext('MumieTaskPlugin', 'Bestimmen Sie, ob Sie den Nachnamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>">
                </td>
            </tr>
        </table>
        <div data-dialog-button>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
        </div>
    </fieldset>
</form>