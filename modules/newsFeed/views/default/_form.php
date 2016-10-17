<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\newsFeed\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-feed-form">

    <?php $form = ActiveForm::begin(); ?>

    <img src="<?php echo $model->linkedFile('cover')->thumbnail('medium')->byDefault('/images/default-author.jpg')?>" class="img-circle" width="256" height="256">

    <?php echo $form->field($model, 'cover')->fileInput() ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->widget(\suver\editor\Editor::className(), []); ?>

    <?php echo $form->field($model, 'body')->widget(\suver\editor\Editor::className(), []); ?>

    <?php // echo $form->field($model, 'params')->textarea(['rows' => 6]) ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Сохранить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
