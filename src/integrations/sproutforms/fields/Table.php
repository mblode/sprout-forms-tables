<?php
namespace mblode\sproutformstables\integrations\sproutforms\fields;
use Craft;
use craft\helpers\Template as TemplateHelper;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;
use barrelstrength\sproutforms\base\FormField;
/**
 * Class Table
 *
 * @package Craft
 */
class Table extends FormField implements PreviewableFieldInterface
{
    /**
     * @var string
     */
    public $cssClasses;

    /**
     * @var int|null
     */
    public $cols;

     /**
     * @var int|null The size of the field
     */
    public $size = 1;

    /**
     * @var string|null
     */
    public $titleText;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-forms-tables', 'Table');
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @return string
     */
    public function getSvgIconPath(): string
    {
        return '@sproutformstablesicons/table.svg';
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        $rendered = Craft::$app->getView()->renderTemplate(
            'sprout-forms-tables/_integrations/sproutforms/formtemplates/fields/table/settings',
            [
                'field' => $this
            ]
        );
        return $rendered;
    }

    /**
     * @@inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $settings = Craft::$app->getPlugins()->getPlugin('sprout-forms-tables')->getSettings();

        if (!$settings->decodeValue) {
            $value = json_decode($value, true);
        }

        return Craft::$app->getView()->renderTemplate('sprout-forms-tables/_integrations/sproutforms/formtemplates/fields/table/cpinput',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'size' => $this->size
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getExampleInputHtml(): string
    {
        return Craft::$app->getView()->renderTemplate('sprout-forms-tables/_integrations/sproutforms/formtemplates/fields/table/example',
            [
                'field' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getFrontEndInputHtml($value, array $renderingOptions = null): \Twig_Markup
    {
        $rendered = Craft::$app->getView()->renderTemplate(
            'table/input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'renderingOptions' => $renderingOptions
            ]
        );
        return TemplateHelper::raw($rendered);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['size'], 'integer'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getTemplatesPath(): string
    {
        return Craft::getAlias('@mblode/sproutformstables/templates/_integrations/sproutforms/formtemplates/fields/');
    }

    public function normalizeValue($value, ElementInterface $element = null)
    {
        // String value when retrieved from db
        if (is_string($value)) {
            $settings = Craft::$app->getPlugins()->getPlugin('sprout-forms-tables')->getSettings();

            if ($settings->decodeValue) {
                $value = json_decode($value, true);
            }
        }

        return $value;
    }
}
