<?php
/**
 * @author <sergmoro1@ya.ru>
 * @license GPL
 */

namespace sergmoro1\modal\assets;

use yii\web\AssetBundle;

class PopUpAsset extends AssetBundle
{
    public $sourcePath = '@vendor/sergmoro1/yii2-modal-crud/src/assets';
    public $css = [
    ];
    public $js = [
        'js/popUp.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
