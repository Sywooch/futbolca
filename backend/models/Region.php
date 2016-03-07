<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property string $id
 * @property string $country
 * @property string $name
 *
 * @property City[] $cities
 * @property Country $country0
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['country'], 'integer'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country' => Yii::t('app', 'Country'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['region' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }

    public static function listDrop($country = 0, $name = null){
        if($country > 0){
            return ArrayHelper::map(self::find()->where("country = :country", [':country' => $country])->orderBy('name asc')->all(), 'id', 'name');
        }
        if($name){
            $name = $name.'%';
            return ArrayHelper::map(self::find()->where("name LIKE :name", [':name' => $name])->orderBy('name asc')->all(), 'id', 'name');
        }
        return ArrayHelper::map(self::find()->orderBy('name asc')->all(), 'id', 'name');
    }
}
