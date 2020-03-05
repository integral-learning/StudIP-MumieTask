<h1><?=dgettext("MumieTaskPlugin","Authentifizierung");?></h1>
<section class="contentbox">

    <form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/authentication'); ?>"
        method="post">
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
    </form>
</section>