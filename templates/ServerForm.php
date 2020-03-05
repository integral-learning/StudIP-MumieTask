<style type="text/css">
    <?php include 'public/plugins_packages/integral-learning/MumieTaskPlugin/mumieStyle.css';
    ?>
</style>
<form class="default" action="<?= $action; ?>" method="post">
    <fieldset>
        <legend>
            <?= dgettext("MumieTaskPlugin", "MUMIE-Server"); ?>
        </legend>
        <label for="name">
            <?= dgettext('MumieTaskPlugin', 'Name') . ':'; ?>
        </label>
        <input required type="text" name="name" value="<?= $name?>"
            placeholder="<?= dgettext('MumieTaskPlugin', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>">
        <div class="mumie_form_desc">
            <?=dgettext("MumieTaskPlugin","Bitte wählen Sie einen eindeutigen Namen für diese Konfiguration!"); ?>
        </div>
        <label for="url_prefix">
            <?= dgettext('MumieTaskPlugin', 'URL-Prefix') . ':'; ?>
        </label>
        <input required type="text" name="url_prefix" value="<?= $url_prefix?>"
            placeholder="<?= dgettext('MumieTaskPlugin', 'Geben Sie die URL des Servers ein'); ?>">
        <div class="mumie_form_desc">
            <?=dgettext("MumieTaskPlugin","Bitte geben Sie die URL des MUMIE-Servers ein. Für jede URL kann nur ein Server in StudIP konfiguriert werden."); ?>
        </div>
        <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
    </fieldset>
</form>