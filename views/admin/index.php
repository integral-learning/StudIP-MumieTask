<style type="text/css">
    <?php include 'public/plugins_packages/integral-learning/MumieTaskPlugin/mumieStyle.css';
    ?>
</style>

<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/addServer'); ?>" method="get"
    data-dialog>
    <fieldset class="conf-form-field collapsable">
        <legend><?=dgettext("MumieTaskPlugin", "MUMIE-Server-Konfiguration");?></legend>
        <table class="default">
            <tr>
                <th>Name</th>
                <th>URL-Prefix</th>
                <th>Bearbeiten</th>
                <th>Löschen</th>
            </tr>
            <?php foreach ($servers as $server) : ?>
            <tr>
                <td>
                    <?= htmlReady($server['name']); ?>
                </td>
                <td>
                    <?= htmlReady($server['url_prefix']); ?>
                </td>
                <td>
                    <a href="
                        <?=
                            PluginEngine::getLink(
                                "MumieTaskPlugin",
                                array('server_id' => $server["server_id"]),
                                'admin/editServer'
                            );
                        ?>"
                    data-dialog>
                        <?= Icon::create('edit', 'clickable')->asImg('20px'); ?>
                    </a>
                </td>
                <td>
                    <a
                        href="<?= PluginEngine::getLink("MumieTaskPlugin", array('server_id' => $server["server_id"]), 'admin/delete'); ?>">
                        <?= Icon::create('trash', 'clickable')->asImg('20px'); ?>
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        <div data-dialog-button>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Server hinzufügen')); ?>
        </div>
    </fieldset>
</form>
<form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/authentication'); ?>"
    method="post">
    <fieldset class="conf-form-field collapsable">
        <legend><?=dgettext("MumieTaskPlugin", "Authentifizierung");?></legend>
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
    </fieldset>
    <fieldset class="conf-form-field collapsable">
        <legend>
            <?=dgettext("MumieTaskPlugin", "Entwickler-Optionen");?>
        </legend>
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
                    <label for="mumie_pool_url">
                        <?= dgettext('MumieTaskPlugin', 'Problem-Selector-URL') . ':'; ?>
                    </label>
                </td>
                <td>
                    <input type="text" name="mumie_pool_url" id="mumie_pool_url"
                        value=<?= Config::get()->MUMIE_POOL_URL;?>>
                    <p class="mumie-hint">
                        <?=dgettext("MumieTaskPlugin", "URL der Pool-Instanz, die zur Aufgabenauswahl genutzt wird. Standard: https://pool.mumie.net"); ?>
                    </p>
                </td>
            </tr>
        </table>
        <div data-dialog-button>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
        </div>
    </fieldset>
</form>