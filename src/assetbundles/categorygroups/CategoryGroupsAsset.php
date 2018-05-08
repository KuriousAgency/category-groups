<?php
/**
 * Category Groups plugin for Craft CMS 3.x
 *
 * Craft CMS category groups
 *
 * @link      https://kurious.agency
 * @copyright Copyright (c) 2018 Kurious Agency
 */

namespace kuriousagency\categorygroups\assetbundles\categorygroups;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Kurious Agency
 * @package   CategoryGroupPicker
 * @since     0.0.1
 */
class CategoryGroupsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@kuriousagency/categorygroups/assetbundles/categorygroups/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CategoryGroups.js',
        ];

        $this->css = [
            'css/CategoryGroups.css',
        ];

        parent::init();
    }
}
