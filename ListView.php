<?php

namespace keygenqt\lazyLoad;

class ListView extends \yii\widgets\ListView
{
    public $emptyText;
    public $elScroll = 'body';
    public $afterReplace;

    private $_bundle;

    public function run()
    {
        $this->_bundle = ActiveAssets::register($this->getView());

        $this->emptyText = $this->emptyText ?
            ($this->emptyText . '<style>.yii2-listview-lazyload .lazy-load{display: none}</style>') :
            'Not found.<style>.yii2-listview-lazyload .lazy-load{display: none}</style>';

        ob_start();
        parent::run();
        $list = ob_get_contents();
        ob_end_clean();

        return $this->getView()->render('@keygenqt/lazyLoad/views/view', ['widget' => $this, 'list' => $list]);
    }

    public function getBaseUrl()
    {
        return $this->_bundle->baseUrl;
    }
}
