<?php
/**
 * Category Group Picker plugin for Craft CMS 3.x
 *
 * Craft CMS category group picker
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\categorygrouppicker\assetbundles\categorygrouppickerfieldfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Kurious Agency
 * @package   CategoryGroupPicker
 * @since     1.0.0
 */
class CategoryGroupPickerFieldFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@kuriousagency/categorygrouppicker/assetbundles/categorygrouppickerfieldfield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CategoryGroupPickerField.js',
        ];

        $this->css = [
            'css/CategoryGroupPickerField.css',
        ];

        parent::init();
    }
}
