<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%fashion}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $price
 * @property string $active
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

    public static function listActive(){
        return [
            'active' => Yii::t('app', 'Активный'),
            'hide' => Yii::t('app', 'Скрытый'),
        ];
    }

    public static function getActiveName($id){
        return isset(self::listActive()[$id]) ? self::listActive()[$id] : null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['price'], 'integer'],
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

    public static function getToList(){
        return ArrayHelper::map(self::find()->orderBy('id asc')->all(), 'id', 'name');
    }
}
