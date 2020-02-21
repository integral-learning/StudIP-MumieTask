<h1>TASKS INDEX</h1>

<table class="default">
    <tr>
        <th><?=dgettext("MumieTask", "MUMIE-Task"); ?>
        <th><?=dgettext("MumieTask", "Abgabefrist"); ?>
        <th><?=dgettext("MumieTask", "Punkte"); ?>
        <th><?=dgettext("MumieTask", "Bestanden"); ?>
        <?php if ($hasTeacherPermission): ?>
        <th><?=dgettext("MumieTask", "Bearbeiten"); ?>
        <th><?=dgettext("MumieTask", "Löschen"); ?>
        <?php endif ?>
    </tr>

    <? foreach ($tasks as $task) : ?>
        <tr>
            <td>
                <a href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]),'task/displayTask'); ?>">
                    <?= htmlReady($task['name']); ?>
                </a>
            </td>
            <td>
                <?= $task["duedate"]; ?>
            </td>
            <td>
            <?php
                $points = MumieGrade::getGradeForUser($task["task_id"], \Context::getId())->points;
                $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
                $template = $factory->open('grade.php');
                $template->set_attribute('points', $points);
                echo $template->render();
            ?>        
            </td>
            <td>
            <?= $points >= $task["passing_grade"] ? Icon::create('check-circle', 'status-green') : Icon::create('decline',  'status-red') ?>
            </td>
            <?php if ($hasTeacherPermission): ?>
            <td>
                <a href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]),'task/editTask'); ?>">
                        <?= Icon::create('edit', 'clickable')->asImg('20px'); ?>
                </a>
            </td>
            <td>
                <a href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]),'task/deleteTask'); ?>">
                    <?= Icon::create('trash', 'clickable')->asImg('20px'); ?>
                </a>
            </td>
            <?php endif ?>
        </tr>
    <? endforeach ?>
</table>
<?php if ($hasTeacherPermission): ?>
    <a href=<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'task/addTask'); ?> class="button">Neue MUMIE-Task hinzufügen</a>
<?php endif ?>