<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$src = Yii::$app->UrlManager->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <header>
        <?php
        if(Yii::$app->controller->id!='admin'):
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => ' خانه', 'url' => ['/site/index'],'options'=>['id'=>'home-li'],'linkOptions' => ['class' => 'glyphicon glyphicon-home']],
                
                ['label' => ' ثبت نام', 'url' => ['/site/register'],'options'=>['id'=>'reg-li'],'linkOptions' => ['class' => 'glyphicon glyphicon-plus']],
                Yii::$app->user->isGuest ? (
                    ['label' => ' ورود', 'url' => ['/site/login'],'options'=>['id'=>'log-li'],'linkOptions' => ['class' => 'glyphicon glyphicon-log-in']]
                ) : (
                     '<li><a href="'.$src.'/admin/index"><span class="glyphicon glyphicon-new-window"></span>&nbsp;ورود به پنل کاربری</a></li>'
                    .'<li>'
                    . Html::beginForm(['/site/logout'],'post',['id'=>'logout-li'])
                    . Html::submitButton('<span class="glyphicon glyphicon-log-out"></span>&nbsp;خروج&nbsp;(' . Yii::$app->user->identity->username . ')',['class' => 'btn btn-link logout'])
                    . Html::endForm()
                    . '</li>'

                ),
                ['label' => 'درباره ما', 'url' => ['/site/about']],
                ['label' => 'تماس با ما', 'url' => ['/site/contact']],
            ],
        ]);
         if(Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='index')
         echo Nav::widget([
            'options' => ['class' => 'navbar-nav  navbar-left'],
            'items' => [
                '<li><select id="change-city" class="form-control pull-left">
                   
                </select></li>'
            ],
        ]);
        NavBar::end();
        else:
             NavBar::begin([
            'brandLabel' => 'پنل کاربری',
            'brandUrl' => Yii::$app->homeUrl.'admin/index',
            'options' => [
                'class' => 'admin-nav navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => ' خانه','options'=>['id'=>'home-li'], 'url' => ['/site/index'],'linkOptions' => ['class' => 'glyphicon glyphicon-home']],
                
                ['label' => ' ثبت نام','options'=>['id'=>'reg-li'], 'url' => ['/site/register'],'linkOptions' => ['class' => 'glyphicon glyphicon-plus']],
                Yii::$app->user->isGuest ? (
                    ['label' => 'ورود', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        '<span class="glyphicon glyphicon-log-out"></span>&nbsp;خروج&nbsp;(' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'

                    )
            ],
        ]);
        NavBar::end();
        endif;
        ?>
        
    </header>
    <div class="container content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        <?= \bluezed\scrollTop\ScrollTop::widget() ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
