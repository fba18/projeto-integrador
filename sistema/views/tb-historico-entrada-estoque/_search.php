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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-search fa-fw"></i>
                            <h4> Consultar Depósitos </h4>
                            </h3>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">

                            <div class="container-fluid w-auto row">
                                <!-- <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                    <?php //$form->field($model, 'id_historico_entrada_estoque') ?>
                                </div> -->
                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                    <?= $form->field($model, 'id_local_deposito')->label('Id Local Depósito') ?>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                    <?= $form->field($model, 'id_estoque')->label('Id Estoque') ?>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                    <?= $form->field($model, 'num_produto')->label('Cód Produto') ?>
                                </div>
                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                    <?= $form->field($model, 'data_inclusao')->textInput(['type' => 'date'])->label("Data de inclusão") ?>
                                </div>

                                <?php // echo $form->field($model, 'qtd_inclusao') ?>

                                <?php // echo $form->field($model, 'tipo_entrada') ?>

                                <?php // echo $form->field($model, 'id_local_deposito_anterior') ?>

                                <?php // echo $form->field($model, 'id_usuario_inclusao') ?>

                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                    <div class="mt-4 form-group">
                                        <?= Html::submitButton(Yii::t('app', 'Pesquisar'), ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                        <?= Html::resetButton(Yii::t('app', 'Limpar'), ['class' => 'btn btn-outline-secondary btn-sm']) ?>
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
