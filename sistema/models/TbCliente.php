<?php

namespace app\models;

use Yii;
use app\validators\CPFCNPJValidator;

/**
 * This is the model class for table "tb_cliente".
 *
 * @property string $cpf_cnpj
 * @property string $nome
 * @property string $data_nascimento
 * @property string $email
 * @property string $telefone
 * @property string $cep
 * @property string $rua
 * @property int $numero
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
            [['cpf_cnpj', 'nome', 'data_nascimento', 'email', 'telefone', 'cep', 'rua', 'numero', 'bairro', 'cidade', 'uf'], 'required'],
            ['cpf_cnpj', 'string', 'min' => 11, 'max' => 18],
            [['cpf_cnpj'], CPFCNPJValidator::class],
            [['data_nascimento'], 'safe'],
            [['numero'], 'integer'],
            //[['cpf_cnpj'], 'string', 'max' => 14],
            [['nome', 'email', 'rua', 'complemento'], 'string', 'max' => 255],
            [['email'], 'email'], // Esta é a regra para validar um e-mail
            [['telefone'], 'string', 'min' => 10, 'max' => 15],
            [['cep'], 'string', 'max' => 9],
            [['bairro', 'cidade'], 'string', 'max' => 100],
            [['uf'], 'string', 'max' => 2],
            [['cpf_cnpj'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cpf_cnpj' => Yii::t('app', 'Cpf Cnpj'),
            'nome' => Yii::t('app', 'Nome'),
            'data_nascimento' => Yii::t('app', 'Data Nascimento'),
            'email' => Yii::t('app', 'Email'),
            'telefone' => Yii::t('app', 'Telefone'),
            'cep' => Yii::t('app', 'Cep'),
            'rua' => Yii::t('app', 'Rua'),
            'numero' => Yii::t('app', 'Numero'),
            'complemento' => Yii::t('app', 'Complemento'),
            'bairro' => Yii::t('app', 'Bairro'),
            'cidade' => Yii::t('app', 'Cidade'),
            'uf' => Yii::t('app', 'Uf'),
        ];
    }

    //Para o select2
    public static function getCpfCliente()
    {
        $clientes = self::find()->all();
        $data = [];
        foreach ($clientes as $cliente) {
            $data[$cliente->cpf_cnpj] = $cliente->cpf_cnpj;
            /*$data[$cliente->nome] = $cliente->nome;
            $data[$cliente->data_nascimento] = $cliente->data_nascimento;
            $data[$cliente->telefone] = $cliente->telefone;
            $data[$cliente->email] = $cliente->email;
            $data[$cliente->rua] = $cliente->rua;
            $data[$cliente->numero] = $cliente->numero;
            $data[$cliente->complemento] = $cliente->complemento;
            $data[$cliente->bairro] = $cliente->bairro;
            $data[$cliente->cidade] = $cliente->cidade;
            $data[$cliente->uf] = $cliente->uf;
            $data[$cliente->cep] = $cliente->cep;*/
        }
        return $data;
    }
    //Para o select2
    public static function getNomeCliente()
    {
        $clientes = self::find()->all();
        $data = [];
        foreach ($clientes as $cliente) {
            //$data[$cliente->cpf_cnpj] = $cliente->cpf_cnpj;
            $data[$cliente->nome] = $cliente->nome;
            /*$data[$cliente->data_nascimento] = $cliente->data_nascimento;
            $data[$cliente->telefone] = $cliente->telefone;
            $data[$cliente->email] = $cliente->email;
            $data[$cliente->rua] = $cliente->rua;
            $data[$cliente->numero] = $cliente->numero;
            $data[$cliente->complemento] = $cliente->complemento;
            $data[$cliente->bairro] = $cliente->bairro;
            $data[$cliente->cidade] = $cliente->cidade;
            $data[$cliente->uf] = $cliente->uf;
            $data[$cliente->cep] = $cliente->cep;*/
        }
        return $data;
    }

    //Para o javascript de preenchimento automático
    public static function getClientesCpfCnpj($cpf_cnpj)
    {
        $cliente = TbCliente::find()
        ->where(['cpf_cnpj' => $cpf_cnpj])
        ->one();

        //var_dump($produtos);

        //return $produtos;

        $itens[] =[

            $cliente['cpf_cnpj'],
            $cliente['nome'],
            $cliente['data_nascimento'],
            $cliente['telefone'],
            $cliente['email'],
            $cliente['rua'],
            $cliente['numero'],
            $cliente['complemento'],
            $cliente['bairro'],
            $cliente['cidade'],
            $cliente['uf'],
            $cliente['cep'],
        ];

        foreach($itens as $data){
            return $data;
        }



        /*$data = [];
        foreach ($produtos as $produto) {
            $data[$produto->num_produto] = $produto->num_produto;
            $data[$produto->nome_produto] = $produto->nome_produto;
            $data[$produto->estado_produto] = $produto->estado_produto;
            $data[$produto->preco_produto] = $produto->preco_produto;
        }
        return $data;*/
    }

    //Para o javascript de preenchimento automático
    public static function getClientesNome($nome)
    {
        $cliente = TbCliente::find()
        ->where(['nome' => $nome])
        ->one();

        //var_dump($produtos);

        //return $produtos;

        $itens[] =[

            $cliente['cpf_cnpj'],
            $cliente['nome'],
            $cliente['data_nascimento'],
            $cliente['telefone'],
            $cliente['email'],
            $cliente['rua'],
            $cliente['numero'],
            $cliente['complemento'],
            $cliente['bairro'],
            $cliente['cidade'],
            $cliente['uf'],
            $cliente['cep'],
        ];

        foreach($itens as $data){
            return $data;
        }



        /*$data = [];
        foreach ($produtos as $produto) {
            $data[$produto->num_produto] = $produto->num_produto;
            $data[$produto->nome_produto] = $produto->nome_produto;
            $data[$produto->estado_produto] = $produto->estado_produto;
            $data[$produto->preco_produto] = $produto->preco_produto;
        }
        return $data;*/
    }
}
