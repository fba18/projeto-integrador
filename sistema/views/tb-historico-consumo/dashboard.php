<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/world.js"></script>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/accessibility.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<?php

use app\models\TbChamadosAgil;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\db\Expression;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use yii\db\Query;


use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\TbChamadosAgilSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Relatório Gerencial EIG');
$this->params['breadcrumbs'][] = $this->title;



//var_dump($criticidade);
?>


<div class="col-md-12">

    <!--div class="col-lg-12">
        <p>
            <?php //Html::a(Yii::t('app', 'Início'), ['index'], ['class' => 'btn btn-success']) ?>
        </p>
    </div-->

    <div class="col-md-12 row">


        <!-- 5 PRODUTOS MAIS VENDIDOS-->
            <div class="col-md-4">
                <div class="card  card-outline">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                        <div class="container-fluid w-auto row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                <div class="box" style="allign:center">

                                    <div style="text-align: center"><b>5 produtos mais vendidos</b>
                                    </div>

                                    <div id="nome_produto_mais_vendidos">
                                    </div>

                                </div>
                                <?php

                                foreach ($produtos_mais_vendidos as $sc) {

                                    if (isset($sc['nome_produto'])) {
                                        $stts = $sc['nome_produto'];
                                        $nome_produtos_mais_vendidos[] = $stts;
                                    }
                                }
                                //var_dump($nome_status);

                                foreach ($produtos_mais_vendidos as $qtd) {
                                    //var_dump($registro);
                                    if (isset($qtd['qtd'])) {
                                        $qtd_produtos_mais_vendidos[] = $qtd['qtd'];
                                    }
                                }

                                $json_produto_mais_vendidos = json_encode($nome_produtos_mais_vendidos, JSON_PRETTY_PRINT);

                                $json_qtd_produtos_mais_vendidos = json_encode($qtd_produtos_mais_vendidos, JSON_PRETTY_PRINT);

                                ?>

                                <script>
                                    var options_nome_produto_mais_vendidos = {
                                        series: [{
                                            name: 'Quantidade',
                                            data: <?= $json_qtd_produtos_mais_vendidos ?>

                                        }],
                                        chart: {

                                            height: 350,
                                            type: 'bar',
                                            events: {
                                                dataPointSelection: function(event, chartContext, config) {

                                                    var sliceLabel = options_nome_produto_mais_vendidos.xaxis.categories[config.dataPointIndex];
                                                    //console.log('Fatia selecionada: ' + sliceLabel);
                                                    //alert('Você selecionou a coluna data: ' + sliceLabel);
                                                    window.open('index?TbHistoricoConsumoSearch%5Bnome_produto%5D=' + sliceLabel, '_blank');
                                                }
                                            },

                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 10,
                                                distributed: true,
                                                dataLabels: {
                                                    position: 'top', // top, center, bottom
                                                },
                                                columnWidth: '25%',
                                            }
                                        },
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(val) {
                                                return val;
                                            },
                                            offsetY: -20,
                                            style: {
                                                fontSize: '12px',
                                                colors: ["#304758"]
                                            }
                                        },

                                        xaxis: {
                                            categories: <?= $json_produto_mais_vendidos ?>,
                                            position: 'down',
                                            labels: {
                                                show: false // Esta linha desativa a exibição dos rótulos
                                            },
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false
                                            },
                                            crosshairs: {
                                                fill: {
                                                    type: 'gradient',
                                                    gradient: {
                                                        colorFrom: '#D8E3F0',
                                                        colorTo: '#BED1E6',
                                                        stops: [0, 100],
                                                        opacityFrom: 0.4,
                                                        opacityTo: 0.5,
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                enabled: false,
                                            }
                                        },
                                        yaxis: {
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false,
                                            },

                                            labels: {
                                                show: false,
                                                formatter: function(val) {
                                                    return val;
                                                }
                                            }

                                        },
                                        /*title: {
                                        text: 'Monthly Inflation in Argentina, 2002',
                                        floating: true,
                                        offsetY: 330,
                                        align: 'center',
                                        style: {
                                            color: '#444'
                                        }
                                        }*/
                                    };

                                    var chart = new ApexCharts(document.querySelector("#nome_produto_mais_vendidos"), options_nome_produto_mais_vendidos);
                                    chart.render();
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- FIM PRODUTOS MAIS VENDIDOS -->

        <!-- 5 PRODUTOS MENOS VENDIDOS-->
            <div class="col-md-4">
                <div class="card  card-outline">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                        <div class="container-fluid w-auto row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                <div class="box" style="allign:center">

                                    <div style="text-align: center"><b>5 produtos menos vendidos</b>
                                    </div>

                                    <div id="nome_produto_menos_vendidos">
                                    </div>

                                </div>
                                <?php

                                foreach ($produtos_menos_vendidos as $sc) {

                                    if (isset($sc['nome_produto'])) {
                                        $stts = $sc['nome_produto'];
                                        $nome_produtos_menos_vendidos[] = $stts;
                                    }
                                }
                                //var_dump($nome_produtos_menos_vendidos);

                                foreach ($produtos_menos_vendidos as $qtd) {
                                    //var_dump($registro);
                                    if (isset($qtd['qtd'])) {
                                        $qtd_produtos_menos_vendidos[] = $qtd['qtd'];
                                    }
                                }

                                $json_produto_menos_vendidos = json_encode($nome_produtos_menos_vendidos, JSON_PRETTY_PRINT);

                                $json_qtd_produtos_menos_vendidos = json_encode($qtd_produtos_menos_vendidos, JSON_PRETTY_PRINT);

                                ?>

                                <script>
                                    var options_nome_produto_menos_vendidos = {
                                        series: [{
                                            name: 'Quantidade',
                                            data: <?= $json_qtd_produtos_menos_vendidos ?>

                                        }],
                                        chart: {

                                            height: 350,
                                            type: 'bar',
                                            events: {
                                                dataPointSelection: function(event, chartContext, config) {

                                                    var sliceLabel = options_nome_produto_menos_vendidos.xaxis.categories[config.dataPointIndex];
                                                    //console.log('Fatia selecionada: ' + sliceLabel);
                                                    //alert('Você selecionou a coluna data: ' + sliceLabel);
                                                    window.open('index?TbHistoricoConsumoSearch%5Bnome_produto%5D=' + sliceLabel, '_blank');
                                                }
                                            },

                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 10,
                                                distributed: true,
                                                dataLabels: {
                                                    position: 'top', // top, center, bottom
                                                },
                                                columnWidth: '25%',
                                            }
                                        },
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(val) {
                                                return val;
                                            },
                                            offsetY: -20,
                                            style: {
                                                fontSize: '12px',
                                                colors: ["#304758"]
                                            }
                                        },

                                        xaxis: {
                                            categories: <?= $json_produto_menos_vendidos ?>,
                                            position: 'down',
                                            labels: {
                                                show: false // Esta linha desativa a exibição dos rótulos
                                            },
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false
                                            },
                                            crosshairs: {
                                                fill: {
                                                    type: 'gradient',
                                                    gradient: {
                                                        colorFrom: '#D8E3F0',
                                                        colorTo: '#BED1E6',
                                                        stops: [0, 100],
                                                        opacityFrom: 0.4,
                                                        opacityTo: 0.5,
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                enabled: false,
                                            }
                                        },
                                        yaxis: {
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false,
                                            },

                                            labels: {
                                                show: false,
                                                formatter: function(val) {
                                                    return val;
                                                }
                                            }

                                        },
                                        /*title: {
                                        text: 'Monthly Inflation in Argentina, 2002',
                                        floating: true,
                                        offsetY: 330,
                                        align: 'center',
                                        style: {
                                            color: '#444'
                                        }
                                        }*/
                                    };

                                    var chart = new ApexCharts(document.querySelector("#nome_produto_menos_vendidos"), options_nome_produto_menos_vendidos);
                                    chart.render();
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- FIM PRODUTOS MENOS VENDIDOS -->

        <!-- PORDUTOS COM SALDO MENOR QUE 5-->
            <div class="col-md-4">
                <div class="card  card-outline">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                        <div class="container-fluid w-auto row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                <div class="box" style="allign:center">

                                    <div style="text-align: center"><b>Produtos com menos de 5 unidades</b>
                                    </div>

                                    <div id="estoque_saldo_baixo">
                                    </div>

                                </div>
                                <?php

                                foreach ($produtos_baixos as $sc) {

                                    if (isset($sc['nome_produto'])) {
                                        $stts = $sc['nome_produto'];
                                        $nome_produto_saldo[] = $stts;
                                    }
                                }
                                //var_dump($nome_status);

                                foreach ($produtos_baixos as $qtd) {
                                    //var_dump($registro);
                                    if (isset($qtd['qtd'])) {
                                        $qtd_produto_saldo[] = $qtd['qtd'];
                                    }
                                }

                                $json_nome_produto_saldo = json_encode($nome_produto_saldo, JSON_PRETTY_PRINT);

                                $json_qtd_produto_saldo = json_encode($qtd_produto_saldo, JSON_PRETTY_PRINT);

                                ?>

                                <script>
                                    var options_estoque_saldo_baixo = {
                                        series: [{
                                            name: 'Quantidade',
                                            data: <?= $json_qtd_produto_saldo ?>

                                        }],
                                        chart: {

                                            height: 350,
                                            type: 'bar',
                                            events: {
                                                dataPointSelection: function(event, chartContext, config) {

                                                    var sliceLabel = options_estoque_saldo_baixo.xaxis.categories[config.dataPointIndex];
                                                    //console.log('Fatia selecionada: ' + sliceLabel);
                                                    //alert('Você selecionou a coluna data: ' + sliceLabel);

                                                    window.open('/tb-estoque/index?TbEstoqueSearch%5Bnome_produto%5D=' + sliceLabel, '_blank');

                                                }
                                            },

                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 10,
                                                distributed: true,
                                                dataLabels: {
                                                    position: 'top', // top, center, bottom
                                                },
                                                columnWidth: '25%',
                                            }
                                        },
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function(val) {
                                                return val;
                                            },
                                            offsetY: -20,
                                            style: {
                                                fontSize: '12px',
                                                colors: ["#304758"]
                                            }
                                        },

                                        xaxis: {
                                            categories: <?= $json_nome_produto_saldo ?>,
                                            position: 'down',
                                            labels: {
                                                show: false // Esta linha desativa a exibição dos rótulos
                                            },
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false
                                            },
                                            crosshairs: {
                                                fill: {
                                                    type: 'gradient',
                                                    gradient: {
                                                        colorFrom: '#D8E3F0',
                                                        colorTo: '#BED1E6',
                                                        stops: [0, 100],
                                                        opacityFrom: 0.4,
                                                        opacityTo: 0.5,
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                enabled: false,
                                            }
                                        },
                                        yaxis: {
                                            axisBorder: {
                                                show: false
                                            },
                                            axisTicks: {
                                                show: false,
                                            },

                                            labels: {
                                                show: false,
                                                formatter: function(val) {
                                                    return val;
                                                }
                                            }

                                        },
                                        /*title: {
                                        text: 'Monthly Inflation in Argentina, 2002',
                                        floating: true,
                                        offsetY: 330,
                                        align: 'center',
                                        style: {
                                            color: '#444'
                                        }
                                        }*/
                                    };

                                    var chart = new ApexCharts(document.querySelector("#estoque_saldo_baixo"), options_estoque_saldo_baixo);
                                    chart.render();
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- FIM PORDUTOS COM SALDO MENOR QUE 5 -->

    </div>
    <div class="col-md-12 row">

        <!-- PORDUTOS COM SALDO 0 -->
            <?php //PORDUTOS COM SALDO 0
                if(isset($dataProviderProdutosSemSaldo)){
                    //var_dump($dataProviderOrcamento->allModels);die;
                    if($dataProviderProdutosSemSaldo->allModels){
                    ?>
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <h4>&nbsp Produtos sem saldo em estoque:</h4>
                                                </h3>
                                            </div>


                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                                <div class="container-fluid w-auto row">

                                                    <div class="table-responsive col-lg-12 col-xs-12 col-sm-12 col-md-6 ">
                                                        <!-- Grideview   -->

                                                        <?php

                                                        Pjax::begin(['id' => 'grid-pjax2']); ?>
                                                            <?= GridView::widget
                                                                (
                                                                    [
                                                                        'dataProvider' => $dataProviderProdutosSemSaldo,
                                                                        //Filtro de pesquisa
                                                                        //'filterModel' => $searchModel,
                                                                        'responsive'=>true,
                                                                        'pjax' => false,
                                                                        'resizableColumns' => false,
                                                                        'responsiveWrap' => false,
                                                                        'striped' => true,
                                                                        'containerOptions'=>['style'=>'overflow: auto; font-size:1em;'],
                                                                        'options' => ['class' => 'table table-condensed', 'style' => 'font-size:0.95em'],
                                                                        //'resizableColumnsOptions' => [ 'resizeFromBody' => false],

                                                                        //Botões de exportação e de expansão da quantidade de resultados da Grideview --v
                                                                        'toolbar'=>
                                                                        [
                                                                            '{export}',
                                                                            '{toggleData}',
                                                                        ],

                                                                        'hover'=>true,

                                                                        'panel' =>
                                                                        [
                                                                            //Título do painel
                                                                            'heading'=>'&nbsp',

                                                                            'type'=>'primary',

                                                                            //Parte acima do Pagination   (Rodapé)
                                                                            'after'=> '',

                                                                        ],

                                                                        //Colunas da Gridview
                                                                        'columns' =>
                                                                        [
                                                                            ['class' => 'yii\grid\SerialColumn'],
                                                                            //Itens comentados para não exibir na grideview
                                                                            [
                                                                                'attribute' => 'nome_produto',
                                                                                //'header' => 'ID',
                                                                                'label' => 'Nome do Produto: ',
                                                                                'headerOptions' => ['style' => 'max-width: 200px; text-align: center; vertical-align: middle;'],
                                                                                'contentOptions' => [
                                                                                    'style' => 'text-align: center;'
                                                                                ]
                                                                            ],


                                                                            [
                                                                                'attribute' => 'qtd',
                                                                                'label' => 'Quantidade: ',
                                                                                //Configuração/Estilo do título da coluna
                                                                                'headerOptions' => ['style' => 'max-width: 200px; text-align: center; vertical-align: middle;'],
                                                                                //Configuração/Estilo dos dados a serem exibidos na coluna
                                                                                'contentOptions' => [
                                                                                    'style' => 'text-align: center;'
                                                                                ],
                                                                            ],

                                                                            // ['class' => 'yii\grid\ActionColumn'],

                                                                        ],

                                                                    ]
                                                                );

                                                            ?>

                                                        <?php Pjax::end(); ?>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php
                    }
                }else{
                    //$dataProviderProdutosSemSaldo->allModels = null;
                    $dataProviderProdutosSemSaldo = new ArrayDataProvider([
                        'allModels' => null,
                    ]);
                }
            ?>
        <!-- FIM PORDUTOS COM SALDO 0 -->


    </div>


</div>
