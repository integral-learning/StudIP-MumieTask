<form class="default" action="<?= $action; ?>" method="post">
    <label>
        <?= dgettext('MumieTask', 'Name') . ':'; ?>
        <input required type="text" name="name" value="<?= $name?>" placeholder="<?= dgettext('MumieTask', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>" >
    </label>
    <label>
        <?= dgettext('MumieTask', 'URL-Prefix') . ':'; ?>
        <input required type="text" name="url_prefix" value="<?= $url_prefix?>" placeholder="<?= dgettext('MumieTask', 'Geben Sie die URL des Servers ein'); ?>" >
    </label>
        <?= \Studip\Button::create(dgettext('MumieTask', 'Einfügen')); ?>
</form>

