<h1>Admininstrator-Einstellungen für MUMIE-Task</h1>
<h2>Datenschutz</h2>
<form class="default" action="<?= PluginEngine::getLink("MumieTask", array(), 'admin/privacy'); ?>" method="post">
<table>
    <tr>
        <td>
            <label for="mumie_share_firstname">
                <?= dgettext('MumieTask', 'Vornamen teilen') . ':'; ?>
            </label>
        </td>
        <td>
            <input type="checkbox" id="mumie_share_firstname" name="share_firstname" <?= Config::get()->MUMIE_SHARE_FIRSTNAME ? "checked" : "";?> placeholder="<?= dgettext('MumieTask', 'Bestimmen Sie, ob Sie den Vornamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>" >
        </td>
    </tr>
    <tr>
        <td>
            <label for="mumie_share_lastname">
                <?= dgettext('MumieTask', 'Nachnamen teilen') . ':'; ?>
            </label>
        </td>
        <td>
            <input type="checkbox" name="share_lastname" id="mumie_share_lastname" <?= Config::get()->MUMIE_SHARE_LASTNAME ? "checked" : "";?> placeholder="<?= dgettext('MumieTask', 'Bestimmen Sie, ob Sie den Nachnamen der Nutzer mit MUMIE-Servern teilen wollen'); ?>" >
        </td>
    </tr>
    <tr>
        <td>
            <label for="mumie_share_email">
                <?= dgettext('MumieTask', 'E-Mai-Addresse teilen') . ':'; ?>
            </label>
        </td>
        <td>
            <input type="checkbox" id="mumie_share_lastname" name="share_email" <?= Config::get()->MUMIE_SHARE_EMAIL ? "checked" : "";?> placeholder="<?= dgettext('MumieTask', 'Bestimmen Sie, ob Sie die E-Mail-Addresse der Nutzer mit MUMIE-Servern teilen wollen'); ?>" >
        </td>
    <tr>
</table>
    <div data-dialog-button>
        <?= \Studip\Button::create(dgettext('MumieTask', 'Speichern')); ?>
    </div>
</form>