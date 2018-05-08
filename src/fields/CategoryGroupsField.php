<?php
/**
 * Category Groups plugin for Craft CMS 3.x
 *
 * Craft CMS category groups
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\categorygroups\fields;

use kuriousagency\categorygroups\CategoryGroups;
use kuriousagency\categorygroups\assetbundles\categorygroupsfieldfield\CategoryGroupsFieldFieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;
use craft\elements\Category;

/**
 * @author    Kurious Agency
 * @package   CategoryGroupPicker
 * @since     1.0.0
 */
class CategoryGroupsField extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('category-groups', 'Category Groups');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ]);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_INTEGER;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {

        // echo $value;
        // exit();

        $value = json_decode($value);
        
        if(is_int($value)) {
            $data['group'] = Craft::$app->categories->getGroupById($value);
            $data['categories'] = Category::find()->group($data['group']->handle);

            return $data;
           
        }    

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {         
        return parent::serializeValue($value['group']->id, $element);
    }

    /**
     * @inheritdoc
     */
    // public function getSettingsHtml()
    // {
    //     // Render the settings template
    //     return Craft::$app->getView()->renderTemplate(
    //         'category-groups/_components/fields/CategoryGroupsField_settings',
    //         [
    //             'field' => $this,
    //         ]
    //     );
    // }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        
        // craft::dd($value);

        // Register our asset bundle
        // Craft::$app->getView()->registerAssetBundle(CategoryGroupsFieldFieldAsset::class);

        // Get our id and namespace

        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        $categoryGroups = Craft::$app->categories->getAllGroups();
        $options = [];

        foreach($categoryGroups as $group) {
            $options[$group->id] = $group->name;
        }

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').CategoryGroupsCategoryGroupsField(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'category-groups/_components/fields/CategoryGroupsField_input',
            [
                'name' => $this->handle,
                'value' => $value ? $value['group']->id : "",
                'field' => $this,
                'id' => $id,
                'options' => $options,
                'namespacedId' => $namespacedId,
            ]
        );
    }
}
