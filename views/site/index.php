<?php

/* @var $this yii\web\View */
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Блог';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Блог!</h1>


    </div>

    <div class="body-content">

        <div class="row center-block " style="max-width: 600px;">
            <?php foreach($models as $item):?>
                <div class="col-lg-12">
                    <h2><a href="<?= Url::toRoute(['post','id'=>$item['id']])?>"><?= $item['title']?></a></h2>
                    <p><i>Создано: <?= date('d.m.Y H:i',$item['date'])?></i></p>
                    <div style="margin-bottom: 10px">
                        <img src="<?= Yii::$app->homeUrl; ?><?= $item['photo'] ? $item['photo'] : yii::$app->params['post_img']?>" alt="" width="100%">

                    </div>
                    <?= StringHelper::truncate($item['text'],250,'...');?>

                    <p><a class="btn btn-default" href="<?= Url::toRoute(['post','id'=>$item['id']])?>">Подробнее &raquo;</a></p>
                </div>
            <?php endforeach;?>
        </div>
        <div style="text-align: center">
        <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
        ?>
        </div>
    </div>
</div>
