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
                                    <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'id_local_deposito')->label('Código Depósito') ?>
                                    </div>
                                    <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'nome_deposito') ?>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'endereco_deposito')->label('Endereço Depósito') ?>
                                    </div>
                                    <div class="col-lg-1 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'uf')->label('UF') ?>
                                    </div>
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
