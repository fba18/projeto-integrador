<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoque $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-historico-entrada-estoque-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_local_deposito')->textInput() ?>

    <?= $form->field($model, 'id_estoque')->textInput() ?>

    <?= $form->field($model, 'num_produto')->textInput() ?>

    <?= $form->field($model, 'data_inclusao')->textInput() ?>

    <?= $form->field($model, 'qtd_inclusao')->textInput() ?>

    <?= $form->field($model, 'tipo_entrada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_local_deposito_anterior')->textInput() ?>

    <?= $form->field($model, 'id_usuario_inclusao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
