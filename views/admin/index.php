<h1><?=dgettext("MumieTaskPlugin","MUMIE-Server-Konfiguration");?></h1>
<section class="contentbox">
    <section>

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
        <a href=<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/addServer'); ?> data-dialog class="button">
            Add Server
        </a>
    </section>
</section>