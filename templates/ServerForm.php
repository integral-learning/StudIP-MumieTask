<style type="text/css">
    <?php include 'public/plugins_packages/integral-learning/MumieTaskPlugin/mumieStyle.css';
    ?>
</style>
<form class="default" action="<?= $action; ?>" method="post">
    <fieldset>
        <legend>
            <?= dgettext("MumieTaskPlugin", "MUMIE-Server"); ?>
        </legend>

        <div class="mumie_form_elem_wrapper">
            <label for="name">
                <span class="required">
                    <?=
                dgettext('MumieTaskPlugin', 'Name') . ': '
                ?>
                </span>
            </label>

            <input required type="text" name="name" value="<?= $name?>"
                placeholder="<?= dgettext('MumieTaskPlugin', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>">
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext('MumieTaskPlugin', 'Legen Sie einen Namen für die Server-Konfiguration fest')
                    ]
                )->asImg();
            ?>
        </div>
        <div class="mumie_form_elem_wrapper">
            <label for="url_prefix">
                <span class="required">
                    <?= dgettext('MumieTaskPlugin', 'URL-Prefix') . ':'; ?>
                </span>
            </label>
            <input required type="text" name="url_prefix" value="<?= $url_prefix?>"
                placeholder="<?= dgettext('MumieTaskPlugin', 'Geben Sie die URL des Servers ein'); ?>">
            <?=
                Icon::create(
                    'info',
                    'info',
                    [
                        'title' => dgettext("MumieTaskPlugin", "Bitte geben Sie die URL des MUMIE-Servers ein. Für jede URL kann nur ein Server in StudIP konfiguriert werden.")
                        ]
                )->asImg();
            ?>
        </div>
        <div>
            <?= \Studip\Button::create(dgettext('MumieTaskPlugin', 'Speichern')); ?>
            <div>
    </fieldset>
</form>