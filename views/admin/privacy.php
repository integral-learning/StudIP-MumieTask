<h1><?=dgettext("MumieTaskPlugin","Datenschutz");?></h1>
<section class="contentbox">
    <section>
        <form class="default" action="<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'admin/privacy'); ?>"
            method="post">
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
        </form>
    </section>
</section>