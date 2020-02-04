<h1>Admininstrator-Einstellungen für MUMIE-Task</h1>
<h2>MUMIE-Server-Konfiguration</h2>

<table class="default">
    <? foreach ($servers as $server) : ?>
        <tr>
            <td>
                <?= htmlReady($server['name']); ?>
            </td>
            <td>
                <?= htmlReady($server['url_prefix']); ?>
            </td>
            <td>
                <a href="<?= PluginEngine::getLink("MumieTask", array('server_id' => $name["server_id"]),'admin/delete'); ?>">
                    <?= Icon::create('trash', 'clickable')->asImg('20px'); ?>
                </a>
            </td>
        </tr>
    <? endforeach ?>
</table>
<a href=<?= PluginEngine::getLink("MumieTask", array(), 'admin/addServer'); ?> data-dialog class="button">Add Server</a>
