
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
            <? 
                $options = $collector->getServerOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> >
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'MUMIE-Kurs'); ?>
        <select name="course">
            <? 
                $options = $collector->getCourseOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> >
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'Sprache'); ?>
        <select name="language">
            <? 
                $options = $collector->getLangOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> >
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
        </select>
    </label>
    <label>
        <?= dgettext('MumieTask', 'MUMIE-Aufgabe'); ?>
        <select name="task_url">
            <? 
                $options = $collector->getTaskOptions();
                foreach (array_keys($options) as $key): 
            ?>
                <option value= <?= $key; ?> >
                    <?= $options[$key]; ?>
                </option>
 
            <? endforeach ?>
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

