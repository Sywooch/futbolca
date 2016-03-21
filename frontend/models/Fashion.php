<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%fashion}}".
 *
 * @property string $id
 * @property string $old
 * @property string $name
 * @property integer $price
 * @property string $active
 *
 * @property Element[] $elements
 */
class Fashion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fashion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'trim'],
            [['name'], 'filter', 'filter' => 'strip_tags'],
            [['name'], 'required'],
            [['price', 'old'], 'integer'],
            [['active'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElements()
    {
        return $this->hasMany(Element::className(), ['fashion' => 'id']);
    }

    public static function getBuItem($elementsForFashions, $model){
        $elementsForFashions = ArrayHelper::map($elementsForFashions, 'fashion', 'fashion');
        return Fashion::find()
            ->where(['in', 'id', $elementsForFashions])
            ->andWhere("id <> :id", [':id' => $model->element0->fashion])
            ->orderBy('id asc')
            ->all();
    }
}
