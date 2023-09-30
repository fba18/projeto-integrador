<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TbCliente;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\models\TbClienteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tb-cliente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index-consumo'],
        'method' => 'get',
    ]); ?>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                <i class="fas fa-search fa-fw"></i>
                                <h4> Consultar Cliente </h4>
                                </h3>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">

                                <div class="container-fluid w-auto row">
                                    <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'cpf_cnpj')->widget(MaskedInput::class, [
                                                'mask' => ['999.999.999-99', '99.999.999/9999-99'], // Define as máscaras para CPF e CNPJ
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true, // Remove a máscara antes de enviar o formulário
                                                ],
                                            ])->textInput(['maxlength' => true])->label("CPF / CNPJ") ?>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'nome')->label("Nome Cliente") ?>
                                    </div>

                                </div>
                                <div class="container-fluid w-auto row form-group">
                                    <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6 btn-sm">
                                        <?php //Html::a('Cadastrar Cliente', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                                        <?= Html::submitButton(Yii::t('app', '<i class="bi bi-search"></i> Pesquisar'), ['class' => 'btn btn-primary btn-sm']) ?>
                                        <?= Html::a('<i class="fa fa-sync fa-spin" style="animation-iteration-count: 1;animation-duration: 0.3s"></i> Limpar Filtros', ['index-consumo'], ['class' => 'btn btn-success btn-sm'])  ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php // $form->field($model, 'email') ?>

        <?php // $form->field($model, 'telefone') ?>

        <?php // echo $form->field($model, 'cep') ?>

        <?php // echo $form->field($model, 'rua') ?>

        <?php // echo $form->field($model, 'numero') ?>

        <?php // echo $form->field($model, 'complemento') ?>

        <?php // echo $form->field($model, 'bairro') ?>

        <?php // echo $form->field($model, 'cidade') ?>

        <?php // echo $form->field($model, 'uf') ?>

    <!--div class="form-group">
        < ?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        < ?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div-->

    <?php ActiveForm::end(); ?>

</div>
