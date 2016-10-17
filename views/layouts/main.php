<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php

// or for Noty
echo \lo\modules\noty\Wrapper::widget([
    'layerClass' => 'lo\modules\noty\layers\Growl',
]);

?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $items[] = ['label' => 'Главная', 'url' => ['/']];
    $items[] = ['label' => 'Пользователи', 'url' => ['/users'], 'visible' => Yii::$app->user->can('admin')];
    $items[] = ['label' => 'Новости', 'url' => ['/news-feed']];
    $items[] = ['label' => 'Настройки', 'url' => ['/settings'], 'visible' => Yii::$app->user->can('admin')];
    $items[] = [
        'label' => 'Уведомления',
        'url' => ['/notifications'],
        'items' => [
            [
                'label' => 'Шаблоны',
                'url' => ['/notifications/template'],
            ],
            [
                'label' => 'Рассылка',
                'url' => ['/users/send-notifications'],
            ],
        ],
        'visible' => Yii::$app->user->can('admin')
    ];


    if(Yii::$app->user->isGuest) {
        $items[] = ['label' => 'Войти', 'url' => ['/site/login']];
        $items[] = ['label' => 'Зарегистрироватся', 'url' => ['/site/signup']];
    }
    else {
        $items[] = ['label' => 'Профиль', 'url' => ['/users/profile']];
        $items[] = '<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выйти (' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link logout']). Html::endForm() . '</li>';

    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
