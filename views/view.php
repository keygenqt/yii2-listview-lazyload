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

/** @var \keygenqt\lazyLoad\ListView $widget */
/** @var string $list */

?>

<div id="listview-lazyLoad-<?= $widget->getId() ?>" class="yii2-listview-lazyload">

    <div class="cache"></div>

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-listview-lazyLoad-' . $widget->getId(), 'timeout' => '3000']) ?>
        <?= $list ?>
    <?php \yii\widgets\Pjax::end(); ?>

    <div class="lazy-load">
        <?= \yii\helpers\Html::img($widget->getBaseUrl() . '/images/ajax-loader.png') ?>
    </div>
</div>

<script>
    var update<?= $widget->getId() ?> = true,
        timeOut<?= $widget->getId() ?> = null,
        afterReplace<?= $widget->getId() ?> = <?= empty($widget->afterReplace) ? 'function() {}' : $widget->afterReplace->expression ?>

    function getPagination<?= $widget->getId() ?>() {
        var pag = $('#listview-lazyLoad-<?= $widget->getId() ?> .pagination'),
            laz = $('#listview-lazyLoad-<?= $widget->getId() ?> .lazy-load'),
            lastActive = $('.last.active').length;
        if (lastActive) {
            pag.remove();
            laz.remove();
            return null;
        }
        return pag;
    }

    $("<?= $widget->elScroll ?>").on('scroll', function() {
        if (update<?= $widget->getId() ?>) {
            var self = this;
            clearTimeout(timeOut<?= $widget->getId() ?>);
            timeOut<?= $widget->getId() ?> = setTimeout(function() {
                var pag = getPagination<?= $widget->getId() ?>();
                if (pag && pag.offset() !== undefined && (pag.offset().top - $(self).offset().top) < $(self).height()) {
                    $.pjax.reload({
                        container: '#<?= 'pjax-listview-lazyLoad-' . $widget->getId() ?>',
                        url: pag.find('.next a').attr('href'),
                        async: false,
                        replace: false
                    });
                }
            }, 200);
        }
    });
    $(document).on("pjax:beforeReplace", function() {
        var $block = $("#listview-lazyLoad-<?= $widget->getId() ?>");
        $block.find('.items').appendTo($block.find('.cache'));
        $block.find('.pagination').remove();
        update<?= $widget->getId() ?> = false;
    }).on("pjax:success", function() {
        var $block = $("#listview-lazyLoad-<?= $widget->getId() ?>");
        $('<?= $widget->elScroll ?>').scrollTop($block.find('.cache').height());
        getPagination<?= $widget->getId() ?>();
        update<?= $widget->getId() ?> = true;
        afterReplace<?= $widget->getId() ?>();
    });
    $(function () {
        $("<?= $widget->elScroll ?>").scroll();
        getPagination<?= $widget->getId() ?>();
    });
</script>
