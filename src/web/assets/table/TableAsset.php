<?php
/**
 * @link      https://sprout.modulesdesign.com/
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license   http://sprout.modulesdesign.com/license
 */

namespace mblode\sproutformstables\web\assets\table;

use craft\web\AssetBundle;

class TableAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@mblode/sproutformstables/web/assets/table/dist';

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->css = [
            'css/table.css'
        ];

        parent::init();
    }
}
