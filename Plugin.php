<?php

namespace Kanboard\Plugin\CRProject;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;
use PicoDb\Table;

class Plugin extends Base
{
    /**
     * Method called for each request
     *
     * @access public
     */
    public function initialize()
    {
        $this->template->hook->attach('template:dashboard:page-header:menu', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:project-header:view-switcher', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:config:sidebar', 'CRProject:config/sidebar');
        $this->template->hook->attach('template:dashboard:sidebar', 'CRProject:dashboard/sidebar');

        // Remove all hidden projects on dashboard.
        $hiddenProjectIds = $this->projectHasStatusModel->getAllHiddenProjectsIds();
        $this->hook->on('pagination:dashboard:project:query', function (Table &$query) use ($hiddenProjectIds) {
            $query->notIn(ProjectModel::TABLE . '.id', $hiddenProjectIds);
        });
        $this->hook->on('pagination:dashboard:task:query', function (Table &$query) use ($hiddenProjectIds) {
            $query->notIn(ProjectModel::TABLE . '.id', $hiddenProjectIds);
        });
        $this->hook->on('pagination:dashboard:subtask:query', function (Table &$query) use ($hiddenProjectIds) {
            $query->notIn(ProjectModel::TABLE . '.id', $hiddenProjectIds);
        });
        $this->hook->on('model:subtask:count:query', function (Table &$query) use ($hiddenProjectIds) {
            $query->notIn(TaskModel::TABLE . '.project_id', $hiddenProjectIds);
        });
    }

    /**
     * On startup.
     */
    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    /**
     * Get classes.
     *
     * @return array
     */
    public function getClasses()
    {
        return array(
            'Plugin\CRProject\Model' => array(
                'ProjectStatusModel',
                'ProjectHasStatusModel'
            )
        );
    }

    /**
     * Get plugin name.
     *
     * @return string
     */
    public function getPluginName()
    {
        return basename(dirname(__FILE__));
    }

    /**
     * Get plugin description.
     *
     * @return string
     */
    public function getPluginDescription()
    {
        return t('Project status and visibility.');
    }

    /**
     * Get plugin author.
     *
     * @return string
     */
    public function getPluginAuthor()
    {
        return 'CoRex';
    }

    /**
     * Get plugin version.
     *
     * @return string
     */
    public function getPluginVersion()
    {
        return '1.0.0';
    }

    /**
     * Get plugin homepage.
     *
     * @return string
     */
    public function getPluginHomepage()
    {
        return 'https://github.com/corex/kanboard-plugin-crproject';
    }
}