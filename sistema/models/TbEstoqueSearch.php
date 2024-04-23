<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbEstoque;

/**
 * TbEstoqueSearch represents the model behind the search form of `app\models\TbEstoque`.
 */
class TbEstoqueSearch extends TbEstoque
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estoque', 'num_produto', 'qtd_itens'], 'integer'],
            [['endereco_item'], 'safe'],
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
        $query = TbEstoque::find()->joinWith('produto');

        $nome_produto = $params["TbEstoqueSearch"]["nome_produto"];

        // Adicione os campos que deseja ordenar
        $query->select([
            'tb_estoque.*', // Seleciona todos os campos da tabela de estoque
            'tb_produto.nome_produto',
            'tb_produto.estado_produto',
            'tb_produto.preco_produto'
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_estoque' => $this->id_estoque,
            'tb_estoque.num_produto' => $this->num_produto,
            'qtd_itens' => $this->qtd_itens,
        ]);

        $query->andFilterWhere(['like', 'endereco_item', $this->endereco_item]);
        $query->andFilterWhere(['like', 'tb_produto.nome_produto', $nome_produto]);

        return $dataProvider;
    }
}
