<?php

/* @var $this yii\web\View */
use yii\helpers\StringHelper;

$this->title = $model->title;

?>
<style>

    .wrap {
        min-height: 100%;
        height: auto;
        margin: 0 auto -60px;
        padding: 0 0 60px;
        position: relative;
    }
    .footer {
        height: 60px;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        padding-top: 20px;
        position: absolute;
        width: 100%;
        bottom: 0;
        left: 0;
    }

</style>
<div class="site-index">

    <div class="jumbotron">
        <h1>Блог!</h1>


    </div>

    <div class="body-content">
        <div class="row">
<!--            <div class="col-lg-5">-->
<!--                <img src="" style="width:100%">-->
<!--                <div/>-->
<!--                <div>-->
<!--                    Длинный текст-->
<!--                </div>-->
<!--            </div>-->
        <div class="wrap-post ">
            <div class="row">
                <div class="post-head">
                    <h2><?= $model->title?></h2>
                    <p><i>Создано: <?= date('d.m.Y H:i',$item->date)?></i></p>
                </div>
                <div class="col-lg-5">

                        <img style="width:100%" src="<?= Yii::$app->homeUrl; ?><?= $model->photo ? $model->photo : yii::$app->params['post_img']?>" alt="" >
                </div>

                <?= $model->text?>

            </div>
                <p style="margin: 20px 0">
                    <a href="<?= \yii\helpers\Url::previous()?>" class="btn btn-default">Назад</a>
                </p>
        </div>

    </div>
</div>
