<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->registerJsFile('//cdn.ckeditor.com/4.9.1/standard/ckeditor.js'); //подключить ckeditor
$this->registerJs("editor1 = CKEDITOR.replace( 'Blog[text]' );  "); //ckeditor
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">
   <div class="col-md-8">
       <?php $form = ActiveForm::begin(); ?>

       <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'photo')->fileInput() ?>

       <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>



       <div class="form-group">
           <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
       </div>

       <?php ActiveForm::end(); ?>

   </div>
    <div class="col-md-4">

    <img src="<?= Yii::$app->homeUrl; ?><?= $model->photo?>" alt="" width="250">
    </div>
</div>
