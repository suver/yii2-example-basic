<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\newsFeed\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Новости');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новости'), 'url' => ['/news-feed/default/index']];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\newsFeed\assets\AppAsset::register($this);
?>
<div class="news-feed-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-header">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php if(Yii::$app->user->can('createNews')) { ?>
                <?= Html::a(Yii::t('app', 'Добавить новость'), \yii\helpers\ArrayHelper::merge(['create'],Yii::$app->request->get()), ['class' => 'btn btn-success']) ?>
            <?php } ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        Записей на странице
                        <a href="<?php echo \yii\helpers\Url::to(['/news-feed', 'per-page'=>1]) ?>">1</a> |
                        <a href="<?php echo \yii\helpers\Url::to(['/news-feed', 'per-page'=>2]) ?>">2</a> |
                        <a href="<?php echo \yii\helpers\Url::to(['/news-feed', 'per-page'=>5]) ?>">5</a> |
                        <a href="<?php echo \yii\helpers\Url::to(['/news-feed', 'per-page'=>10]) ?>">10</a> |
                        <a href="<?php echo \yii\helpers\Url::to(['/news-feed', 'per-page'=>15]) ?>">15</a> |
                        <a href="<?php echo \yii\helpers\Url::to(['/news-feed', 'per-page'=>25]) ?>">25</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <?php Pjax::begin(); ?>
                        <?php $widget = $module->listViewWidget;
                        echo $widget::widget([
                            'dataProvider' => $dataProvider,
                            'itemView' => '_item',
                            'emptyText' => 'Новостей не добавлено',
                            'layout' => '{items}<div class="row"><div class="col-sm-5">{summary}</div><div class="col-sm-7">{pager}</div></div>',
                            'summary' => 'Показано <b>{begin, number}-{end, number}</b> из <b>{totalCount, number}</b> {totalCount, plural, one{запись} other{записей}}',
                            'viewParams' => [
                                'fullNews' => false,
                            ],
                        ]); ?>
                        <?php Pjax::end(); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>
