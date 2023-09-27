<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbHistoricoConsumo;

/**
 * TbHistoricoConsumoSearch represents the model behind the search form of `app\models\TbHistoricoConsumo`.
 */
class TbHistoricoConsumoSearch extends TbHistoricoConsumo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_consumo', 'id_estoque', 'id_num_produto', 'qtd_consumida'], 'integer'],
            [['data_consumo', 'id_cliente_cpf_cnpj'], 'safe'],
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
        $query = TbHistoricoConsumo::find();

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
            'id_consumo' => $this->id_consumo,
            'id_estoque' => $this->id_estoque,
            'id_num_produto' => $this->id_num_produto,
            'id_cliente_cpf_cnpj' => $this->id_cliente_cpf_cnpj,
            'qtd_consumida' => $this->qtd_consumida,
            'data_consumo' => $this->data_consumo,
        ]);

        return $dataProvider;
    }
}
