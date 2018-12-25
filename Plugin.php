<?php

namespace Kanboard\Plugin\CRTask;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\CRTask\Helper\Factory;

class Plugin extends Base
{
    /**
     * Method called for each request
     *
     * @access public
     */
    public function initialize()
    {
        $colors = $this->taskColorModel->getOptions();

        // Setup routes.
        $this->route->addRoute('/settings/crtask/color', 'TaskColorController', 'show', 'CRTask');

        // Setup templates.
        $this->template->hook->attach('template:config:sidebar', 'CRTask:config/sidebar');
        $this->template->hook->attach('template:project:header:after', 'CRTask:dashboard/colors', array(
            'colors' => $colors
        ));

        // Modify list of colors.
        $this->hook->on('model:color:get-list', function (&$listing) use ($colors) {
            if (count($colors) == 0) {
                return;
            }
            $controller = Factory::request()->controller();
            if (in_array($controller, array('TaskCreationController', 'TaskModificationController'))) {
                $listing = $colors;
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
            'Plugin\CRTask\Model' => array(
                'TaskColorModel'
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
        return t('Task visibility.');
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
        return 'https://github.com/corex/kanboard-crtask';
    }
}