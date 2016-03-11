<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user', 'payment', 'delivery', 'status'], 'integer'],
            [['data_start', 'data_finish', 'name', 'soname', 'email', 'phone', 'adress', 'code', 'city', 'country', 'agent', 'region', 'fax', 'icq', 'skape', 'coment_admin'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Order::find();
        if(!Yii::$app->request->get('sort')){
            $query->orderBy('id desc');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where('user = :user', [':user' => Yii::$app->user->id]);
        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'payment' => $this->payment,
            'delivery' => $this->delivery,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'data_start', $this->data_start])
            ->andFilterWhere(['like', 'data_finish', $this->data_finish])
            ->andFilterWhere(['like', 'soname', $this->soname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'agent', $this->agent])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'icq', $this->icq])
            ->andFilterWhere(['like', 'skape', $this->skape])
            ->andFilterWhere(['like', 'coment_admin', $this->coment_admin]);

        return $dataProvider;
    }
}
