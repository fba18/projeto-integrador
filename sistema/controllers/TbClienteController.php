<?php

namespace app\controllers;

use app\models\TbCliente;
use app\models\TbClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;
use app\models\TbHistoricoConsumo;
use app\models\TbHistoricoConsumoSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * TbClienteController implements the CRUD actions for TbCliente model.
 */
class TbClienteController extends Controller
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
            ]
        );
    }

    /**
     * Lists all TbCliente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TbClienteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexConsumo()
    {
        $searchModel = new TbClienteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index-consumo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbCliente model.
     * @param string $cpf_cnpj Cpf Cnpj
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cpf_cnpj)
    {
        return $this->render('view', [
            'model' => $this->findModel($cpf_cnpj),
        ]);
    }

    /**
     * Creates a new TbCliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TbCliente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cpf_cnpj' => $model->cpf_cnpj]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbCliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $cpf_cnpj Cpf Cnpj
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cpf_cnpj)
    {
        $model = $this->findModel($cpf_cnpj);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cpf_cnpj' => $model->cpf_cnpj]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbCliente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cpf_cnpj Cpf Cnpj
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cpf_cnpj)
    {
        $this->findModel($cpf_cnpj)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbCliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $cpf_cnpj Cpf Cnpj
     * @return TbCliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cpf_cnpj)
    {
        if (($model = TbCliente::findOne(['cpf_cnpj' => $cpf_cnpj])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionObterEnderecoCep($cep)
    {
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($response->isOk) {
            return $response->data;
        } else {
            return ['error' => 'CEP não encontrado'];
        }
    }

    public function actionValidateCpfCnpj()
    {
        $model = new TbCliente(); // Substitua YourModel pelo nome do seu modelo

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['valid' => $model->validate(['cpf_cnpj'])];
        }
    }

    public function actionConsumoHistorico($cpf_cnpj)
    {
        $model = $this->findModel($cpf_cnpj);

        // Crie uma instância de Query para construir a consulta personalizada
            $query = (new Query())
            ->select([
                'hc.id_consumo',
                'hc.id_cliente_cpf_cnpj',
                'c.nome',
                'p.num_produto',
                'p.nome_produto',
                'p.estado_produto',
                'p.preco_produto',
                'e.id_estoque',
                'e.qtd_itens',
                'e.endereco_item',
                'hc.qtd_consumida',
                'hc.data_consumo',
            ])
            ->from(['hc' => 'tb_historico_consumo'])
            ->innerJoin(['e' => 'tb_estoque'], 'hc.id_estoque = e.id_estoque')
            ->innerJoin(['p' => 'tb_produto'], 'e.num_produto = p.num_produto')
            ->innerJoin(['c' => 'tb_cliente'], 'hc.id_cliente_cpf_cnpj = c.cpf_cnpj')
            ->where(['hc.id_cliente_cpf_cnpj' => $cpf_cnpj])
            ->orderBy(['hc.data_consumo' => SORT_ASC]); // Ordenar por data_consumo em ordem crescente

        // Crie um ActiveDataProvider com a consulta personalizada
        /*$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5, // Defina o tamanho da página desejado
            ],
        ]);

        //var_dump($provider2);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['consumo-historico', 'cpf_cnpj' => $model->cpf_cnpj]);
        }

        return $this->render('historico', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
