<?php

namespace keygenqt\lazyLoad;

use \yii\web\AssetBundle;

/**
 * @author KeyGen <keygenqt@gmail.com>
 */
class ActiveAssets extends AssetBundle
{
	public $sourcePath = '@keygenqt/lazyLoad/assets';

	public $css = [
		'css/yii2-listview-lazyload.css'
	];
}
