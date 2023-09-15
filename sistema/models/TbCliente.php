<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_cliente".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $data_nascimento
 * @property string $cpf_cnpj
 * @property string $email
 * @property string $telefone
 * @property string $cep
 * @property string $rua
 * @property string|null $complemento
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 */
class TbCliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'cpf_cnpj', 'email', 'telefone', 'cep', 'rua','numero', 'bairro', 'cidade', 'uf'], 'required'],
            [['data_nascimento'], 'safe'],
            [['nome', 'email', 'rua', 'complemento'], 'string', 'max' => 255],
            [['cpf_cnpj'], 'string', 'max' => 14],
            [['telefone'], 'string', 'max' => 11],
            [['cep'], 'string', 'max' => 8],
            [['bairro', 'cidade'], 'string', 'max' => 100],
            [['uf'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'data_nascimento' => Yii::t('app', 'Data Nascimento'),
            'cpf_cnpj' => Yii::t('app', 'Cpf Cnpj'),
            'email' => Yii::t('app', 'Email'),
            'telefone' => Yii::t('app', 'Telefone'),
            'cep' => Yii::t('app', 'Cep'),
            'rua' => Yii::t('app', 'Rua'),
            'numero' => Yii::t('app', 'Número'),
            'complemento' => Yii::t('app', 'Complemento'),
            'bairro' => Yii::t('app', 'Bairro'),
            'cidade' => Yii::t('app', 'Cidade'),
            'uf' => Yii::t('app', 'Uf'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TbClienteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbClienteQuery(get_called_class());
    }
}
