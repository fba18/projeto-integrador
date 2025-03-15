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
use yii\db\Query;
use yii\data\ArrayDataProvider;


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
            $idEstoque = $estoqueModel->id_estoque;

            //$qtdItens = $estoqueModel->qtd_itens;
            $consultaSaldoDisponivel = TbEstoque::findOne($idEstoque);
            $qtdItens =  $consultaSaldoDisponivel->qtd_itens;
            $qtdConsumida = $model->qtd_consumida;

            $nomeProduto = $produtoModel->nome_produto;
            $enderecoEstoque = $estoqueModel->endereco_item;
            $id_local_deposito = $estoqueModel->id_local_deposito;

            $deposito = Yii::$app->db->createCommand("SELECT nome_deposito FROM tb_local_deposito WHERE id_local_deposito = $id_local_deposito ")->queryScalar();

            //var_dump($model->qtd_consumida);

            if ($qtdConsumida <= $qtdItens) {
                // Calcula a nova quantidade de itens
                $novaQuantidade = $qtdItens - $qtdConsumida;

                if ($model->save()) {
                //if (2>1) {
                     // Atualiza a tabela tb_estoque
                    Yii::$app->db->createCommand()
                    ->update('tb_estoque', ['qtd_itens' => $novaQuantidade], ['id_estoque' => $estoqueModel->id_estoque])
                    ->execute();

                    $consultaSaldo = TbEstoque::findOne($idEstoque);

                    if ($consultaSaldo->qtd_itens <= 10){
                        Yii::$app->mailer->compose()
                            ->setFrom(['projeto.integrador.univesp.eig@gmail.com' => 'Sistema EIG'])
							->setTo('2101648@aluno.univesp.br')
							->setHtmlBody("
                                <p><strong style='color:red;'><u>ALERTA DE ESTOQUE BAIXO:</u></strong></p><br>
                                <p>
                                    <strong>Código produto: </strong><em>$idEstoque</em><BR>
                                    <strong>Nome: </strong><em>$nomeProduto</em><BR>
                                    <strong>Endereço: </strong><em> $enderecoEstoque</em><BR>
                                    <strong>Depósito: </strong><em> $deposito</em><BR>
                                    <strond>Está com nível baixo, restando apenas <em style='color:red;'>$consultaSaldo->qtd_itens unidades</em></strong>.
                                </p>
                                <br>
                                <p><em>Esta é uma mensagem automática gerada pelo sistema EIG para controle de Estoque.</em></p>
                            ")
							->setSubject("Alerta de Estoque Baixo - $nomeProduto")
							->send();
                    }


                    //var_dump($consultaSaldo->qtd_itens);die;

                    Yii::$app->mailer->compose()
                    ->setFrom(['projeto.integrador.univesp.eig@gmail.com' => 'Sistema EIG'])
                    ->setTo('2101648@aluno.univesp.br')
                    ->setHtmlBody("
                        <p><strong style='color:red;'><u>ALERTA DE CONSUMO:</u></strong></p><br>
                        <p>
                            <strong>Código produto: </strong><em>$idEstoque</em><BR>
                            <strong>Nome: </strong><em>$nomeProduto</em><BR>
                            <strong>Endereço: </strong><em> $enderecoEstoque</em><BR>
                            <strong>Depósito: </strong><em> $deposito</em>.
                        </p>
                        <br>
                        <p><em>Esta é uma mensagem automática gerada pelo sistema EIG para controle de Estoque.</em></p>
                    ")
                    ->setSubject("Alerta de consumo - $nomeProduto")
                    ->send();

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

    //Dashboards
        public function actionDashboard(){

            //Query Produtos com menos de 5 em estoque
                $connection = \Yii::$app->db;
                $query = new Query();

                $produtos_baixos = $connection->createCommand(
                    "SELECT
                        nome_produto, qtd_itens AS qtd
                    FROM
                        sistema.tb_produto AS p
                    JOIN
                        tb_estoque AS e ON p.num_produto = e.num_produto
                    WHERE
                        qtd_itens <=5
                    GROUP BY nome_produto
                    ORDER BY nome_produto ASC
                ;")->queryAll();

                //var_dump($produtos_baixos);
            //

            //Query Produtos com saldo 0 em estoque
                $connection = \Yii::$app->db;
                $query = new Query();

                $produtos_sem_saldo = $connection->createCommand(
                    "SELECT
                        p.nome_produto, COALESCE(e.qtd_itens, 0) AS qtd
                    FROM
                        sistema.tb_produto AS p
                    LEFT JOIN
                        tb_estoque AS e ON p.num_produto = e.num_produto
                    WHERE
                        e.qtd_itens IS NULL OR e.qtd_itens = 0
                    GROUP BY p.nome_produto
                    ORDER BY p.nome_produto ASC
                ;")->queryAll();

                //var_dump($produtos_sem_saldo);die;

                $dataProviderProdutosSemSaldo = new ArrayDataProvider([
                    'allModels' => $produtos_sem_saldo,
                    'pagination' => [
                        'pageSize' => 5, // ajuste conforme necessário
                    ],
                    'sort' => [
                        //'attributes' => array_keys($orcamentos[0]), // ajuste conforme necessário
                        'attributes' => !empty($produtos_sem_saldo) ? array_keys($produtos_sem_saldo[0]) : [], // verifica se o array não está vazio antes de acessar o índice 0
                    ],
                ]);

                //var_dump($produtos_baixos);
            //

            //Query 5 Produtos mais vendidos
                $connection = \Yii::$app->db;
                $query = new Query();

                $produtos_mais_vendidos = $connection->createCommand(
                    "SELECT
                        p.nome_produto, sum(h.qtd_consumida) AS qtd
                    FROM
                        sistema.tb_historico_consumo AS h
                    JOIN
                        tb_produto as p ON p.num_produto = h.id_num_produto
                    GROUP BY
                        h.id_num_produto
                    ORDER BY qtd DESC
                    LIMIT 5
                ;")->queryAll();

                //var_dump($produtos_mais_vendidos);
            //

            //Query 5 Produtos menos vendidos
                $connection = \Yii::$app->db;
                $query = new Query();

                $produtos_menos_vendidos = $connection->createCommand(
                    "SELECT
                        p.nome_produto, sum(h.qtd_consumida) AS qtd
                    FROM
                        sistema.tb_historico_consumo AS h
                    JOIN
                        tb_produto as p ON p.num_produto = h.id_num_produto
                    GROUP BY
                        h.id_num_produto
                    ORDER BY qtd ASC
                    LIMIT 5
                ;")->queryAll();

                //var_dump($produtos_menos_vendidos);
            //
/*
            //Query Situacao Demandas abertas por UF
                $connection = \Yii::$app->db;
                $query = new Query();

                $situacao_demandas_uf = $connection->createCommand(
                    "SELECT
                        sg_uf, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda NOT IN ('', 'CONCLUÍDO', 'CANCELADO')
                        AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY sg_uf
                    ORDER BY sg_uf ASC
                ;")->queryAll();

                //var_dump($situacao_demandas2);
            //

            //Query Situacao Demandas abertas por Empresas
                $connection = \Yii::$app->db;
                $query = new Query();

                $situacao_demandas_empresas = $connection->createCommand(
                    "SELECT
                        fornecedora, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda NOT IN ('', 'CONCLUÍDO', 'CANCELADO')
                        AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY fornecedora
                    ORDER BY fornecedora ASC
                ;")->queryAll();

                //var_dump($situacao_demandas2);
            //

            //Query Situacao Demandas Concluídas e canceladas
                $connection = \Yii::$app->db;
                $query = new Query();

                $demandas_concluídas = $connection->createCommand(
                    "SELECT
                        status_demanda, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY status_demanda
                    ORDER BY status_demanda ASC
                ;")->queryAll();
            //

            //Query Situacao Demandas Concluídas e canceladas
                $connection = \Yii::$app->db;
                $query = new Query();

                $demandas_concluidas_lc = $connection->createCommand(
                    "SELECT
                        status_demanda, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                    fornecedora IN ('LC ENGENHARIA E SERVICOS EIRELI ME')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY status_demanda
                    ORDER BY status_demanda ASC
                ;")->queryAll();
            //

            //Query Situacao Demandas Concluídas e canceladas
                $connection = \Yii::$app->db;
                $query = new Query();

                $demandas_concluidas_ns = $connection->createCommand(
                    "SELECT
                        status_demanda, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                    fornecedora IN ('NS NET SUPPORT SERVICOS EM TECNOLOGIA S A')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY status_demanda
                    ORDER BY status_demanda ASC
                ;")->queryAll();
            //

            //Query Situacao Demandas abertas por UF
                $connection = \Yii::$app->db;
                $query = new Query();

                $situacao_demandas_concluidas_uf = $connection->createCommand(
                    "SELECT
                        sg_uf, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY sg_uf
                    ORDER BY sg_uf ASC
                ;")->queryAll();

                //var_dump($situacao_demandas2);
            //

            //Query Situacao Demandas abertas por Empresas
                $connection = \Yii::$app->db;
                $query = new Query();

                $situacao_demandas_concluidas_empresas = $connection->createCommand(
                    "SELECT
                        fornecedora, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY fornecedora
                    ORDER BY fornecedora ASC
                ;")->queryAll();

                //var_dump($situacao_demandas2);
            //

            //Query Demandas abertas mapa Brasil
                $mapa_brasil_abertos = $connection->createCommand(
                    "SELECT
                        sg_uf, fornecedora, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda NOT IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY sg_uf, fornecedora
                    ORDER BY sg_uf ASC
                ;")->queryAll();
            //

            //Query Demandas concluídas mapa Brasil
                $mapa_brasil_concluido = $connection->createCommand(
                    "SELECT
                        sg_uf, fornecedora, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY sg_uf, fornecedora
                    ORDER BY sg_uf ASC
                ;")->queryAll();
            //

            //Query TESTE por UF
                $connection = \Yii::$app->db;
                $query = new Query();

                $dados = $connection->createCommand(
                    "SELECT
                        sg_uf, fornecedora, COUNT(*) AS qtd
                    FROM
                        monitoradb.tb_checklist_dosi_infra_adequacao
                    WHERE
                        fornecedora NOT IN ('')
                        AND status_demanda IN ('CONCLUÍDO', 'CANCELADO')
                        -- AND situacao_para_fornecedor NOT IN ('')
                    GROUP BY sg_uf
                    ORDER BY sg_uf ASC
                ;")->queryAll();

            //

            */

            //var_dump($situacao_demandas2);
        //


            return $this->render('dashboard', [
                //'dataProvider' => $dataProvider,
                //'model' => $model,
                'produtos_baixos' => $produtos_baixos,
                'dataProviderProdutosSemSaldo' => $dataProviderProdutosSemSaldo,
                'produtos_mais_vendidos' => $produtos_mais_vendidos,
                'produtos_menos_vendidos' => $produtos_menos_vendidos,
                /*'demandas_concluídas' => $demandas_concluídas,

                'situacao_demandas_uf' => $situacao_demandas_uf,
                'situacao_demandas_empresas' => $situacao_demandas_empresas,
                'demandas_concluidas_lc' => $demandas_concluidas_lc,
                'demandas_concluidas_ns' => $demandas_concluidas_ns,
                'situacao_demandas_concluidas_uf' => $situacao_demandas_concluidas_uf,
                'situacao_demandas_concluidas_empresas' => $situacao_demandas_concluidas_empresas,
                'dados' => $dados,
                'mapa_brasil_concluido' => $mapa_brasil_concluido,
                'mapa_brasil_abertos' => $mapa_brasil_abertos,*/
            ]);
        }
    //
}
