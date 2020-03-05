<form class="default" action="<?= $action; ?>" method="post">
    <label>
        <?= dgettext('MumieTaskPlugin', 'Name') . ':'; ?>
        <input required type="text" name="name" value="<?= $name?>" placeholder="<?= dgettext('MumieTaskPlugin', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>" >
    </label>
    <label>
        <?= dgettext('MumieTaskPlugin', 'URL-Prefix') . ':'; ?>
        <input required type="text" name="url_prefix" value="<?= $url_prefix?>" placeholder="<?= dgettext('MumieTaskPlugin', 'Geben Sie die URL des Servers ein'); ?>" >
    </label>
        <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
</form>

