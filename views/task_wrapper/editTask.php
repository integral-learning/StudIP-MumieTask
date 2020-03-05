<h1><?= dgettext("MumieTaskPlugin", "MUMIE-Task bearbeiten"); ?></h1>
<br>
<?php

require_once('public/plugins_packages/integral-learning/MumieTaskPlugin/services/TaskOptionCollector.php');
$factory = new Flexi_TemplateFactory(PluginEngine::getPlugin('MumieTaskPlugin')->getPluginPath() . '/templates');
$template = $factory->open('TaskForm.php');
$collector = new TaskOptionCollector($structuredServers);
$collector->collect();
$template->set_attribute("serverStructure", $structuredServers);
$template->set_attribute("collector", $collector);
$template->set_attribute("name", $task->name);
$template->set_attribute("server", $task->server);
$template->set_attribute("mumie_course", $task->mumie_course);
$template->set_attribute("mumie_coursefile", $task->mumie_coursefile);
$template->set_attribute("task_url", MumieProblem::removeParamsFromUrl($task->task_url));
$template->set_attribute("launch_container", $task->launch_container);
$template->set_attribute("language", $task->language);
$template->set_attribute("duedate", $task->duedate);
$template->set_attribute("privategradepool", $task->privategradepool);
$template->set_attribute("passing_grade", $task->passing_grade);
/* The PluginEngine must be used here. 
   If it's called in the template MumieServer::find() will return an instance of stdClass and not MumieServer in the controller class. I don't know why
*/
$template->set_attribute('action', PluginEngine::getLink('MumieTaskPlugin', array('task_id' => $task["task_id"]), 'taskWrapper/editTask'));
echo $template->render();

?>