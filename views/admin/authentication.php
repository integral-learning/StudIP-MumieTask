<h1>Admininstrator-Einstellungen für MUMIE-Task</h1>
<h2>Authentifizierung</h2>
<form class="default" action="<?= PluginEngine::getLink("MumieTask", array(), 'admin/authentication'); ?>" method="post">
<table>
    <tr>
        <td>
            <label for="mumie_org">
                <?= dgettext('MumieTask', 'MUMIE-Org') . ':'; ?>
            </label>
        </td>
        <td>
            <input type="text" id="mumie_org" name="mumie_org" value=<?= Config::get()->MUMIE_ORG;?> placeholder="<?= dgettext('MumieTask', 'Bestimmen Sie, ob Sie den Vornamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>" >
        </td>
    </tr>
    <tr>
        <td>
            <label for="mumie_api_key">
                <?= dgettext('MumieTask', 'API-KEY teilen') . ':'; ?>
            </label>
        </td>
        <td>
            <input type="text" name="mumie_api_key" id="mumie_api_key" value=<?= Config::get()->MUMIE_API_KEY;?> placeholder="<?= dgettext('MumieTask', 'Bestimmen Sie, ob Sie den Nachnamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>" >
        </td>
    </tr>
</table>
    <div data-dialog-button>
        <?= \Studip\Button::create(dgettext('MumieTask', 'Speichern')); ?>
    </div>
</form>