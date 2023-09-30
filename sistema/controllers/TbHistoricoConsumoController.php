<?php

namespace app\controllers;

use app\models\TbHistoricoConsumo;
use app\models\TbHistoricoConsumoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TbCliente;
use app\models\TbClienteSearch;
use Yii;
use app\models\TbProduto;
use app\models\TbProdutoSearch;
use app\models\TbEstoque;
use app\models\TbEstoqueSearch;


/**
 * TbHistoricoConsumoController implements the CRUD actions for TbHistoricoConsumo model.
 */
class TbHistoricoConsumoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access'=> [
                    'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
                ],
            ]
        );
    }

    /**
     * Lists all TbHistoricoConsumo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TbHistoricoConsumoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbHistoricoConsumo model.
     * @param int $id_consumo Id Consumo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_consumo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_consumo),
        ]);
    }

    /**
     * Creates a new TbHistoricoConsumo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        /*$model = new TbHistoricoConsumo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                //return $this->redirect(['view', 'id_consumo' => $model->id_consumo]);
                //return $this->redirect(['tb-cliente/consumo-historico', 'cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);*/

        $model = new TbHistoricoConsumo();

        $hoje = date('Y-m-d');

        $model->id_cliente_cpf_cnpj;
        $model->data_consumo = $hoje;

        $produtoModel = new TbProduto();
        $estoqueModel = new TbEstoque();



        if ($this->request->isPost) {
            // Carregue os modelos TbProduto e TbEstoque com base nos dados fornecidos
            $produtoModel->load($this->request->post());
            $estoqueModel->load($this->request->post());
            $model->load($this->request->post());
            //echo $estoqueModel->qtd_itens."<br>";

            $qtdItens = $estoqueModel->qtd_itens;
            //echo $qtdItens;
            $qtdConsumida = $model->qtd_consumida;
            //echo "<br>". $qtdConsumida;


            //var_dump($model->qtd_consumida);

            if ($qtdConsumida <= $qtdItens) {
                // Calcula a nova quantidade de itens
                $novaQuantidade = $qtdItens - $qtdConsumida;
                //echo "<br>". $novaQuantidade;
                //var_dump($novaQuantidade);die;
                // Atualiza a tabela tb_estoque
                Yii::$app->db->createCommand()
                ->update('tb_estoque', ['qtd_itens' => $novaQuantidade], ['id_estoque' => $model->id_estoque])
                ->execute();
                if ($model->save()) {
                    // Crie um flash message de Sucesso
                    Yii::$app->session->setFlash('success', 'Consumo gravado com sucesso.');
                    return $this->redirect(['tb-cliente/consumo-historico', 'cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
                }

            }else{
                //throw new \yii\base\Exception('Não há saldo disponível.'); // Lança uma exceção Yii2 com a mensagem de erro
                // Crie um flash message de erro
                Yii::$app->session->setFlash('error', 'Não há saldo disponível.');
                //return $this->render('tb-cliente/consumo-historico', ['cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
                return $this->redirect(['tb-cliente/consumo-historico', 'cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbHistoricoConsumo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_consumo Id Consumo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_consumo)
    {
        $model = $this->findModel($id_consumo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_consumo' => $model->id_consumo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbHistoricoConsumo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_consumo Id Consumo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_consumo)
    {
        $this->findModel($id_consumo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbHistoricoConsumo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_consumo Id Consumo
     * @return TbHistoricoConsumo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_consumo)
    {
        if (($model = TbHistoricoConsumo::findOne(['id_consumo' => $id_consumo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    //Para preenchimento automático via javascript CPF e CNPJ
    public  static function actionObterDadosClienteCpfCnpj($cpf_cnpj){

        $clienteModel = new TbCliente();
        $data = $clienteModel->getClientesCpfCnpj($cpf_cnpj);
        //var_dump($data);die;
        return json_encode($data);
    }

    //Para preenchimento automático via javascript Nome
    public  static function actionObterDadosClienteNome($nome){

        $clienteModel = new TbCliente();
        $data = $clienteModel->getClientesNome($nome);
        //var_dump($data);die;
        return json_encode($data);
    }

    public function actionHistorico($cpf_cnpj)
    {

        $model = new TbHistoricoConsumo();

        $hoje = date('Y-m-d');

        $model->id_cliente_cpf_cnpj = $cpf_cnpj;
        $model->data_consumo = $hoje;

        $produtoModel = new TbProduto();
        $estoqueModel = new TbEstoque();



        if ($this->request->isPost) {
            // Carregue os modelos TbProduto e TbEstoque com base nos dados fornecidos
            $produtoModel->load($this->request->post());
            $estoqueModel->load($this->request->post());
            $model->load($this->request->post());
            //echo $estoqueModel->qtd_itens."<br>";

            $qtdItens = $estoqueModel->qtd_itens;
            $qtdConsumida = $model->qtd_consumida;

            //var_dump($model->qtd_consumida);

            if ($qtdConsumida <= $qtdItens) {
                // Calcula a nova quantidade de itens
                $novaQuantidade = $qtdItens - $qtdConsumida;
                // Atualiza a tabela tb_estoque
                Yii::$app->db->createCommand()
                ->update('tb_estoque', ['qtd_itens' => $novaQuantidade], ['id_estoque' => $estoqueModel->id_estoque])
                ->execute();
                if ($model->save()) {
                    // Crie um flash message de Sucesso
                    Yii::$app->session->setFlash('success', 'Consumo gravado com sucesso.');
                    return $this->redirect(['tb-cliente/consumo-historico', 'cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
                }

            }else{
                //throw new \yii\base\Exception('Não há saldo disponível.'); // Lança uma exceção Yii2 com a mensagem de erro
                // Crie um flash message de erro
                Yii::$app->session->setFlash('error', 'Não há saldo disponível.');
                //return $this->render('tb-cliente/consumo-historico', ['cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
                return $this->redirect(['tb-cliente/consumo-historico', 'cpf_cnpj' => $model->id_cliente_cpf_cnpj]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('historico', [
            'model' => $model,
        ]);
    }
}
