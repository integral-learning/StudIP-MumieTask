<?php if ($task->launch_container == 0) : ?>
<section class="contentbox">
    <section>
        <header>
            <h1><?= dgettext("MumieTaskPlugin", "Inhalt") ?></h1>
        </header>
        <a href=<?= PluginEngine::getLink("MumieTaskPlugin", array("task_id" => $task->task_id), 'task/launch'); ?>
            target="_blank" class="button"><?=dgettext("MumieTaskPlugin", "Anzeigen");?></a>
    </section>
</section>
<?php else : ?>
<iframe width='90%' height='100%'
    src=<?= PluginEngine::getLink("MumieTaskPlugin", array("task_id" => $task->task_id), 'task/launch'); ?>
    webkitallowfullscreen mozallowfullscreen allowfullscreen>
</iframe>
<?php endif;?>