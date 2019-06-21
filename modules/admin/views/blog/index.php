<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->settings()['title']; // Заголовок из модел
$get = Yii::$app->request->get('Blog'); // Сокращение для формы поиска



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
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">

                    Посты

                    <?php
                    // Если есть права на добавление
                    if($model->settings()['isAdd']) {
                        echo '<a href="'.Url::Toroute('blog/form').'" class="btn btn-xs green">Добавить <i class="fa fa-plus"></i></a>';
                    }
                    ?>
                </div>

            </div>
            <div class="portlet-body">
                <div class="row">

                </div>
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <?php foreach ($model->showInTable() as $th){ ?>
                                <th><?=$model->attributeLabels()[$th]?></th>
                            <?php } ?>
                            <?php if($model->settings()['isAdd'] or $model->settings()['isDel']){ ?><th>-</th><?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows['rows'] as $r){ ?>
                            <tr>
                                <?php foreach ($model->showInTable() as $th){ ?>
                                    <td><?=$model->replace_field($th,$r[$th])?></td>
                                <?php } ?>
                                <td>
                                    <?php if($model->settings()['isEdit']){ ?>
                                        <a href="<?=Url::Toroute(['blog/edit', 'id'=>$r['id']])?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i> Редактировать</a>
                                    <?php } ?>

                                    <?php if($model->settings()['isDel']){ ?>
                                        <a href="<?=Url::Toroute(['blog/delete', 'id'=>$r['id']])?>" class="btn default btn-xs black"><i class="fa fa-trash-o"></i> Удалить</a>
                                    <?php  } ?>

                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>



                </div>
                <?=$rows['p_html']?>
            </div>
        </div>
    </div>
