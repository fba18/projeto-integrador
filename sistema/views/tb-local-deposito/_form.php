<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-local-deposito-form">

    <?php $form = ActiveForm::begin(); ?>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                <h4>&nbspInformações Depósito:</h4>
                                </h3>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                <div class="container-fluid w-auto row">
                                    <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'nome_deposito')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'endereco_deposito')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'uf')->textInput(['maxlength' => true])->label('UF') ?>
                                    </div>
                                    <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <div class="mt-4 form-group">
                                            <?= Html::submitButton(Yii::t('app', 'Salvar'), ['class' => 'btn btn-success btm-sm']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php ActiveForm::end(); ?>

</div>
