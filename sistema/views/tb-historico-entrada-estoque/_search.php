<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoqueSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-historico-entrada-estoque-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_historico_entrada_estoque') ?>

    <?= $form->field($model, 'id_local_deposito') ?>

    <?= $form->field($model, 'id_estoque') ?>

    <?= $form->field($model, 'num_produto') ?>

    <?= $form->field($model, 'data_inclusao') ?>

    <?php // echo $form->field($model, 'qtd_inclusao') ?>

    <?php // echo $form->field($model, 'tipo_entrada') ?>

    <?php // echo $form->field($model, 'id_local_deposito_anterior') ?>

    <?php // echo $form->field($model, 'id_usuario_inclusao') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
