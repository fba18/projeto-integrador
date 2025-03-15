<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDepositoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-local-deposito-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_local_deposito') ?>

    <?= $form->field($model, 'nome_deposito') ?>

    <?= $form->field($model, 'endereco_deposito') ?>

    <?= $form->field($model, 'uf') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
