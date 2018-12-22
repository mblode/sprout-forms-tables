<?php
/**
 * Tables Field for Sprout Forms for Craft CMS 3.x
 *
 * Custom Tables field for Sprout Forms plugin
 *
 * @link      https://matthewblode.com/
 * @copyright Copyright (c) 2018 Matthew Blode
 */

namespace mblode\sproutformstables;

use mblode\sproutformstables\integrations\sproutforms\fields\Table;
use mblode\sproutformstables\models\Settings;

use barrelstrength\sproutforms\services\Fields;
use barrelstrength\sproutforms\events\RegisterFieldsEvent;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\i18n\PhpMessageSource;

use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * @property  Settings    $settings
 * @method    Settings getSettings()
 */
class SproutFormsTables extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * SproutFormsTables::$plugin
     *
     * @var SproutFormsTables
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@mblode/sproutformstables', $this->getBasePath());
        $this->controllerNamespace = 'mblode\sproutformstables\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@mblode/sproutformstables/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::setAlias('@sproutformstablesicons', $this->getBasePath().'/web/icons');

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELDS, function(RegisterFieldsEvent $event) {
            $event->fields[] = new Table();
        });

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        Craft::info(
            Craft::t(
                'sprout-forms-tables',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }
    /**
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate('sprout-forms-tables/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
