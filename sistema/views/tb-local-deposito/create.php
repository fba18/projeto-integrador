<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */

$this->title = Yii::t('app', 'Create Tb Local Deposito');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Local Depositos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-local-deposito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
