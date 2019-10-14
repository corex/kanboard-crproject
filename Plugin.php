<?php

namespace Kanboard\Plugin\CRProject;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\CRProject\Helper\Factory;
use Pimple\Container;

class Plugin extends Base
{
    /**
     * Method called for each request
     *
     * @access public
     */
    public function initialize()
    {
        // Setup routes.
        $this->route->addRoute('/crproject/dashboard', 'DashboardController', 'show', 'CRProject');
        $this->route->addRoute('/crproject/dashboard/:status_show_id', 'DashboardController', 'show', 'CRProject');
        $this->route->addRoute('/crproject/dashboard/visibility/:project_id/:status_show_id', 'DashboardController', 'visibility', 'CRProject');
        $this->route->addRoute('/crproject/dashboard/status/:project_id/:status_id/:status_show_id', 'DashboardController', 'status', 'CRProject');
        $this->route->addRoute('/crproject/dashboard/platform/:project_id/:platform_id/:status_show_id', 'DashboardController', 'platform', 'CRProject');
        $this->route->addRoute('/crproject/dashboard/focus/:project_id/:status_show_id', 'DashboardController', 'focus', 'CRProject');
        $this->route->addRoute('/crproject/status', 'ConfigStatusController', 'show', 'CRProject');
        $this->route->addRoute('/crproject/platform', 'ConfigPlatformController', 'show', 'CRProject');

        // Setup templates.
        $this->template->hook->attach('template:dashboard:page-header:menu', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:project-header:view-switcher', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:project-list:menu:after', 'CRProject:dashboard/menu');
        $this->template->hook->attach('template:config:sidebar', 'CRProject:config/sidebar');
        $this->template->hook->attach('template:config:application', 'CRProject:application/settings');

        // Redirect to Project Dashboard.
        $this->on('app.bootstrap', function (Container $container) {
            $configModel = $container['configModel'];
            $helper = $container['helper'];
            $url = $helper->url;

            // If default dashboard, override uri.
            $isDefaultDashboard = $configModel->get('crproject_default_dashboard') == 1;
            if ($isDefaultDashboard) {
                $request = Factory::request();

                // If api call, do not redirect.
                if ($request->uri() == '/jsonrpc.php') {
                    return;
                }

                $controller = $request->controller();
                $action = $request->action();
                $plugin = $request->plugin();
                if (($controller == 'DashboardController' && $action == 'show' && $plugin == '')
                    || ($controller == '' && $action == '' && $plugin == '')) {
                    $redirectUrl = $url->href('DashboardController', 'show', array('plugin' => 'CRProject'));
                    header('Location: ' . $redirectUrl);
                    die();
                }
            }
        });
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
                'ProjectPlatformModel'
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
        return 'https://github.com/corex/kanboard-crproject';
    }
}