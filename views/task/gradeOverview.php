<h1>OVERVIEW</h1>

<table class="default">
    <tr>
        <th>
            <?= dgettext("MumiePlugin", "Nutzer"); ?>
        </th>
        <th>
            <?=dgettext("MumieTask", "Punkte"); ?>
        </th>
        <th>
            <?=dgettext("MumieTask", "Bestanden"); ?>
        </th>
    </tr>
    <? foreach($grades as $grade): ?>
    <tr>
        <td>
            <?= $grade["Nachname"] .", " .$grade["Vorname"];?>
        </td>
        <td>
            <?php
                $factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
                $template = $factory->open('grade.php');
                $template->set_attribute('points', $grade["points"]);
                echo $template->render();
            ?>
        </td>
        <td>
            <?= $grade["points"] >= $task["passing_grade"] ? Icon::create('check-circle', 'status-green') : Icon::create('decline',  'status-red') ?>

        </td>
    </tr>
    <? endforeach ?>
</table>