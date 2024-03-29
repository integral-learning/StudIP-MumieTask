<table class="default">
    <tr>
        <th><?=dgettext("MumieTaskPlugin", "MUMIE-Task"); ?></th>
        <th><?=dgettext("MumieTaskPlugin", "Abgabefrist"); ?></th>
        <?php if ($hasTeacherPermission): ?>
        <th><?=dgettext("MumieTaskPlugin", "Bearbeiten"); ?></th>
        <th><?=dgettext("MumieTaskPlugin", "Löschen"); ?></th>
        <?php else : ?>
        <th><?=dgettext("MumieTaskPlugin", "Punkte"); ?></th>
        <th><?=dgettext("MumieTaskPlugin", "Bestanden"); ?></th>
        <?php endif ?>
    </tr>

    <?php foreach ($tasks as $task) : ?>
    <tr>
        <td>
            <a href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]), 'task'); ?>">
                <?= htmlReady($task['name']); ?>
            </a>
        </td>
        <td>
            <?= $task["duedate"] == 0 ? "-" : date('d.m.Y H:i', $task["duedate"]); ?>
        </td>
        <?php if ($hasTeacherPermission): ?>
        <td>
            <a
                href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]), 'taskWrapper/editTask'); ?>">
                <?= Icon::create('edit', 'clickable')->asImg('20px'); ?>
            </a>
        </td>
        <td>
            <a
                href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]), 'taskWrapper/deleteTask'); ?>">
                <?= Icon::create('trash', 'clickable')->asImg('20px'); ?>
            </a>
        </td>
        <?php else: ?>
        <td>
            <?php
                $points = MumieGrade::getGradeForUser($task["task_id"], $GLOBALS['user']->id)->points;
                $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
                $template = $factory->open('grade.php');
                $template->set_attribute('points', $points);
                echo $template->render();
            ?>
        </td>
        <td>
            <?php if($task['is_graded'] == 1): ?>
                <?= $points >= $task["passing_grade"] ? Icon::create('check-circle', 'status-green') : Icon::create('decline', 'status-red') ?>
            <?php endif ?>
            <?php if($task['is_graded'] == 0): ?>
                -
            <?php endif ?>
        </td>
        <?php endif ?>
    </tr>
    <?php endforeach ?>
</table>
<?php if ($hasTeacherPermission): ?>
<a href=<?= PluginEngine::getLink("MumieTaskPlugin", array(), 'taskWrapper/addTask'); ?> class="button"><?= dgettext("MumieTaskPlugin", "MUMIE-Task
    hinzufügen");?></a>
<?php endif ?>
