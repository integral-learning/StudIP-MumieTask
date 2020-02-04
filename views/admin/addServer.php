<form class="default" action="<?= PluginEngine::getLink("MumieTask", array(), 'admin/addServer'); ?>" method="post">
    <label>
        <?= dgettext('MumieTask', 'Name') . ':'; ?>
        <input type="text" name="name" value="" placeholder="<?= dgettext('MumieTask', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>" >
    </label>
    <label>
        <?= dgettext('MumieTask', 'URL-Prefix') . ':'; ?>
        <input type="text" name="url_prefix" value="" placeholder="<?= dgettext('MumieTask', 'Geben Sie die URL des Servers ein'); ?>" >
    </label>
        <?= \Studip\Button::create(dgettext('MumieTask', 'Einfügen')); ?>
</form>