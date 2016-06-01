<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Element;

/**
 * ModelSearch represents the model behind the search form about `backend\models\Model`.
 */
class ElementSearch extends Element
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stock', 'home', 'fashion', 'toppx', 'leftpx', 'price', 'increase', 'position'], 'integer'],
            [['name', 'size', 'photo'], 'safe'],
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
        $query = Element::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'stock' => $this->stock,
            'home' => $this->home,
            'fashion' => $this->fashion,
            'toppx' => $this->toppx,
            'leftpx' => $this->leftpx,
            'price' => $this->price,
            'increase' => $this->increase,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
