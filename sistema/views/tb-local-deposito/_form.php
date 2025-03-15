<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-local-deposito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome_deposito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endereco_deposito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
