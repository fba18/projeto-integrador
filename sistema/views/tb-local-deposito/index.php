<?php

use app\models\TbLocalDeposito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\export\ExportMenu;
use kartik\editable\Editable;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDepositoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Depósitos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-local-deposito-index">

    <!--h1>< ?= Html::encode($this->title) ?></h1-->

    <p>
        <?php //Html::a(Yii::t('app', 'Adicionar Local Estoque'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="table-responsive col-lg-12 col-xs-12 col-sm-12  " >

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsive'=>true,
                'resizableColumns'=>false,
                'responsiveWrap' => false,
                'striped'=>true,
                'containerOptions'=>['style'=>'overflow: auto; font-size:1.0em;',],
                'options' =>['class'=>'table' ,'style'=>'font-size:1.0em'],
                'toolbar'=>[
                    '{export}',
                    '{toggleData}'
                ],
                'exportContainer' => ['class' => 'btn-group-sm'],
                'toggleDataContainer' => ['class' => 'btn-group-sm'],
                'hover'=>true,
                'pager' => [
                    'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
                    'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
                    'options' => ['class' => 'pagination justify-content-center'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledPageCssClass' => 'disabled',
                    'activePageCssClass' => 'active',
                ],
                'panel' => [

                    'heading'=>'&nbsp',

                    'type'=>'primary',

                    'before'=>
                        Html::a(Yii::t('app', 'Adicionar Local Estoque'), ['create'], ['class' => 'btn btn-outline-success btn-sm']).' '.
                        Html::a('<i class="fa fa-sync fa-spin" style="animation-iteration-count: 1;animation-duration: 0.3s"></i> Limpar Filtros'
                        , ['index'], ['class' => 'btn btn-outline-primary btn-sm']),


                    'footer'=>'',
                ],
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    //'id_local_deposito',
                    'id_local_deposito' => [
                        'label' => 'Cód. Depósito',
                        'attribute' => 'id_local_deposito',
                        'enableSorting' => true,
                    ],
                    //'nome_deposito',
                    'nome_deposito' => [
                        'label' => 'Nome Depósito',
                        'attribute' => 'nome_deposito',
                        'enableSorting' => true,
                    ],
                    //'endereco_deposito',
                    'endereco_deposito' => [
                        'label' => 'Endereço Depósito',
                        'attribute' => 'endereco_deposito',
                        'enableSorting' => true,
                    ],
                    //'uf',
                    'uf' => [
                        'label' => 'UF',
                        'attribute' => 'uf',
                        'enableSorting' => true,
                    ],
                    // [
                    //     'class' => ActionColumn::className(),
                    //     'urlCreator' => function ($action, TbLocalDeposito $model, $key, $index, $column) {
                    //         return Url::toRoute([$action, 'id_local_deposito' => $model->id_local_deposito]);
                    //     }
                    // ],
                    [

                        'label' => 'Editar',
                        'format' => 'raw',
                        'attribute'=>'acoes',

                        // here comes the problem - instead of parent_region I need to have parent
                        'value' => function ($dataProvider) {
                            return Html::a('<i class="bi bi-pencil"></i>',  Url::to(["update?id_local_deposito=".$dataProvider['id_local_deposito'], true]), ['class' => 'btn btn-outline-danger btn-sm', 'role' => 'modal-remote','target'=>'_blank']);
                        }
                    ],
                ],
            ]); ?>
        </div>

    <?php Pjax::end(); ?>

</div>
