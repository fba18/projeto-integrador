<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbCliente;
use yii\db\Query;

/**
 * TbClienteSearch represents the model behind the search form of `app\models\TbCliente`.
 */
class TbClienteConsumoSearch extends TbCliente
{
    public $id_consumo;
    public $num_produto;
    public $nome_produto;
    public $estado_produto;
    public $preco_produto;
    public $id_estoque;
    public $qtd_itens;
    public $endereco_item;
    public $qtd_consumida;
    public $data_consumo;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_consumo','cpf_cnpj', 'nome', 'num_produto', 'nome_produto', 'estado_produto', 'preco_produto', 'id_estoque', 'qtd_itens', 'endereco_item', 'qtd_consumida', 'data_consumo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /*$query = TbCliente::find()
        ->select([
            'tb_historico_consumo.id_consumo',
            'tb_cliente.cpf_cnpj',
            'tb_cliente.nome',
            'tb_produto.num_produto',
            'tb_produto.nome_produto',
            'tb_produto.estado_produto',
            'tb_produto.preco_produto',
            'tb_estoque.id_estoque',
            'tb_estoque.qtd_itens',
            'tb_estoque.endereco_item',
            'tb_historico_consumo.qtd_consumida',
            'tb_historico_consumo.data_consumo',
        ])
        ->leftJoin('tb_historico_consumo', 'tb_historico_consumo.id_cliente_cpf_cnpj = tb_cliente.cpf_cnpj')
        ->leftJoin('tb_estoque', 'tb_estoque.id_estoque = tb_historico_consumo.id_estoque')
        ->leftJoin('tb_produto', 'tb_produto.num_produto = tb_estoque.num_produto');*/

        $query = (new Query())
        ->select([
            'hc.id_consumo',
            'c.cpf_cnpj',
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
        ->orderBy(['hc.data_consumo' => SORT_ASC]); // Ordenar por data_consumo em ordem crescente


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['id_consumo'] = [
            'asc' => ['hc.id_consumo' => SORT_ASC],
            'desc' => ['hc.id_consumo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['cpf_cnpj'] = [
            'asc' => ['c.cpf_cnpj' => SORT_ASC],
            'desc' => ['c.cpf_cnpj' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['nome'] = [
            'asc' => ['c.nome' => SORT_ASC],
            'desc' => ['c.nome' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['num_produto'] = [
            'asc' => ['p.num_produto' => SORT_ASC],
            'desc' => ['p.num_produto' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['nome_produto'] = [
            'asc' => ['p.nome_produto' => SORT_ASC],
            'desc' => ['p.nome_produto' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['estado_produto'] = [
            'asc' => ['p.estado_produto' => SORT_ASC],
            'desc' => ['p.estado_produto' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['preco_produto'] = [
            'asc' => ['p.preco_produto' => SORT_ASC],
            'desc' => ['p.preco_produto' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['id_estoque'] = [
            'asc' => ['e.id_estoque' => SORT_ASC],
            'desc' => ['e.id_estoque' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['qtd_itens'] = [
            'asc' => ['e.qtd_itens' => SORT_ASC],
            'desc' => ['e.qtd_itens' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['endereco_item'] = [
            'asc' => ['e.endereco_item' => SORT_ASC],
            'desc' => ['e.endereco_item' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['qtd_consumida'] = [
            'asc' => ['hc.qtd_consumida' => SORT_ASC],
            'desc' => ['hc.qtd_consumida' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['data_consumo'] = [
            'asc' => ['hc.data_consumo' => SORT_ASC],
            'desc' => ['hc.data_consumo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'data_nascimento' => $this->data_nascimento,
            //'numero' => $this->numero,
            'id_consumo' => $this->id_consumo,
            'qtd_itens' => $this->qtd_itens,
            'data_consumo' => $this->data_consumo,
        ]);


        $query->andFilterWhere(['like', 'hc.id_consumo', $this->id_consumo])
            ->andFilterWhere(['like', 'c.cpf_cnpj', $this->cpf_cnpj])
            ->andFilterWhere(['like', 'c.nome', $this->nome])
            ->andFilterWhere(['like', 'p.num_produto', $this->num_produto])
            ->andFilterWhere(['like', 'p.nome_produto', $this->nome_produto])
            ->andFilterWhere(['like', 'p.estado_produto', $this->estado_produto])
            ->andFilterWhere(['like', 'p.preco_produto', $this->preco_produto])
            ->andFilterWhere(['like', 'e.id_estoque', $this->id_estoque])
            ->andFilterWhere(['like', 'e.qtd_itens', $this->qtd_itens])
            ->andFilterWhere(['like', 'e.endereco_item', $this->endereco_item])
            ->andFilterWhere(['like', 'hc.qtd_consumida', $this->qtd_consumida])
            ->andFilterWhere(['like', 'hc.data_consumo', $this->data_consumo]);

        return $dataProvider;
    }
}
