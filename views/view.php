<?php

/** @var \keygenqt\lazyLoad\ListView $widget */
/** @var string $list */

?>

<div id="listview-lazyLoad-<?= $widget->getId() ?>" class="yii2-listview-lazyload">

    <div id="cache-<?= $widget->getId() ?>"></div>
    <div id="cache-bottom-<?= $widget->getId() ?>"></div>

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-listview-lazyLoad-' . $widget->getId(), 'timeout' => '3000']) ?>
        <?= $list ?>
    <?php \yii\widgets\Pjax::end(); ?>

    <div class="lazy-load">
        <?= \yii\helpers\Html::img($widget->getBaseUrl() . '/images/ajax-loader.png') ?>
    </div>
</div>

<script>
    var update = true;
    $("body").on('scroll', function() {
        if (update) {
            var pagination = $('.yii2-listview-lazyload .pagination');
            if (pagination.length) {
                if (pagination.offset().top < $(this).height()) {
                    var link = pagination.find('.next a');
                    if (link.length) {
                        var url = link.attr('href');
                        pagination.remove();
                        $(".yii2-listview-lazyload .items").appendTo("#cache-<?= $widget->getId() ?>");
                        $.pjax.reload({container: '#<?= 'pjax-listview-lazyLoad-' . $widget->getId() ?>', 'url': url, async: false, replace: false});
                    } else {
                        pagination.remove();
                        $('.lazy-load').remove();
                    }
                }
            } else {
                $('.lazy-load').remove();
            }
        }
    });
    $(document).on("pjax:beforeReplace", function() {
        update = false;
    });
    $(document).on("pjax:success", function() {
        $('body').scrollTop($('body').scrollTop() + $('#cache-bottom-<?= $widget->getId() ?>').offset().top + 17);
        update = true;
        updateForm();
    });
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    $(function () {
        $("body").scroll();
    });
</script>
