<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\newsFeed\models\News */

$this->title = Yii::t('app', 'Редактировать');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новостная лента'), 'url' => ['/news-feed/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новости'), 'url' => \yii\helpers\ArrayHelper::merge(['/news-feed/default/index'],Yii::$app->request->get())];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/news-feed/default/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\newsFeed\assets\AppAsset::register($this);
?>
<div class="news-feed-update">

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

                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>
