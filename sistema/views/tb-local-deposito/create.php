<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */

$this->title = Yii::t('app', 'Criar Deposito');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locais Depósitos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-local-deposito-create">

    <!--h1>< ?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
