<?php
/**
 * Category Groups plugin for Craft CMS 3.x
 *
 * Craft CMS category groups
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\categorygroups\models;

use kuriousagency\categorygroups\CategoryGroups;

use Craft;
use craft\base\Model;
use craft\base\ElementInterface;
use craft\elements\Category as CraftCategory;
use craft\helpers\Json;
use craft\validators\ArrayValidator;


class Group extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
	public $value;

	private $_element;

    // Public Methods
    // =========================================================================

	public function getElement()
	{
		if (!$this->_element) {
			if ($this->value){
				$this->_element = Craft::$app->getCategories()->getGroupById((int) $this->value);
			}
		}
		return $this->_element;
	}

	public function getItems($criteria = null)
	{
		$query = CraftCategory::find();
		$query->groupId = $this->value;

		if ($criteria) {
			Craft::configure($query, $criteria);
		}
		return $query;
	}

}
