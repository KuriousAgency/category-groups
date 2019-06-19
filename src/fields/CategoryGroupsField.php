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
use kuriousagency\categorygroups\models\Group;

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
	public $sources;

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

        if ($value instanceof Group) {
			return $value;
		}

		if (is_string($value)) {
			$value = Json::decodeIfJson($value);
		}

		$model = new Group();
		$model->value = $value;

		return $model;

    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {         
		return parent::serializeValue($value->value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'category-groups/_components/fields/settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        $options = $this->getOptions(true);

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'category-groups/_components/fields/input',
            [
                'name' => $this->handle,
                'model' => $value,
                'field' => $this,
                'id' => $id,
                'options' => $options,
                'namespacedId' => $namespacedId,
            ]
        );
	}
	
	public function getOptions($filtered=false)
	{
		$categoryGroups = Craft::$app->categories->getAllGroups();
        $options = [];

        foreach($categoryGroups as $group) {
			if (!$filtered || ($filtered && ($this->sources == '*' || in_array($group->id, $this->sources)))) {
				$options[$group->id] = $group->name;
			}
		}
		
		return $options;
	}
}
