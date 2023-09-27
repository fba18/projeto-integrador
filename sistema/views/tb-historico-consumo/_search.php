<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-historico-consumo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_consumo') ?>

    <?= $form->field($model, 'id_estoque') ?>

    <?= $form->field($model, 'id_num_produto') ?>

    <?= $form->field($model, 'id_cliente_cpf_cnpj') ?>

    <?= $form->field($model, 'qtd_consumida') ?>

    <?php // echo $form->field($model, 'data_consumo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
