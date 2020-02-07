<form class="default" action="<?= $action; ?>" method="post">
    <label>
        <span class="required">
            <?= dgettext('MumieTask', 'Name'); ?>
        </span> 
        <input required type="text" name="name" value="<?= $name?>" placeholder="<?= dgettext('MumieTask', 'Legen Sie einen Namen für die Server-Konfiguration fest'); ?>" >
    </label>
    <label>
        <span class="required">
            <?= dgettext('MumieTask', 'MUMIE-Server'); ?>
        </span> 
        <select name="server">
            <option value="asd">asd</option>
            <option value="qwe">qwe</option>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'MUMIE-Kurs'); ?>
        <select name="course">
            <option value="course1">course1</option>
            <option value="course2">course2</option>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'Sprache'); ?>
        <select name="language">
            <option value="sprache1">sprache1</option>
            <option value="sprache2">sprache2</option>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'MUMIE-Aufgabe'); ?>
        <select name="task_url">
            <option value="https://www.google.de">problem1</option>
            <option value="https://www.ombplus.de/ombplus/link/ElemenRechneMengenZahlen/Schlus">OMB+</option>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'Startcontainer'); ?>
        <select name="launch_container">
            <option value="1">Eingebunden</option>
            <option value="0">Neuer Browser-Tab</option>
        </select>
    </label>
        <?= \Studip\Button::create(dgettext('MumieTask', 'Einfügen')); ?>
</form>

