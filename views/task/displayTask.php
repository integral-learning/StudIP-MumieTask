
<?php if($task->launch_container == 0) : ?>
    <a href=<?= PluginEngine::getLink("MumieTaskPlugin", array("task_id" => $task->task_id), 'task/launch'); ?> target="_blank" class="button">Launch</a>
<?php else : ?>
    <iframe  width = '90%' height= '100%' src=<?= PluginEngine::getLink("MumieTaskPlugin", array("task_id" => $task->task_id), 'task/launch'); ?> webkitallowfullscreen mozallowfullscreen allowfullscreen>
    </iframe>
<?php endif;?>