<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbLocalDeposito;

/**
 * TbLocalDepositoSearch represents the model behind the search form of `app\models\TbLocalDeposito`.
 */
class TbLocalDepositoSearch extends TbLocalDeposito
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_local_deposito'], 'integer'],
            [['nome_deposito', 'endereco_deposito', 'uf'], 'safe'],
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
        $query = TbLocalDeposito::find();

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
            'id_local_deposito' => $this->id_local_deposito,
        ]);

        $query->andFilterWhere(['like', 'nome_deposito', $this->nome_deposito])
            ->andFilterWhere(['like', 'endereco_deposito', $this->endereco_deposito])
            ->andFilterWhere(['like', 'uf', $this->uf]);

        return $dataProvider;
    }
}
