<?php

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Настройки сайта');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="settings-default-index">

    <div class="box">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'settings-form',
                            'options' => [
                                'data' => [
                                    'pjax' => true
                                ],
                            ],
                        ]) ?>

                        <?= $form->field($model, 'siteName')->textInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>


</div>
