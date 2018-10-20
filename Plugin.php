<?php

namespace Kanboard\Plugin\CRProject;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;
use Kanboard\Plugin\CRProject\Helper\Factory;
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
        $colors = $this->configTaskColorModel->getOptions();

        // Setup templates.
        $this->template->hook->attach('template:dashboard:page-header:menu', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:project-header:view-switcher', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:config:sidebar', 'CRProject:config/sidebar');
        $this->template->hook->attach('template:dashboard:sidebar', 'CRProject:dashboard/sidebar');
        $this->template->hook->attach('template:project:header:after', 'CRProject:dashboard/colors', array(
            'colors' => $colors
        ));

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

        // Modify list of colors.
        $this->hook->on('model:color:get-list', function (&$listing) use ($colors) {
            if (count($colors) == 0) {
                return;
            }
            if (Factory::request()->controller() == 'TaskModificationController') {
                $listing = $colors;
            }
        });

        // Setup routes.
        $this->route->addRoute('/crproject/dashboard', 'DashboardController', 'show', 'CRProject');
        $this->route->addRoute('/crproject/dashboard/:status_show_id', 'DashboardController', 'show', 'CRProject');
        $this->route->addRoute('/crproject/status', 'ConfigStatusController', 'show', 'CRProject');
        $this->route->addRoute('/crproject/task/color', 'ConfigTaskColorController', 'show', 'CRProject');
    }

    /**
     * On startup.
     */
    public function onStartup()
    {
        Factory::setContainer($this->container);
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
                'ProjectHasStatusModel',
                'ConfigTaskColorModel'
            ),
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