<?php
namespace mblode\sproutformstables\integrations\sproutforms\fields;
use Craft;
use craft\helpers\Template as TemplateHelper;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
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
     * @return string
     */
    public function getSvgIconPath()
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
        $value = json_decode($value, true);

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
    public function getExampleInputHtml()
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
    public function getFrontEndInputHtml($value, array $renderingOptions = null): string
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
    public function getTemplatesPath()
    {
        return Craft::getAlias('@mblode/sproutformstables/templates/_integrations/sproutforms/formtemplates/fields/');
    }


    public function normalizeValue($value, ElementInterface $element = null)
    {
        // String value when retrieved from db
        if (is_string($value)) {
            $tableArray = json_decode($value, true);

            $value = [];

            foreach($tableArray as $item) {
                $row = "";
                foreach($item as $key => $val) {
                    if (strlen($val) > 0) {
                        $row .= $key . ': ' . $val . ', ';
                    }
                }
                $row = substr($row, 0, -2);
                array_push($value, $row);
            }
        }

        return $value;
    }
}