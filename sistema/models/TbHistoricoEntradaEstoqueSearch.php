<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbHistoricoEntradaEstoque;

/**
 * TbHistoricoEntradaEstoqueSearch represents the model behind the search form of `app\models\TbHistoricoEntradaEstoque`.
 */
class TbHistoricoEntradaEstoqueSearch extends TbHistoricoEntradaEstoque
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_historico_entrada_estoque', 'id_local_deposito', 'id_estoque', 'num_produto', 'qtd_inclusao', 'id_local_deposito_anterior', 'id_usuario_inclusao'], 'integer'],
            [['data_inclusao', 'tipo_entrada'], 'safe'],
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
        $query = TbHistoricoEntradaEstoque::find();

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
            'id_historico_entrada_estoque' => $this->id_historico_entrada_estoque,
            'id_local_deposito' => $this->id_local_deposito,
            'id_estoque' => $this->id_estoque,
            'num_produto' => $this->num_produto,
            'data_inclusao' => $this->data_inclusao,
            'qtd_inclusao' => $this->qtd_inclusao,
            'id_local_deposito_anterior' => $this->id_local_deposito_anterior,
            'id_usuario_inclusao' => $this->id_usuario_inclusao,
        ]);

        $query->andFilterWhere(['like', 'tipo_entrada', $this->tipo_entrada]);

        return $dataProvider;
    }
}
