<?php
/*
 * Copyright 2020 Vitaliy Zarubin
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
