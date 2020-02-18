<h1>TASKS INDEX</h1>

<table class="default">
    <? foreach ($tasks as $task) : ?>
        <tr>
            <td>
                <a href="<?= PluginEngine::getLink("MumieTaskPlugin", array('task_id' => $task["task_id"]),'task/displayTask'); ?>">
                    <?= htmlReady($task['name']); ?>
                </a>
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