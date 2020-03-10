<?php

require_once(__DIR__ . '/models/MumieServer.php');
require_once(__DIR__ . '/models/MumieTask.php');
require_once(__DIR__ . '/models/MumieHash.php');
require_once(__DIR__ . '/models/MumieGrade.php');

/**
 * MumieTaskPlugin is easy way to add content from MUMIE LMS to StudIP. It provides functionality for SSO and synchronizes grades from MUMIE with StudIP
 */
class MumieTaskPlugin extends StudIPPlugin implements SystemPlugin, StandardPlugin
{
    public function __construct()
    {
        global $perm;
        parent::__construct();
        if ($perm->have_perm('root')) {
            $config = new Navigation(dgettext("MumieTaskPlugin", 'MUMIE-Task'), PluginEngine::getLink($this, array(), 'admin'));
            $config->setURL(PluginEngine::getLink($this, array(), 'admin'));
            Navigation::addItem('/admin/config/mumie', $config);
        }
    }

    public function getInfoTemplate($course_id)
    {
    }

    public function getIconNavigation($course_id, $last_visit, $user_id)
    {
    }

    public function getTabNavigation($course_id)
    {
        $navigation = new Navigation(dgettext("MumieTaskPlugin", 'MUMIE-Task'), PluginEngine::getLink($this, array(), 'taskWrapper'));
        $navigation->setImage(Icon::create('assessment'));
        return [
            'mumietask' => $navigation
        ];
    }

    public function getMetadata()
    {
        $metadata = parent::getMetadata();
        return $metadata;
    }
}
